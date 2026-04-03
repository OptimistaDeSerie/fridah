<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\DeliveryFee;
use App\Models\State;
use App\Models\Weight;
use App\Models\Carrier;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\HomeSlider;
use App\Models\PopularCategorySlider;
use App\Models\HotDealProduct;
use App\Models\HomeBanner;
use App\Models\ShopBanner;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{
    public function index(){
        $counterdata = DB::select("
            Select sum(total) As TotalAmount,
            sum(if(status='ordered',total,0)) As TotalOrderedAmount,
            sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
            sum(if(status='canceled',total,0)) As TotalCanceledAmount,
            Count(*) As Total,
            sum(if(status='ordered',1,0)) As TotalOrdered,
            sum(if(status='delivered',1,0)) As TotalDelivered,
            sum(if(status='canceled',1,0)) As TotalCanceled
            From orders"
        );

        // Monthly breakdown (no month_names table)
        $monthlyDatas = DB::select("
            SELECT 
                MONTH(created_at) AS MonthId,
                DATE_FORMAT(MIN(created_at), '%M') AS MonthName,
                SUM(total) AS TotalAmount,
                SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount
            FROM orders
            WHERE YEAR(created_at) = YEAR(CURDATE())
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY MONTH(created_at)
        ");

        // Prepare arrays for chart usage
        $amountM = implode(',', collect($monthlyDatas)->pluck('MonthName')->toArray());
        $orderedAmount = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $deliveredAmount = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $canceledAmount = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        // Totals across months
        $totalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $totalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $totalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $totalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index', compact(
            'counterdata',
            'monthlyDatas',
            'amountM',
            'orderedAmount',
            'deliveredAmount',
            'canceledAmount',
            'totalAmount',
            'totalOrderedAmount',
            'totalDeliveredAmount',
            'totalCanceledAmount'
        ));
    }

    public function categories(){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view("admin.categories",compact('categories'));
    }

    public function add_category(){
        return view("admin.category-add");
    }

    public function add_category_save(Request $request){      
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbailImage($image,$file_name);
        $category->image = $file_name;        
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added successfully !');
    }

    public function GenerateCategoryThumbailImage($image, $image_name){
        $destination_path = public_path('backend/uploads/categories');
        $img = Image::read($image->Path());
        $img->Cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $image_name);
    }

    public function edit_category($id){
        $category = Category::find($id);
        return view('admin.category-edit',compact('category'));
    }

    public function update_category(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        if($request->hasFile('image'))
        {            
            if (File::exists(public_path('backend/uploads/categories').'/'.$category->image)) {
                File::delete(public_path('backend/uploads/categories').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbailImage($image,$file_name);   
            $category->image = $file_name;
        }        
        $category->save();    
        return redirect()->route('admin.categories')->with('status','Category has been updated successfully !');
    }

    public function delete_category($id){
        $category = Category::find($id);
        if (File::exists(public_path('backend/uploads/categories').'/'.$category->image)) {
            File::delete(public_path('backend/uploads/categories').'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status','Category has been deleted successfully !');
    }

    public function products(){
        // Eager load sizes and category to avoid N+1 queries
        $products = Product::with(['sizes', 'category'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view("admin.products", compact('products'));
    }

    public function add_product(){
        $categories = Category::Select('id','name')->orderBy('name')->get();
        return view("admin.product-add",compact('categories'));
    }

    public function product_save(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'slug'=>'required|unique:products,slug',
            'category_id'=>'required',           
            'short_description'=>'required|max:255',
            'description'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg|max:2048',
            //  New validation for sizes
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:50',
            'sizes.*.regular_price' => 'required|numeric|min:0',
            'sizes.*.sale_price' => 'required|numeric|min:0',
            'sizes.*.quantity' => 'required|integer|min:0',     
        ]);
        DB::transaction(function () use ($request) {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->slug ?? $request->name); //  Use provided slug or auto-generate
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->SKU = $this->generateSKU();
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;
            $product->category_id = $request->category_id;

            $current_timestamp = Carbon::now()->timestamp;

            //  Handle main product image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();
                $this->GenerateProductThumbnailImage($image, $imageName);
                $product->image = $imageName;
            }

            //  Handle gallery images
            $gallery_arr = [];
            $counter = 1;
            if ($request->hasFile('images')) {
                $allowedfileExtension = ['jpg', 'png', 'jpeg'];
                $files = $request->file('images');
                foreach ($files as $file) {
                    $gextension = $file->getClientOriginalExtension();
                    if (in_array(strtolower($gextension), $allowedfileExtension)) {
                        $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                        $this->GenerateProductThumbnailImage($file, $gfilename);
                        $gallery_arr[] = $gfilename;
                        $counter++;
                    }
                }
            }
            $product->images = implode(',', $gallery_arr);
            //  Save the product first to get the ID
            $product->save();
            //  Now create all sizes for this product
            foreach ($request->sizes as $sizeData) {
                $product->sizes()->create([
                    'size' => trim($sizeData['size']),
                    'regular_price' => $sizeData['regular_price'],
                    'sale_price' => $sizeData['sale_price'],
                    'quantity' => $sizeData['quantity'],
                ]);
            }
        });
        return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
    }

    public function GenerateProductThumbnailImage($image, $image_name){
        $destination_path = public_path('backend/uploads/products');
        $img = Image::read($image->Path());
        $img->Cover(400, 400, "top");
        $img->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $image_name);
        
        // Save thumbnail
        $thumbnail_path = public_path('backend/uploads/products/thumbnails');
        $img->resize(158, 158, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnail_path . '/' . $image_name);
    }

    public function edit_product($id){
        $product = Product::with('sizes')->findOrFail($id); //  Eager load sizes
        $categories = Category::Select('id','name')->orderBy('name')->get();
        return view('admin.product-edit',compact('product','categories'));
    }

    public function update_product(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'slug'=>'required|unique:products,slug,'.$request->id,
            'category_id'=>'required',          
            'short_description'=>'required|max:255',
            'description'=>'required',
            'SKU'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'image'=>'nullable|mimes:png,jpg,jpeg|max:2048', // Make image optional
            //  New validation for sizes
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:50',
            'sizes.*.regular_price' => 'required|numeric|min:0',
            'sizes.*.sale_price' => 'required|numeric|min:0',
            'sizes.*.quantity' => 'required|integer|min:0',
        ]);
        
        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->id);
            // Update basic product info
            $product->name = $request->name;
            $product->slug = Str::slug($request->slug ?? $request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;
            $product->category_id = $request->category_id;
            $current_timestamp = Carbon::now()->timestamp;
            //  Handle main image (optional)
            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image && File::exists(public_path('backend/uploads/products') . '/' . $product->image)) {
                    File::delete(public_path('backend/uploads/products') . '/' . $product->image);
                }
                if ($product->image && File::exists(public_path('backend/uploads/products/thumbnails') . '/' . $product->image)) {
                    File::delete(public_path('backend/uploads/products/thumbnails') . '/' . $product->image);
                }
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();
                $this->GenerateProductThumbnailImage($image, $imageName);
                $product->image = $imageName;
            }

            //  Handle gallery images (optional)
            if ($request->hasFile('images')) {
                // Delete old gallery images
                if ($product->images) {
                    $oldGImages = explode(",", $product->images);
                    foreach ($oldGImages as $gimage) {
                        $gimage = trim($gimage);
                        if ($gimage && File::exists(public_path('backend/uploads/products') . '/' . $gimage)) {
                            File::delete(public_path('backend/uploads/products') . '/' . $gimage);
                        }
                        if ($gimage && File::exists(public_path('backend/uploads/products/thumbnails') . '/' . $gimage)) {
                            File::delete(public_path('backend/uploads/products/thumbnails') . '/' . $gimage);
                        }
                    }
                }
                // Add new gallery images
                $gallery_arr = [];
                $counter = 1;
                $allowedfileExtension = ['jpg', 'png', 'jpeg'];
                $files = $request->file('images');
                foreach ($files as $file) {
                    $gextension = $file->getClientOriginalExtension();
                    if (in_array(strtolower($gextension), $allowedfileExtension)) {
                        $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                        $this->GenerateProductThumbnailImage($file, $gfilename);
                        $gallery_arr[] = $gfilename;
                        $counter++;
                    }
                }
                $product->images = implode(',', $gallery_arr);
            }
            //  Save product first
            $product->save();
            //  Sync sizes (delete old, create new)
            $existingSizeIds = collect($request->sizes)->pluck('id')->filter()->toArray();
            $product->sizes()->whereNotIn('id', $existingSizeIds)->delete(); //  Delete removed sizes
            foreach ($request->sizes as $index => $sizeData) {
                if (isset($sizeData['id']) && $sizeData['id']) {
                    //  Update existing size
                    $product->sizes()->find($sizeData['id'])->update([
                        'size' => trim($sizeData['size']),
                        'regular_price' => $sizeData['regular_price'],
                        'sale_price' => $sizeData['sale_price'],
                        'quantity' => $sizeData['quantity'],
                    ]);
                } else {
                    //  Create new size
                    $product->sizes()->create([
                        'size' => trim($sizeData['size']),
                        'regular_price' => $sizeData['regular_price'],
                        'sale_price' => $sizeData['sale_price'],
                        'quantity' => $sizeData['quantity'],
                    ]);
                }
            }
        });
        return redirect()->route('admin.products')->with('status', 'Product has been updated successfully!');
    }

    public function delete_product($id){
        DB::transaction(function () use ($id) {
            $product = Product::with('sizes')->findOrFail($id); //  Load with sizes for safety
            //  Delete main product image + thumbnail
            if ($product->image) {
                $mainImagePath = public_path('backend/uploads/products') . '/' . $product->image;
                $mainThumbnailPath = public_path('backend/uploads/products/thumbnails') . '/' . $product->image;

                if (File::exists($mainImagePath)) {
                    File::delete($mainImagePath);
                }
                if (File::exists($mainThumbnailPath)) {
                    File::delete($mainThumbnailPath);
                }
            }
            //  Delete all gallery images + thumbnails
            if ($product->images) {
                $galleryImages = explode(",", $product->images);
                foreach ($galleryImages as $gimage) {
                    $gimage = trim($gimage);
                    if (!$gimage) continue;
                    $galleryImagePath = public_path('backend/uploads/products') . '/' . $gimage;
                    $galleryThumbnailPath = public_path('backend/uploads/products/thumbnails') . '/' . $gimage;
                    if (File::exists($galleryImagePath)) {
                        File::delete($galleryImagePath);
                    }
                    if (File::exists($galleryThumbnailPath)) {
                        File::delete($galleryThumbnailPath);
                    }
                }
            }
            //  Delete the product (this will cascade delete all product_sizes due to foreign key constraint)
            $product->delete();
        });

        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    private function generateSKU(){
        do {
            $sku = 'PRD-' . strtoupper(Str::random(6)) . '-' . now()->timestamp;
        } while (Product::where('SKU', $sku)->exists());
        return $sku;
    }

    public function deliveryFees(Request $request){
        if ($request->ajax()) {
            $query = DeliveryFee::select('delivery_fees.*')
                ->join('states', 'delivery_fees.state_id', '=', 'states.id')
                ->join('carriers', 'delivery_fees.carrier_id', '=', 'carriers.id')
                ->join('weights', 'delivery_fees.weight_id', '=', 'weights.id')
                ->with(['state', 'carrier', 'weight']); // Keep for display purposes

            return DataTables::of($query)
                ->addColumn('state.title', function ($fee) {
                    return $fee->state->title ?? '';
                })
                ->addColumn('carrier.title', function ($fee) {
                    return $fee->carrier->title ?? '';
                })
                ->addColumn('weight.title', function ($fee) {
                    return $fee->weight->title ?? '';
                })
                ->addColumn('price', function ($fee) {
                    return $fee->price;
                })
                ->addColumn('actions', function ($fee) {
                    return '
                        <div class="list-icon-function">
                            <a href="' . route('admin.delivery-fee.edit', ['id' => $fee->id]) . '">
                                <div class="item edit"><i class="icon-edit-3"></i></div>
                            </a>
                            <form action="' . route('admin.delivery-fee.delete', ['id' => $fee->id]) . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
                            </form>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.delivery-fees');
    }

    public function addDeliveryFee(){
        $states = State::select('id', 'title')->orderBy('title')->get();
        $carriers = Carrier::select('id', 'title')->orderBy('title')->get();
        $weights = Weight::select('id', 'title')->orderBy('title')->get();
        return view('admin.delivery-fee-add', compact('states', 'carriers', 'weights'));
    }

    public function saveDeliveryFee(Request $request){
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'carrier_id' => 'required|exists:carriers,id',
            'weight_id' => 'required|exists:weights,id',
            'price' => 'required|numeric|min:0',
        ]);

        DeliveryFee::create([
            'state_id' => $request->state_id,
            'carrier_id' => $request->carrier_id,
            'weight_id' => $request->weight_id,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.delivery-fees')->with('success', 'Delivery fee added successfully.');
    }

    public function editDeliveryFee($id){
        $fee = DeliveryFee::findOrFail($id);
        $states = State::select('id', 'title')->orderBy('title')->get();
        $carriers = Carrier::select('id', 'title')->orderBy('title')->get();
        $weights = Weight::select('id', 'title')->orderBy('title')->get();

        return view('admin.delivery-fee-edit', compact('fee', 'states', 'carriers', 'weights'));
    }

    public function updateDeliveryFee(Request $request){
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'carrier_id' => 'required|exists:carriers,id',
            'weight_id' => 'required|exists:weights,id',
            'price' => 'required|numeric|min:0',
        ]);

        $fee = DeliveryFee::findOrFail($request->id);
        $fee->update([
            'state_id' => $request->state_id,
            'carrier_id' => $request->carrier_id,
            'weight_id' => $request->weight_id,
            'price' => $request->price,
        ]);
        return redirect()->route('admin.delivery-fees')->with('success', 'Delivery fee updated successfully.');
    }

    public function deleteDeliveryFee($id){
        $fee = DeliveryFee::findOrFail($id);
        $fee->delete();
        return redirect()->route('admin.delivery-fees')->with('success', 'Delivery fee deleted successfully.');
    }

    public function carriers(Request $request){
        if ($request->ajax()) {
            $query = Carrier::select('carriers.*');
            return DataTables::of($query)
                ->addColumn('actions', function ($carrier) {
                    return '
                        <div class="list-icon-function">
                            <a href="' . route('admin.carrier.edit', ['id' => $carrier->id]) . '">
                                <div class="item edit"><i class="icon-edit-3"></i></div>
                            </a>
                            <form action="' . route('admin.carrier.delete', ['id' => $carrier->id]) . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
                            </form>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.carriers');
    }

    public function addCarrier(){
        return view('admin.carrier-add');
    }

    public function saveCarrier(Request $request){
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        Carrier::create([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.carriers')->with('success', 'Carrier added successfully.');
    }

    public function editCarrier($id){
        $carrier = Carrier::findOrFail($id);
        return view('admin.carrier-edit', compact('carrier'));
    }

    public function updateCarrier(Request $request){
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        $carrier = Carrier::findOrFail($request->id);
        $carrier->update([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.carriers')->with('success', 'Carrier updated successfully.');
    }

    public function deleteCarrier($id){
        $carrier = Carrier::findOrFail($id);
        $carrier->delete();
        return redirect()->route('admin.carriers')->with('success', 'Carrier deleted successfully.');
    }

    public function weights(Request $request){
        if ($request->ajax()) {
            $query = Weight::select('weights.*');
            return DataTables::of($query)
                ->addColumn('actions', function ($weight) {
                    return '
                        <div class="list-icon-function">
                            <a href="' . route('admin.weight.edit', ['id' => $weight->id]) . '">
                                <div class="item edit"><i class="icon-edit-3"></i></div>
                            </a>
                            <form action="' . route('admin.weight.delete', ['id' => $weight->id]) . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
                            </form>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.weights');
    }

    public function addWeight(){
        return view('admin.weight-add');
    }

    public function saveWeight(Request $request){
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        Weight::create([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.weights')->with('success', 'Weight added successfully.');
    }

    public function editWeight($id){
        $weight = Weight::findOrFail($id);
        return view('admin.weight-edit', compact('weight'));
    }

    public function updateWeight(Request $request){
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        $weight = Weight::findOrFail($request->id);
        $weight->update([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.weights')->with('success', 'Weight updated successfully.');
    }

    public function deleteWeight($id){
        $weight = Weight::findOrFail($id);
        $weight->delete();
        return redirect()->route('admin.weights')->with('success', 'Weight deleted successfully.');
    }

    public function orders(Request $request){
        if ($request->ajax()) {
            $query = Order::select('orders.*', 'users.firstname', 'users.lastname', 'users.phone')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->orderByDesc('orders.created_at');
            return DataTables::of($query)
                ->addColumn('user', function ($order) {
                    return $order->firstname . ' ' . $order->lastname;
                })
                ->filterColumn('user', function($query, $keyword) {
                    $sql = "CONCAT(users.firstname, ' ', users.lastname) LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('phone', function ($order) {
                    return $order->phone;
                })
                ->addColumn('subtotal', function ($order) {
                    return '₦' . number_format($order->subtotal, 2);
                })
                ->addColumn('total', function ($order) {
                    return '₦' . number_format($order->total, 2);
                })
                ->addColumn('status', function ($order) {
                    if ($order->status == 'delivered') {
                        return '<span class="badge bg-success text-white">Delivered</span>';
                    } elseif ($order->status == 'canceled') {
                        return '<span class="badge bg-danger text-white">Canceled</span>';
                    } else {
                        return '<span class="badge bg-warning text-white">Ordered</span>';
                    }
                })
                ->addColumn('order_date', function ($order) {
                    return $order->created_at->format('d M, Y H:i');
                })
                ->addColumn('total_items', function ($order) {
                    return $order->orderItems->sum('quantity') ;
                })
                ->addColumn('order_no', function ($order) {
                    return $order->order_no ? $order->order_no : '';
                })
                ->addColumn('actions', function ($order) {
                    return '
                        <div class="list-icon-function">
                            <a href="' . route('admin.order.item', ['id' => $order->id]) . '">
                                <div class="order item"><i class="icon-eye"></i></div>
                            </a>
                        </div>';
                })
                ->rawColumns(['status','actions'])
                ->make(true);
        }
        return view('admin.orders');
    }

    public function orderItem($order_id){
        /* This is a Join query that avoids performance issues with multiple queries (N+1) */
        $order = Order::with([
            'defaultAddress.deliveryFee.state',
            'defaultAddress.deliveryFee.carrier',
            'orderItems',
            'transaction'
        ])->findOrFail($order_id);
        $transaction = $order->transaction;
        $orderitems  = $order->orderItems()->orderBy('id')->paginate(12);
        return view('admin.order-details', compact('order', 'orderitems', 'transaction'));
    }

    public function update_order_status(Request $request){      
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status=='delivered'){
            $order->delivered_date = Carbon::now();
        }
        else if($request->order_status=='canceled'){
            $order->canceled_date = Carbon::now();
        }        
        $order->save();
        if($request->order_status=='delivered'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        else if($request->order_status=='ordered'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'pending';
            $transaction->save();
        }else if($request->order_status=='canceled'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'pending';
            $transaction->save();
        }
        return back()->with('status', 'Status changed successfully!');
    }

    public function sliders(){
        $sliders = HomeSlider::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->paginate(10);
        return view("admin.sliders", compact('sliders'));
    }

    public function add_slider(){
        return view("admin.slider-add");
    }

    public function add_slider_save(Request $request){
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|mimes:png,jpg,jpeg|max:5048' // larger for banners
        ]);

        $slider = new HomeSlider();
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->short_text = $request->short_text;
        $slider->description = $request->description;
        $slider->offer_text = $request->offer_text;
        $slider->text_position = $request->text_position ?? 'left';
        $slider->sort_order = $request->sort_order ?? 0;
        $slider->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateSliderImage($image, $file_name);
            $slider->image = $file_name;
        }

        $slider->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider has been added successfully!');
    }

    public function GenerateSliderImage($image, $image_name){
        $destination_path = public_path('backend/uploads/sliders');
        if (!File::exists($destination_path)) {
            File::makeDirectory($destination_path, 0755, true);
        }

        $img = Image::read($image->path());
        // Resize to fit typical banner size, maintain aspect ratio
        $img->resize(1903, 520, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destination_path . '/' . $image_name);
    }

    public function edit_slider($id){
        $slider = HomeSlider::findOrFail($id);
        return view('admin.slider-edit', compact('slider'));
    }

    public function update_slider(Request $request){
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:5048'
        ]);

        $slider = HomeSlider::findOrFail($request->id);
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->short_text = $request->short_text;
        $slider->description = $request->description;
        $slider->offer_text = $request->offer_text;
        $slider->text_position = $request->text_position ?? 'left';
        $slider->sort_order = $request->sort_order ?? 0;
        $slider->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path('backend/uploads/sliders') . '/' . $slider->image)) {
                File::delete(public_path('backend/uploads/sliders') . '/' . $slider->image);
            }

            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateSliderImage($image, $file_name);
            $slider->image = $file_name;
        }

        $slider->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider has been updated successfully!');
    }

    public function delete_slider($id){
        $slider = HomeSlider::findOrFail($id);

        if (File::exists(public_path('backend/uploads/sliders') . '/' . $slider->image)) {
            File::delete(public_path('backend/uploads/sliders') . '/' . $slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders')->with('success', 'Slider has been deleted successfully!');
    }

    public function popular_categories(){
        $items = PopularCategorySlider::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->paginate(10);
        return view("admin.popular-categories", compact('items'));
    }

    public function add_popular_category(){
        return view("admin.popular-category-add");
    }

    public function add_popular_category_save(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'count_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'image' => 'required|mimes:png,jpg,jpeg|max:5048'
        ]);

        $item = new PopularCategorySlider();
        $item->title = $request->title;
        $item->count_text = $request->count_text;
        $item->link_url = $request->link_url;
        $item->sort_order = $request->sort_order ?? 0;
        $item->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $this->GeneratePopularCategoryImage($image, $file_name);
            $item->image = $file_name;
        }

        $item->save();

        return redirect()->route('admin.popular.categories')->with('success', 'Popular category added successfully!');
    }

    public function GeneratePopularCategoryImage($image, $image_name){
        $destination_path = public_path('backend/uploads/popular-categories');
        if (!File::exists($destination_path)) {
            File::makeDirectory($destination_path, 0755, true);
        }

        $img = Image::read($image->path());
        $img->resize(341, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destination_path . '/' . $image_name);
    }

    public function edit_popular_category($id){
        $item = PopularCategorySlider::findOrFail($id);
        return view('admin.popular-category-edit', compact('item'));
    }

    public function update_popular_category(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'count_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:5048'
        ]);

        $item = PopularCategorySlider::findOrFail($request->id);
        $item->title = $request->title;
        $item->count_text = $request->count_text;
        $item->link_url = $request->link_url;
        $item->sort_order = $request->sort_order ?? 0;
        $item->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            // Delete old
            if (File::exists(public_path('backend/uploads/popular-categories/' . $item->image))) {
                File::delete(public_path('backend/uploads/popular-categories/' . $item->image));
            }

            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $this->GeneratePopularCategoryImage($image, $file_name);
            $item->image = $file_name;
        }

        $item->save();

        return redirect()->route('admin.popular.categories')->with('success', 'Popular category updated successfully!');
    }

    public function delete_popular_category($id){
        $item = PopularCategorySlider::findOrFail($id);

        if (File::exists(public_path('backend/uploads/popular-categories/' . $item->image))) {
            File::delete(public_path('backend/uploads/popular-categories/' . $item->image));
        }

        $item->delete();

        return redirect()->route('admin.popular.categories')->with('success', 'Popular category deleted successfully!');
    }

    public function hot_deals(){
        $items = HotDealProduct::with(['product' => function ($q) {
                $q->with('sizes'); // Load sizes so we can compute price range
            }])
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'DESC')
                ->paginate(10);
        return view('admin.hot-deals', compact('items'));
    }

    public function add_hot_deal(){
        $products = Product::orderBy('name', 'ASC')->get(['id', 'name']);
        return view('admin.hot-deal-add', compact('products'));
    }

    public function add_hot_deal_save(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:hot_deal_products,product_id'
        ]);

        $item = new HotDealProduct();
        $item->product_id = $request->product_id;
        $item->show_hot_label = $request->boolean('show_hot_label');
        $item->sort_order = $request->sort_order ?? 0;
        $item->status = $request->boolean('status');
        $item->save();

        return redirect()->route('admin.hot.deals')->with('success', 'Product added to Hot Deals successfully!');
    }

    public function edit_hot_deal($id){
        $item = HotDealProduct::with('product')->findOrFail($id);
        $products = Product::orderBy('name', 'ASC')->get(['id', 'name']);
        return view('admin.hot-deal-edit', compact('item', 'products'));
    }

    public function update_hot_deal(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:hot_deal_products,product_id,' . $request->id,
            'show_hot_label' => 'boolean',
            'sort_order' => 'integer|min:0',
            'status' => 'boolean'
        ]);

        $item = HotDealProduct::findOrFail($request->id);
        $item->product_id = $request->product_id;
        $item->show_hot_label = $request->boolean('show_hot_label');
        $item->sort_order = $request->sort_order ?? 0;
        $item->status = $request->boolean('status');
        $item->save();

        return redirect()->route('admin.hot.deals')->with('success', 'Hot deal updated successfully!');
    }

    public function delete_hot_deal($id){
        HotDealProduct::findOrFail($id)->delete();
        return redirect()->route('admin.hot.deals')->with('success', 'Product removed from Hot Deals!');
    }

    public function banners(){
        $banners = HomeBanner::orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('admin.home-banners', compact('banners'));
    }

    public function add_banner(){
        return view('admin.home-banner-add');
    }

    public function add_banner_save(Request $request){
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'banner_type' => 'required|in:left,right',
            'image'       => 'required|image|mimes:png,jpg,jpeg|max:5048',
        ]);

        $banner = new HomeBanner();
        $banner->title       = $request->title;
        $banner->subtitle    = $request->subtitle;
        $banner->short_text  = $request->short_text;
        $banner->description = $request->description;
        $banner->banner_type = $request->banner_type;
        $banner->sort_order  = $request->sort_order ?? 0;
        $banner->status      = $request->boolean('status');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateBannerImage($image, $file_name, $request->banner_type);
            $banner->image = $file_name;
        }

        $banner->save();

        return redirect()->route('admin.banners')->with('success', 'Banner added successfully!');
    }

    public function GenerateBannerImage($image, $image_name, $type){
        $destination_path = public_path('backend/uploads/banners');
        if (!File::exists($destination_path)) {
            File::makeDirectory($destination_path, 0755, true);
        }

        $img = Image::read($image->path());

        if ($type === 'left') {
            // left banner:
            $img->resize(939, 235, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            // right banner:
            $img->resize(460, 235, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $img->save($destination_path . '/' . $image_name);
    }

    public function edit_banner($id){
        $banner = HomeBanner::findOrFail($id);
        return view('admin.home-banner-edit', compact('banner'));
    }

    public function update_banner(Request $request){
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'banner_type' => 'required|in:left,right',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
        ]);
        $banner = HomeBanner::findOrFail($request->id);
        $banner->title       = $request->title;
        $banner->subtitle    = $request->subtitle;
        $banner->short_text  = $request->short_text;
        $banner->description = $request->description;
        $banner->banner_type = $request->banner_type;
        $banner->sort_order  = $request->sort_order ?? 0;
        $banner->status      = $request->boolean('status');

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = public_path('backend/uploads/banners/' . $banner->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateBannerImage($image, $file_name, $request->banner_type);
            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully!');
    }

    public function delete_banner($id){
        $banner = HomeBanner::findOrFail($id);
        $imagePath = public_path('backend/uploads/banners/' . $banner->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $banner->delete();
        return redirect()->route('admin.banners')->with('success', 'Banner deleted successfully!');
    }

    public function shop_banners(){
        $banners = ShopBanner::orderBy('sort_order', 'ASC')->paginate(10);
        return view('admin.shop-banners', compact('banners'));
    }

    public function add_shop_banner(){
        return view('admin.shop-banner-add');
    }

    public function save_shop_banner(Request $request){
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);
        $banner = new ShopBanner();
        $banner->title        = $request->title;
        $banner->line_1       = $request->line_1;
        $banner->line_2       = $request->line_2;
        $banner->line_3       = $request->line_3;
        $banner->line_4       = $request->line_4;
        $banner->line_5       = $request->line_5;
        $banner->button_text  = $request->button_text;
        $banner->button_link  = $request->button_link;
        $banner->sort_order   = $request->sort_order ?? 0;
        $banner->status       = $request->boolean('status');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '.' . $image->extension();
            $this->generateShopBannerImage($image, $file_name);
            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->route('admin.shop_banners')->with('success', 'Shop banner added successfully!');
    }

    public function generateShopBannerImage($image, $image_name){
        $destination_path = public_path('backend/uploads/shop-banners');
        if (!File::exists($destination_path)) {
            File::makeDirectory($destination_path, 0755, true);
        }
        $img = Image::read($image->path());
        $img->resize(870, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destination_path . '/' . $image_name);
    }

    public function edit_shop_banner($id){
        $banner = ShopBanner::findOrFail($id);
        return view('admin.shop-banner-edit', compact('banner'));
    }

    public function update_shop_banner(Request $request){
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
        ]);
        $banner = ShopBanner::findOrFail($request->id);
        $banner->title        = $request->title;
        $banner->line_1       = $request->line_1;
        $banner->line_2       = $request->line_2;
        $banner->line_3       = $request->line_3;
        $banner->line_4       = $request->line_4;
        $banner->line_5       = $request->line_5;
        $banner->button_text  = $request->button_text;
        $banner->button_link  = $request->button_link;
        $banner->sort_order   = $request->sort_order ?? 0;
        $banner->status       = $request->boolean('status');
        if ($request->hasFile('image')) {
            // Delete old
            if (File::exists(public_path('backend/uploads/shop-banners/' . $banner->image))) {
                File::delete(public_path('backend/uploads/shop-banners/' . $banner->image));
            }

            $image = $request->file('image');
            $file_name = time() . '.' . $image->extension();
            $this->generateShopBannerImage($image, $file_name);
            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->route('admin.shop_banners')->with('success', 'Shop banner updated successfully!');
    }

    public function delete_shop_banner($id){
        $banner = ShopBanner::findOrFail($id);
        if (File::exists(public_path('backend/uploads/shop-banners/' . $banner->image))) {
            File::delete(public_path('backend/uploads/shop-banners/' . $banner->image));
        }
        $banner->delete();
        return redirect()->route('admin.shop_banners')->with('success', 'Shop banner deleted successfully!');
    }
}
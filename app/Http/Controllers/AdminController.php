<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\DeliveryFee;
use App\Models\State;
use App\Models\Weight;
use App\Models\Carrier;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index(){
        return view("admin.index");
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
        $products = Product::OrderBy('created_at','DESC')->paginate(10);        
        return view("admin.products",compact('products'));
    }

    public function add_product(){
        $categories = Category::Select('id','name')->orderBy('name')->get();
        return view("admin.product-add",compact('categories'));
    }

    public function product_save(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug',
            'category_id'=>'required',           
            'short_description'=>'required',
            'description'=>'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'SKU'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quantity'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg|max:2048'            
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $current_timestamp = Carbon::now()->timestamp;
        if($request->hasFile('image'))
        {        
            if (File::exists(public_path('backend/uploads/products').'/'.$product->image)) {
                File::delete(public_path('backend/uploads/products').'/'.$product->image);
            }
            if (File::exists(public_path('backend/uploads/products/thumbnails').'/'.$product->image)) {
                File::delete(public_path('backend/uploads/products/thumbnails').'/'.$product->image);
            }            
        
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image,$imageName);            
            $product->image = $imageName;
        }
        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;
        if($request->hasFile('images'))
        {
            $oldGImages = explode(",",$product->images);
            foreach($oldGImages as $gimage)
            {
                if (File::exists(public_path('backend/uploads/products').'/'.trim($gimage))) {
                    File::delete(public_path('backend/uploads/products').'/'.trim($gimage));
                }
                if (File::exists(public_path('backend/uploads/products/thumbnails').'/'.trim($gimage))) {
                    File::delete(public_path('backend/uploads/products/thumbnails').'/'.trim($gimage));
                }
            }
            $allowedfileExtension=['jpg','png','jpeg'];
            $files = $request->file('images');
            foreach($files as $file){                
                $gextension = $file->getClientOriginalExtension();                                
                $check=in_array($gextension,$allowedfileExtension);            
                if($check)
                {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;   
                    $this->GenerateProductThumbnailImage($file,$gfilename);                    
                    array_push($gallery_arr,$gfilename);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $product->images = $gallery_images;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('admin.products')->with('status','Product has been added successfully !');
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
        $product = Product::find($id);
        $categories = Category::Select('id','name')->orderBy('name')->get();
        return view('admin.product-edit',compact('product','categories'));
    }

    public function update_product(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->id,
            'category_id'=>'required',          
            'short_description'=>'required',
            'description'=>'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'SKU'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quantity'=>'required',
            'image'=>'nullable|mimes:png,jpg,jpeg|max:2048' // Make image optional
        ]);
        
        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $current_timestamp = Carbon::now()->timestamp;

        // Handle main image
        if($request->hasFile('image')) {        
            // Delete old image if exists
            if ($product->image && File::exists(public_path('backend/uploads/products').'/'.$product->image)) {
                File::delete(public_path('backend/uploads/products').'/'.$product->image);
            }
            if ($product->image && File::exists(public_path('backend/uploads/products/thumbnails').'/'.$product->image)) {
                File::delete(public_path('backend/uploads/products/thumbnails').'/'.$product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handle gallery images
        $gallery_arr = [];
        $gallery_images = "";
        $counter = 1;
        if($request->hasFile('images')) {
            // Delete old gallery images
            $oldGImages = explode(",", $product->images);
            foreach($oldGImages as $gimage) {
                $gimage = trim($gimage);
                if ($gimage && File::exists(public_path('backend/uploads/products').'/'.$gimage)) {
                    File::delete(public_path('backend/uploads/products').'/'.$gimage);
                }
                if ($gimage && File::exists(public_path('backend/uploads/products/thumbnails').'/'.$gimage)) {
                    File::delete(public_path('backend/uploads/products/thumbnails').'/'.$gimage);
                }
            }
            $allowedfileExtension=['jpg','png','jpeg'];
            $files = $request->file('images');
            foreach($files as $file){                
                $gextension = $file->getClientOriginalExtension();                                
                $check=in_array($gextension,$allowedfileExtension);            
                if($check) {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;   
                    $this->GenerateProductThumbnailImage($file, $gfilename);                    
                    array_push($gallery_arr, $gfilename);
                    $counter++;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images;
        }

        $product->save();       
        return redirect()->route('admin.products')->with('status','Product has been updated successfully !');
    }

    public function delete_product($id){
        $product = Product::find($id);
        if ($product->image && File::exists(public_path('backend/uploads/products').'/'.$product->image)) {
            File::delete(public_path('backend/uploads/products').'/'.$product->image);
        }
        if ($product->image && File::exists(public_path('backend/uploads/products/thumbnails').'/'.$product->image)) {
            File::delete(public_path('backend/uploads/products/thumbnails').'/'.$product->image);
        }
        $oldGImages = explode(",", $product->images);
        foreach($oldGImages as $gimage) {
            $gimage = trim($gimage);
            if ($gimage && File::exists(public_path('backend/uploads/products').'/'.$gimage)) {
                File::delete(public_path('backend/uploads/products').'/'.$gimage);
            }
            if ($gimage && File::exists(public_path('backend/uploads/products/thumbnails').'/'.$gimage)) {
                File::delete(public_path('backend/uploads/products/thumbnails').'/'.$gimage);
            }
        }           
        $product->delete();
        return redirect()->route('admin.products')->with('status','Product has been deleted successfully !');
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
                    return ucfirst($order->status);
                })
                ->addColumn('order_date', function ($order) {
                    return $order->created_at->format('d M, Y H:i');
                })
                ->addColumn('total_items', function ($order) {
                    return $order->orderItems()->count();
                })
                ->addColumn('delivered_on', function ($order) {
                    return $order->delivered_date ? $order->delivered_date->format('d M, Y') : '-';
                })
                ->addColumn('actions', function ($order) {
                    return '
                        <div class="list-icon-function">
                            <a href="">
                                <div class="item edit"><i class="icon-eye"></i></div>
                            </a>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.orders');
    }
}
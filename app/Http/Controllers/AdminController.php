<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\laravel\Facades\Image;
use Illuminate\Support\Facades\File;

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
}
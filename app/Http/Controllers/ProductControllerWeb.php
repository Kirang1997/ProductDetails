<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImages;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ProductControllerWeb extends Controller
{
    protected $userID;

    public function __construct()
    {
        // Set the userID value
        $this->userID = 1; // Hardcoded value, can be dynamically set as needed
    }
    //Add new product
    public function addProduct(Request $request)
    {

        try {
            // Add validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpg,jpeg,png,gif',
            ], [
                'name.required' => 'The Product Name is required.',
                'name.string' => 'The Product Name must be a valid string.',
                'name.max' => 'The Product Name must not exceed 255 characters.',
                'price.required' => 'The Product Price is required.',
                'price.numeric' => 'The Product Price must be a valid number.',
                'images.required' => 'At least one image is required for the Product.',
                'images.array' => 'The images must be an array.',
                'images.*.image' => 'Each image must be a valid image file.',
                'images.*.mimes' => 'The images must be of type jpg, jpeg, png, or gif.',
            ]);
     
    
            // Product creation
            $product = Product::create([
                'Name' => $request->name,
                'Price' => $request->price,
                'Created_at'=>Carbon::now(),
                'updated_at'=>null
            ]);
           
            // Image upload
            foreach ($request->file('images') as $image) {                
                // Define the folder path
                $folderPath = 'products'.$product->id;

                // Check if the folder exists, and create it if not
                if (!Storage::disk('public')->exists($folderPath)) {
                    Storage::disk('public')->makeDirectory($folderPath);
                }
          
                // Store the image in the folder
                $path = $image->store($folderPath, 'public');    
                // Create a new ProductImage instance and set the product_id manually
                try{
                    $saveProductImages=ProductImages::create([
                        'product_id' => $product->id,
                        'image_path' => $path ,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>null
                    ]);
                }catch(Exception $e){
                     // Return custom validation response
                    return response()->json([
                        'message' => 'Unable To add file Path',
                        'errors' => $e  // This will contain the validation error messages
                    ], 500);
                
                }
                
            }
            
            // Return success response
            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
    
        } catch (ValidationException $e) {
            // Return custom validation response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()  // This will contain the validation error messages
            ], 422);
        }
    }
    public function deleteProduct(Request $request){
        try {
            // Add validation
            $validated = $request->validate([
                'product_id' => 'required'
            ], [
                'product_id.required' => 'The Product id is required.',            
            ]);
            $product_id=$request->product_id;
            $products = Product::with('images')->find($product_id);
            

            // Check if there are any products
            if (!$products) {
             return response()->json(['message' => 'No products found','Deleted'=>false], 404);
            }else{
         
                 // Delete associated images
                 foreach ($products->images as $image) {
                    $filePath = public_path('storage/' . $image->path);

                    if (is_file($filePath)) {
                        // Delete the file
                        unlink($filePath);
                    } elseif (is_dir($filePath)) {
                        // If it's a directory, delete the directory (recursively if necessary)
                        rmdir($filePath);
                    }
                    $image->delete(); // Remove image record from the database
                }
                \Illuminate\Support\Facades\Artisan::call('storage:link');
                DB::table('cart')->where('product_id', $product_id)->delete();
                DB::table('productimages')->where('product_id', $product_id)->delete();
                DB::table('product')->where('id', $product_id)->delete();
                
                return response()->json(['message' => 'products Deleted .','Deleted'=>true], 200);
            }
        }catch (ValidationException $e) {
            // Return custom validation response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()  // This will contain the validation error messages
            ], 422);
        }
    }
    
    //Get All product list
    public function getAllProduct(){
            // Fetch all products
        $products = Product::with('images')->get();

           // Check if there are any products
           if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found','Data'=>[]], 404);
        }

        // Create an array to hold the product details
        $productList = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->Name,
                'price' => $product->Price,
                'images' => $product->images->isEmpty() ? []: $product->images->pluck('image_path')
            ];
        });

        return view('products.index', ['products' => $productList]);     
    }
    public function getproductDetails($id){

       // Fetch all products
       $products = Product::with('images')->where('id',$id)->get();

       // Check if there are any products
       if ($products->isEmpty()) {
        return response()->json(['message' => 'Products does not exist','Data'=>[]], 404);
        }

        // Create an array to hold the product details
        $productList = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'images' => $product->images->isEmpty() ? [] : $product->images->pluck('image_path')
            ];
        });

        // Return the list of products
        return response()->json(['message' => 'Product List','Data'=>$products],200);   

    }
    
}

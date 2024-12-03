<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CartControllerWeb extends Controller
{
    protected $userID;

    public function __construct()
    {
        // Set the userID value
        $this->userID = 1; // Hardcoded value, can be dynamically set as needed
    }

    //Add product in cart
    public function addProductToCart(Request $request)
    {

        try {
            // Add validation
            $validated = $request->validate([
                'product_id' => 'required|integer',
                'quantity' => 'required|integer',               
            ], [
                'quantity.required' => 'The number of quantity is required.',
                'quantity.integer' => 'The number of quantity must be a valid number.',
                'product_id.required' => 'The product id is required.',
                'product_id.integer' => 'The product id must be a valid number.',                 
            ]);
           
            try{
                $addToCart=Cart::create([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'user_id'   =>  $this->userID,
                ]);
                 // Return success response
                return response()->json([
                    'message' => 'Product Added in cart successfully',
                    'product' => $addToCart
                ], 201);
            }catch(Exception $e){
                 // Return custom validation response
                return response()->json([
                    'message' => 'Unable To add file Path',
                    'errors' => $e  // This will contain the validation error messages
                ], 500);
            
            }
    
        } catch (ValidationException $e) {
            // Return custom validation response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()  // This will contain the validation error messages
            ], 422);
        }
    }
    public function getAllCart()
    {
        // Fetch the product with its images and associated cart details for a specific user (user_id = 1 in this case)
        $cartItems = Cart::with(['product', 'product.images'])          
            ->where('user_id', 1) // Assuming user_id is 1 for now
            ->get();
    
        // Check if cart items are found
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'No items found in the cart for the specified product', 'Data' => []], 404);
        }
    
        // Create an array to hold product and cart details
        $cartDetails = $cartItems->map(function ($cartItem) {
            return [
                'cart_id' => $cartItem->id,
                'user_id' => $cartItem->user_id,
                'product_id' => $cartItem->product->id,
                'product_name' => $cartItem->product->Name,
                'product_price' => $cartItem->product->Price,
                'quantity' => $cartItem->quantity,
                'images' => $cartItem->product->images->isEmpty() 
                            ? 'No images available' 
                            : $cartItem->product->images->pluck('image_path'),
            ];
        });
    
        // Return the list of cart items along with product and image details
        return response()->json(['message' => 'Cart details for the product', 'Data' => $cartDetails], 200);
    }
    public function getProductCartDetails($id)
    {
        // Fetch the product with its images and associated cart details for a specific user (user_id = 1 in this case)
        $cartItems = Cart::with(['product', 'product.images'])
            ->where('product_id', $id)
            ->where('user_id', $this->userID) // Assuming user_id is 1 for now
            ->get();
    
        // Check if cart items are found
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'No items found in the cart for the specified product', 'Data' => []], 404);
        }
    
        // Create an array to hold product and cart details
        $cartDetails = $cartItems->map(function ($cartItem) {
            return [
                'cart_id' => $cartItem->id,
                'user_id' => $cartItem->user_id,
                'product_id' => $cartItem->product->id,
                'product_name' => $cartItem->product->Name,
                'product_price' => $cartItem->product->Price,
                'quantity' => $cartItem->quantity,
                'images' => $cartItem->product->images->isEmpty() 
                            ? 'No images available' 
                            : $cartItem->product->images->pluck('image_path'),
            ];
        });
    
        // Return the list of cart items along with product and image details
        return response()->json(['message' => 'Cart details for the product', 'Data' => $cartDetails], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
  use ApiResponse;
    //
    public function index()
    
    {
      try{
          $cart = Cart::where('user_id', Auth::id())->first();
          if (!$cart) {
              return $this->errorResponse(
                  'Cart not found',
                  404
              );
          }
              $items = CartItem::where('cart_id', $cart->id)->get();
                  if ($items->isEmpty()) {
            return $this->errorResponse(
                'No cart items found',
                404
            );}
          return $this->successResponse(
              $items,
              'Cart items retrieved successfully',
              200
          );
      
        }
      catch(\Exception $e){
        return $this->errorResponse(
          'An error occurred while retrieving cart items',
          500
        );

      }
    
    }
    public function store(CartRequest $request)
    {
      try{

        DB::beginTransaction();
        $user = Auth::user();
        $request->validated();
        

        $cart = Cart::firstOrCreate([
          'user_id' => $user->id,
        ]);
        $existingItem = CartItem::where('cart_id', $cart->id)
        ->where('course_id', $request->course_id)
        ->first();

if ($existingItem) {
return $this->errorResponse('This course is already in the cart', 409);
}

        $cartitem = CartItem::create([    
            'course_id' => $request->course_id,
            'tax' => $request->tax,
            'price' => $request->price,
            'cart_id' => $cart->id,
        ]);
          DB::commit();
        return $this->successResponse(
          $cartitem,
            'Cart item created successfully',
            201
        );
      }
      catch(QueryException $e){
        DB::rollBack();
        if ($e->getCode() == 23000) {
          return $this->errorResponse(
            'Cart item already exists',
            409
          );
        }
        return $this->errorResponse(
          'An error occurred while creating cart item',
          500
        );
      }
      catch(\Exception $e){
        return $this->errorResponse(
          'An error occurred while creating cart item',
          500
        );
      }

    }
    public function destroy($id)
    {
      try {
        $user = Auth::user();
    
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return $this->errorResponse(
                'Cart not found',
                404
            );
        }
        $cartitem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->first();
    
        if (!$cartitem) {
            return $this->errorResponse(
                'Cart item not found',
                404
            );
        }
    
        if ($cartitem->delete()) {
            return $this->successResponse(
                null,
                'Cart item deleted successfully',
                200
            );
        } else {
            return $this->errorResponse(
                'Failed to delete cart item',
                500
            );
        }
      }
      catch(\Exception $e) {
        return $this->errorResponse(
          'An error occurred while deleting cart item: ' . $e->getMessage(),
          500
        );
      }
    }
    

}

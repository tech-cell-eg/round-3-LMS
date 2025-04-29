<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Enrollment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Services\PaypalService;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{
    use ApiResponse;

    protected $paypalService;
    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }
    //
    public function checkout(){
      $user = Auth::user();
      $cart= Cart::where('user_id', $user->id)->first();
      
      $cartItems = $cart->cartItems()->get();
      if ($cartItems->isEmpty()) {
        return $this->errorResponse(
            'No cart items found',
            404
        );
      }
      $total = $cartItems->sum('price');
    
      $response = $this->paypalService->createOrder($total);
      if (isset($response['id']) && $response['id'] != null) {
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return $this->successResponse(
                    [
                        'approval_url' => $link['href'],
                        'order_id' => $response['id'],
                    ],
                    'Order created successfully',
                    200
                );
            }
        }
      }
      else{
        return $this->errorResponse(
            'An error occurred while creating the order',
            500
        );
      }


    }
    public function success(Request $request)
    {
        if (!$request->has('token')) {
            return $this->errorResponse('Missing payment token', 400);
        }
    
        $response = $this->paypalService->captureOrder($request->token);
    
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            DB::beginTransaction();
    
            try {
                $cart = Cart::where('user_id', Auth::id())->first();
    
                if (!$cart) {
                    return $this->errorResponse('Cart not found', 404);
                }
    
                $cartItems = $cart->items;
    
                if ($cartItems->isEmpty()) {
                    return $this->errorResponse('No cart items found', 404);
                }
    
                foreach ($cartItems as $item) {
                    Enrollment::create([
                        'user_id' => Auth::id(),
                        'course_id' => $item->course_id,
                    ]);
                }
    
                $cart->items()->delete();
                $cart->delete();
    
                DB::commit();
    
                return $this->successResponse($response, 'Payment successful', 200);
    
            } catch (\Exception $e) {
                DB::rollBack();
    
                return $this->errorResponse('An error occurred while processing your payment', 500);
            }
    
        } else {
            return $this->errorResponse('Payment failed', 500);
        }
    }
    public function cancel()
    {
        return $this->errorResponse(
            'Payment cancelled',
            400
        );
    }
}

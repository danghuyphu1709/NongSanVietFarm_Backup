<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        
        return view('client.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart');
        $product = $request->product;
        $id = $product['id'];
        $quantity = $request->quantity;
        $productDT = Product::findOrFail($id);
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $productDT->name,
                'image' => $productDT->image,
                'price' => $productDT->price_sale,
                'length' => $productDT->length,
                'width' => $productDT->width,
                'height' => $productDT->height,
                'weight' => $productDT->weight,
                'quantity' => $quantity,
                'price_regular' => $productDT->price_regular,
                'price_sale' => $productDT->price_sale,
            ];
        }

        if ($cart[$id]['quantity'] > $productDT->quantity) {
            return response()->json([
                'error' => 'Số lượng không được lớn hơn sản phẩm sẵn có!',
            ]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $cart,
        ]);
    }

    public function getCart()
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');

            return response()->json([
                'cart' => $cart,
            ]);
        }

        return response()->json();
    }

    public function updateCart(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $productDT = Product::findOrFail($id);

        $cart = session()->get('cart');

        if ($quantity <= 0 || !ctype_digit($quantity)) {
            return response()->json([
                'error' => 'Số lượng phải là số nguyên và lớn hơn 0!',
                'cart' => $cart[$id],
            ]);
        }

        if ($quantity > $productDT->quantity) {
            return response()->json([
                'error' => 'Số lượng không được lớn hơn sản phẩm sẵn có!',
                'cart' => $cart[$id],
            ]);
        }

        $cart[$id]['quantity'] = $quantity;

        session()->put('cart', $cart);
        
        return response()->json([
            'message' => 'Cập nhật giỏ hàng thành công!',
            'cart' => $cart,
        ]);
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Product removed from cart',
                'cart' => $cart
            ]);
        }

        return response()->json([
            'message' => 'Product not found in cart',
            'cart' => $cart
        ], 404);
    }
}
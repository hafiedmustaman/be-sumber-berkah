<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart; // untuk memanipulasi data ke dalam database.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() // untuk melakukan proses check authentication.
    {
        $this->middleware('auth:api'); // untuk memastikan bahwa customer tersebut telah melakukan proses login.
    } 

    /**
     * index
     *
     * @return void
     */
    public function index() // untuk menampilkan data cart berdasarkan ID customer.
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Cart',
            'cart'    => $carts
        ]);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) // untuk proses Add To Cart.
    {
        $item = Cart::where('product_id', $request->product_id)->where('customer_id', $request->customer_id);

        if ($item->count()) {
            //increment quantity
            $item->increment('quantity');
            $item = $item->first();
            //sum price * quantity
            $price = $request->price * $item->quantity;
            //sum weight
            $weight = $request->weight * $item->quantity;
            $item->update([
                'price' => $price,
                'weight'=> $weight
            ]);
        } else {
            $item = Cart::create([
                'product_id'    => $request->product_id,
                'customer_id'   => $request->customer_id,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'weight'        => $request->weight
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success Add To Cart',
            'quantity'  => $item->quantity,
            'product'   => $item->product
        ]);
    }
    
    /**
     * getCartTotal
     *
     * @return void
     */
    public function getCartTotal() // untuk mendapatkan jumlah/total dari semua harga di dalam cart.
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->sum('price');
        
        return response()->json([
            'success' => true,
            'message' => 'Total Cart Price ',
            'total'   => $carts
        ]);
    }
    
    /**
     * getCartTotalWeight
     *
     * @return void
     */
    public function getCartTotalWeight() // untuk mendapatkan jumlah/total dari semua berat product di dalam cart.
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->sum('weight');
        
        return response()->json([
            'success' => true,
            'message' => 'Total Cart Weight ',
            'total'   => $carts
        ]);
    }
    
    /**
     * removeCart
     *
     * @param  mixed $request
     * @return void
     */
    public function removeCart(Request $request) // untuk menghapus item product yang sudah di tambahkan di dalam cart.
    {
        Cart::with('product')
                ->whereId($request->cart_id)
                ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Remove Item Cart',
        ]);
    }

    /**
     * removeAllCart
     *
     * @param  mixed $request
     * @return void
     */
    public function removeAllCart(Request $request) // untuk menghapus semua data item di dalam cart, dan di sini akan digunakan saat kita selesai melakukan checkout, maka data cart akan dihapus semua.
    {
        Cart::with('product')
                ->where('customer_id', auth()->guard('api')->user()->id)
                ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Remove All Item in Cart',
        ]);
    }
}

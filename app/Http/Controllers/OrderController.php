<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index (){
        return view('admin.orders.index')->with('orders',Order::paginate(5));
    
    }
    function create (){
    }
    function store (Request $request){
    }
    function edit ($id){
        $order = order::findOrFail($id);
        $products = DB::table('orders_products')->select('product_id', 'quantity')->where('order_id', '=', $id)->get();
        $cart=[];
        foreach($products as $product){
            $cartLine= Product::findOrFail($product->product_id);
            $cartLine['quantity'] = $product->quantity;
            array_push($cart, $cartLine);
        }
        return view('admin.orders.edit', with([
            'order'=>$order,
            'products'=>$cart
        ]));
    }
    function update($id, Request $request)
    {
        $order = order::findOrFail($id);
        $order['status'] = $request['status'];
        $order->save();
        return redirect()->route('orders.index');
        
    }

    function show($id)
    {
        $order = order::findOrFail($id);
        $products = DB::table('orders_products')->select('product_id', 'quantity')->where('order_id', '=', $id)->get();
        $cart=[];
        foreach($products as $product){
            $cartLine= Product::findOrFail($product->product_id);
            $cartLine['quantity'] = $product->quantity;
            array_push($cart, $cartLine);
        }
        return view('admin.orders.show', with([
            'order'=>$order,
            'products'=>$cart
        ]));
    }
    function destroy ($id){
        $order = order::findOrFail($id);
        order::destroy($id);
        return redirect()->route('orders.index')->with('success','Record has been deleted');
    }
    function deleteProduct ($id,Request $request){
        $order = order::findOrFail($id);
        $product_id = $request['product_id'];
        $products = DB::table('orders_products')->where('order_id', '=', $id)->get();
        if($products->count()>1){
            for($i=0;$i<$products->count();$i++){
                if ($products[$i]->product_id == $product_id) {
                    unset($products[$i]);
                }}
                $subTotal = 0;
                $shipping = 0;
                foreach($products as $product){
                    $temp=Product::findOrFail($product->product_id );
                    $subTotal += $temp->getPrice()*$product->quantity;
                    $shipping += 10;
                }
            $total = $subTotal + $shipping;
            $order['total'] = $total;
            $order->save();        
            DB::table('orders_products')->where('order_id', '=', $id)->where('product_id', '=', $request['product_id'])->delete();
            return redirect('admin/orders/'.$id.'/edit')->with('success','Record has been deleted');
        }
        else{
            order::destroy($id);
        return redirect()->route('orders.index')->with('success','Record has been deleted');
        }
    }
}

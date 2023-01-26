<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\review;
use App\Models\Size;
use App\Models\Color;
use App\Models\User;
use App\Models\_subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public static function subTotal($products){
        $subTotal = 0;
        foreach ($products as $product) {
            $subTotal += $product['quantity'] * ($product['price'] * (1 - $product['discount']));
        }
        return $subTotal;
    }
    public static function shipping($products){
        $shipping = 0;
        foreach ($products as $product) {
            $shipping += $product['quantity'] * 10;
        }
        return $shipping;
    }
    public static function total($products){
        return HomeController::shipping($products) + HomeController::subTotal($products);
    }
    public static function getCart(){
        $products = [];
        $ids = session()->get('ids', []);
        $ids = array_count_values($ids);
        foreach($ids as $id=>$quantity){
            $product= Product::findOrFail($id);
            $product['quantity'] = $quantity;
            array_push($products, $product);
        }
        return $products;
    }
        function index(){
            $categories =  Category::all();
            foreach($categories as $c){
                 $c['product_count'] = Category::getProductsCount($c['id']);
                 }
        return view('index')->with([
            'categories' => $categories,
            'products' => Product::all()
        ]);

    }
    function details($id){
        $categories =  Category::all();
        foreach($categories as $c){
        $c['product_count'] = Category::getProductsCount($c['id']);
    }
    $product=Product::findOrFail($id);
        $color = DB::table('colors')->where('colors.id', "=",$product['color_id'] )->get();
        $size = DB::table('sizes')->where('sizes.id', "=", $product['size_id'])->get();
        $reviews = review::where("product_id", '=', $product['id'])->get();
        $user_review = [];
        if(auth()->check())$user_review = review::where('product_id','=',$id)->where('user_id','=',auth()->user()['id'])->get();
    return view('details')->with([
        'product' => $product,
        'color' => $color[0]->name,
        'size' => $size[0]->name,
        'products'=> Product::all(),
        'reviews'=>$reviews,
        'user_review'=>$user_review
    ]);

}
    function sendOrder(Request $request){
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'payment' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'total' => 'required',
            'zip_code' => 'required'
        ];
        $request->validate($rules);
        $order = new Order;
        $order['status']='not delivered';
        $order->fill($request->post());
        $order = $order->toArray();
        $insert_id = DB::table('orders')->insertGetId($order);
        $products = HomeController::getCart();
        foreach($products as $product){
            $arr = [
                'order_id' => $insert_id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ];
           echo DB::table('orders_products')->insert($arr);        
            
        }
        Session::put('ids', []);
        return redirect()->route('cart')->with('success','order has been sent successfully');

    }
    function checkout(){
    $products = HomeController::getCart();
    $subTotal = HomeController::subTotal($products);
        $shipping = HomeController::shipping($products);
        $total = HomeController::total($products);

        return view('checkout')->with([
            'products' => $products,
            'total'=> $total,
            'subTotal'=> $subTotal,
            'shipping'=> $shipping
        ]);

    }
    function contact(){
        return view('contact');

    }
    function cart()
    {
        $products = HomeController::getCart();
        $subTotal = HomeController::subTotal($products);
        $shipping = HomeController::shipping($products);
        $total = HomeController::total($products);

        return view('cart')->with([
            'products'=> $products,
            'total'=> $total,
            'subTotal'=> $subTotal,
            'shipping'=> $shipping
        ]);

    }
    function editCart(){
        $products = Product::getCart();
        $id = $_GET['id'];
        $comm = $_GET['comm'];
        $ids = session()->get('ids', []);

        switch($comm){
            case 1:
                $gto = false;
                foreach($products as $product){
                    if($product['id']==$id){
                        if ($product['quantity'] > 1)
                            $gto = true;
                    } }
                if ($gto) {
                    for ($i = 0; $i < count($ids); $i++) {
                        if ($ids[$i] == $id) {
                            \array_splice($ids, $i, 1);
                            break;
                        }
                    }
                };break;
            case 2: array_push($ids, $id);break;
            case 3:
                for ($i = 0; $i < count($ids); $i++) {
                    if ($ids[$i] == $id) {
                        \array_splice($ids, $i, 1);
                        $i -= 1;
                    }
                }
                    ;break;
            }
        
        

        Session::put('ids', $ids);
        return redirect()->route('cart');

    }

    function shop(Request $request)
    {
        $query = Product::query();

        $inputs = $request->all();

        if (isset($inputs['keywords'])) {
            $query = $query->where('name', 'like', "%" . $inputs['keywords'] . "%");
        }
        if (isset($inputs['color'])) {
            if (!in_array('-1', $inputs['color'])) {

                $query = $query->whereIn('color_id', $inputs['color']);
            }
        }
        if (isset($inputs['size'])) {
            if (!in_array('-1', $inputs['size'])) {
                $query = $query->whereIn('size_id', $inputs['size']);
            }
        }

        if ($request->has('category_id')) {
            $query = $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('price')) {
            if (!in_array('-1', $inputs['price'])) {
                $query = $query->where(function ($q) use ($inputs) {
                    foreach ($inputs['price'] as $price) {
                        $q = $q->orWhereBetween('price', [$price, $price + 100]);
                    }
                });
            }
        }

        /*SELECT * FROM Products WHERE con1 and con2 and (
        price between 0 and 100 or
        price between 100 and 200
        )
        */
        $products = $query->paginate(9);


        return view('shop')->with([
            'products' => $products,
            'colors' => Color::all(),
            'sizes' => Size::all()
        ]);
    }
    function add_product(Request $request)
    {
        if ($request->has('id')) {
            $ids = Session::get('ids', []);
            array_push($ids, $request->get('id'));
            Session::put('ids', $ids);
            return response()->json([count($ids),'products addedd to cart successfully']);
        }
        return abort(404);
    }
    function like_product(Request $request)
    {
        if ($request->has('id')) {
            $ids = Session::get('hearts', []);
            if (in_array( $request['id'],$ids)){
                return response()->json(["",'product already added to likes before']);
            }else{
                array_push($ids, $request->get('id'));
                Session::put('hearts', $ids);
                return response()->json([count($ids),'product added to Likes successfully']);
            }
        }
        return  abort(404);
    }
    function subscribe(Request $request)
    {
        if ($request->has('email')) {
            $sub=_subscribe::where("user_id", "=", auth()->user()['id'])->first();
            if ($sub===null){
                $subscribe = new _subscribe;
                $subscribe['user_id'] = auth()->user()['id'];
                $subscribe['email'] = $request['email'];
                $subscribe->save();
                return response()->json('subscription added successfully');
            }else{
                return response()->json('you already subscribed before');
            }
        }
        return  abort(404);
    }
    function logout (){
        auth()->logout();
        return redirect()->route('index');
    
    }
    function addReview (Request $request,$id){
        $review = new review;
        $review['product_id']=$id;
        $review['user_id']=auth()->user()['id'];
        $review['review']=$request['review'];
        $review['rating']=$request['rate'];
        $review->save();
        $product = Product::findOrFail($id);
        $product["rating"] = (($product["rating"] * $product["rating_count"]) + $request['rate']) / ($product["rating_count"]+1);
        $product["rating_count"] = $product["rating_count"] + 1;
        $product->save();
        return redirect('details/'.$id);
    
    }
    function updateReview (Request $request,$id){
        $review = review::where('product_id','=',$id)->where('user_id','=',auth()->user()['id'])->first();
        $review['review']=$request['review'];
        $old = $review['rating'];
        $review['rating']=$request['rate'];
        $review->save();
        $product = Product::findOrFail($id);
        $product["rating"] = ((($product["rating"] * $product["rating_count"])-$old) + $request['rate']) / ($product["rating_count"]);
        $product->save();
        return redirect('details/'.$id);
    
    }
    
}
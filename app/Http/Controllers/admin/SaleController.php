<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Sell;
use DB;
use Auth;
use PDF;
use Illuminate\Support\Facades\Cookie;
use App\Models\Cart;
class SaleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::all();
        $customer=Customer::all();
        $carts = DB::table('carts')
            ->join('products', 'product_id', '=', 'products.id')
            ->select('*', 'carts.id as cart_id', 'carts.quantity as cart_quantity')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $total = 0;
        foreach($carts as $cart){
            $total += $cart->selling_price * $cart->cart_quantity;
        }
        return view('backend.sale',compact('product','customer','carts','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request){
        $user = Auth::user();
        $cart = new Cart();
        $product = Product::find($request->product_id);
        $newQuantity = $product->stock_quantity - $request->quantity;
        $product->stock_quantity = $newQuantity;
        $product->update();
        $cart->user_id = $user->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
         $cart->save();
        return "quantity updated successfully!!! ";
    }
    public function deleteCartitem(Request $request){
        try{
            $cart = DB::table('carts')->select(['product_id', 'quantity'])->where('id', $request->id)->get()->first();
            $item = Product::find($cart->product_id);
            $item->stock_quantity += $cart->quantity;
            $item->update();
            Cart::destroy([$request->id]);
        }catch(\Illuminate\Database\QueryException $e){
            return 'Wrong!';
        }

        return 'deleted successfull!!';
    }

   

    public function deleteAllCartItem(Request $request){
        $keys = $request->dataId;
        $values = $request->dataQty;
        $temp = [];
        foreach($keys as $index => $key){
            if(isset($temp[$key])){
                $temp[$key]+=$values[$index];
            }else{
                $temp[$key] = $values[$index];
            }
        }
        foreach($temp as $id => $quantity){
            $product = Product::find($id);
            $product->stock_quantity += $quantity;
            $product->update();
        }
        $id = Auth::user()->id;
        $cartIds = DB::table('carts')->select('id')->where('user_id', '=', $id)->get()->toArray();
        $ids = [];
        foreach($cartIds as $cards){
            array_push($ids, $cards->id);
        }
        Cart::destroy($ids);
        return ['success-message' => 'Cart Deleted'];
    }

    public function itemSellInvoiceShow(Request $request){
        $validated = $request->validate([
            'amount_paid' => 'required|numeric',
            
            
        ]);
                $id =  Auth::user()->id;
                $carts = DB::table('carts')
                    ->join('products', 'product_id', '=', 'products.id')
                    ->select('*', 'carts.id as cart_id', 'carts.quantity as cart_quantity')
                    ->where('user_id', '=', $id)
                    ->get();
                    $total = 0;
                    foreach($carts as $cart){
                        $total += $cart->selling_price * $cart->cart_quantity;
                    }
                foreach($carts as $cart){
                    $sell = new Sell();
                    $sell-> product_id = $cart->product_id;
                    $sell->quantity = $cart->cart_quantity;
                    $sell->total_price = $cart->selling_price*$cart->cart_quantity + $cart->selling_price*$cart->cart_quantity;
                    $sell->save();
                }
                if(count(Invoice::all())==0){
                    $invoiceNo = '#0001';
                }else{
                    $invoiceNo = '#000'.(count(Invoice::all())+1);
                }
                $customer = Customer::where('id', '=', $request->customer_id)->first();
              
                if($request->amount_paid < $request->amount_payable){
                    $due = (int)$request->amount_payable - (int)$request->amount_paid;
                }else{
                    $due = 0;
                }
        
              $invoice =  Invoice::create([
                    'invoice_no'    =>  $invoiceNo,
                    'from'          =>  Auth::user()->name,
                    'to'            =>  $customer->name,
                    'invoice_type'  =>  'Sell Items',
                    'total_amount'  =>  $request->amount_payable,
                    'amount_paid'   =>  $request->amount_paid,
                    'amount_due'    =>  $due,
                    'status'        =>  $request->note,
                ]);

                $invoice_show = Invoice::where('id',$invoice->id)->first();
        
                return view('backend.invoice',compact('invoice_show','customer','carts','total')); 
            }

    public function deletecurrentcart(Request $request){
        $keys = $request->dataId;
        $values = $request->dataQty;
        $temp = [];
        foreach($keys as $index => $key){
            if(isset($temp[$key])){
                $temp[$key]+=$values[$index];
            }else{
                $temp[$key] = $values[$index];
            }
        }
        foreach($temp as $id => $quantity){
            $product = Product::find($id);
             $quantity =$product->stock_quantity;
            $product->update();
        }
        $id = Auth::user()->id;
        $cartIds = DB::table('carts')->select('id')->where('user_id', '=', $id)->get()->toArray();
        $ids = [];
        foreach($cartIds as $cards){
            array_push($ids, $cards->id);
        }
        Cart::destroy($ids);

        return redirect()->route('sale')->with('successfully payment done');
    }    
    
           
}

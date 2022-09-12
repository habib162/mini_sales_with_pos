<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Auth;

class ProductController extends Controller
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
        return view('backend.product.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|max:55',
            'description' => 'required',
            'purchase_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'stock_quantity' => 'required|numeric',
        ]);
        $imagename='';
        if($request->images){
            $image = $request ->images;
            $imagename = $request->name.'.'.$image->getClientOriginalExtension();
            $destinationfile = 'Files/product/';
            Image::make($image)->resize(600,600)-> save($destinationfile.$imagename); // image intervention

        }
       $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock_quantity' => $request->stock_quantity,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,           
            'images' => $imagename,
            'admin_id' => Auth::id(),

        ]);
       $product->save();
        // return $product;
        $notification = array('messege'=>" products inserted Successfully!",'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::where('id',$id)->first();
        // return $product;
        return view('backend.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:55',
            'description' => 'required',
            'purchase_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'stock_quantity' => 'required|numeric',
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['purchase_price'] = $request->purchase_price;
        $data['selling_price'] = $request->selling_price;
        $data['stock_quantity'] = $request->stock_quantity;
       
        if($request->images){
            if(File::exists($request->old_image)){
                unlink($request->old_image);
            }
            $image = $request->images;
            $imagename = $request->name.'.'.$image->getClientOriginalExtension();
            $destinationfile = 'Files/product/';
            Image::make($image)->resize(600,600)-> save($destinationfile.$imagename); 

            $data['images']=$imagename;
            Product::where('id',$request->id)->update($data);
            $notification = array('messege'=>" Product updated Successfully!",'alert-type'=>'success');
            return redirect()->back()->with($notification);

        }else{
            $data['images']=$request->old_image;
            Product::where('id',$request->id)->update($data);

            $notification = array('messege'=>" Product updated Successfully!",'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }
        
          
        $notification = array('messege'=>" Product updated Successfully!",'alert-type'=>'success');
        return redirect()->back()->with($notification);

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::where('id',$id)->first();
        $image = $data->images;
        if(File::exists($image)){
            unlink($image);

        }
        Product::where('id',$id)->delete();

        $notification = array('messege'=>" Product Deleted Successfully!",'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
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
        $customer=Customer::all();
        return view('backend.customer.index',compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customer.create');
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
            'address' => 'required',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
        ]);
       $product = Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,

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
        $customer=Customer::where('id',$id)->first();
        return view('backend.customer.edit',compact('customer'));
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
            'address' => 'required',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone_number'] = $request->phone_number;
       
        Customer::where('id',$request->id)->update($data);
        $notification = array('messege'=>" Customer updated Successfully!",'alert-type'=>'success');
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
        Customer::where('id',$id)->delete();

        $notification = array('messege'=>" Customer Deleted Successfully!",'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}

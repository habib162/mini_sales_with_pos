@extends('layouts.admin')
@section('admin_content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Easca Solution Ltd
                    <small class="float-right">Date: {{date('d-m-y H:i:s')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{Auth::user()->name}}</strong><br>
                    Email: {{Auth::user()->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{$customer->name}}</strong><br>
                    {{$customer->address}}<br>
                    Phone: {{$customer->phone_number}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice {{$invoice_show->invoice_no}}</b><br>
                  <b>Payment Due:</b> {{$invoice_show->amount_due}}$<br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr >
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Description</th>
                      <th>price</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($carts as $cart)
                      <tr id="cartRow">
                        <td>{{$cart->cart_quantity}}</td>
                        <td>{{  $cart->name}}</td>
                        <td>{!!$cart->description!!}</td>
                        <td>{{  $cart->selling_price}}</td>
                        <td>{{$cart->selling_price*$cart->cart_quantity}} ৳</td>
                        <td>
                           <input type="hidden" value="{{$cart->cart_id}}" id="cartId">
                      <input type="hidden" value="{{$cart->product_id}}" id="itemId">
                      <input type="hidden" value="{{$cart->cart_quantity}}" id="itemQuantity">
                        </td>
                      </tr>
                     
                      @endforeach
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due {{$invoice_show->amount_due}}</p>

                  <div class="table-responsive">
                    <table class="table">

                      <tr>
                        <th>Total:</th>
                        <td>{{$total}} ৳</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="" id="invoice_print" target="_blank" class="btn btn-info float-right"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right" id="submitpay"> Submit
                    Payment
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="{{asset('backend')}}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).on('click', '#submitpay', function(){
        var dataId =[];
        var dataQty =[];
        $('#cartRow').children('td').each(function(){
            var product_id = $(this).find('#itemId').val();
            var product_quantity = $(this).find('#itemQuantity').val();
            if(product_id && product_quantity){
                dataId.push(product_id);
                dataQty.push(product_quantity);
            }   
        });
        $.post('deletecurrentcart',{
          '_token':  '{{ csrf_token() }}', 
          'dataId' : dataId,
          'dataQty' : dataQty
        }, 
        function(data){
            window.location.reload();
            toastr.success("successfully done!");
        });
    });

    $(document).on('click','#invoice_print',function(){
      window.print();
     
    });
</script>
@endsection
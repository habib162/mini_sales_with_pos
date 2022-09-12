@extends('layouts.admin')
@section('admin_content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .lds-ellipsis {
      display: inline-block;
      position: relative;
      width: 64px;
      height: 11px;
  }
  .lds-ellipsis div {
      position: absolute;
      top: 0px;
      width: 11px;
      height: 11px;
      border-radius: 50%;
      background: #009688;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
  }
  .lds-ellipsis div:nth-child(1) {
      left: 6px;
      animation: lds-ellipsis1 0.6s infinite;
  }
  .lds-ellipsis div:nth-child(2) {
      left: 6px;
      animation: lds-ellipsis2 0.6s infinite;
  }
  .lds-ellipsis div:nth-child(3) {
      left: 26px;
      animation: lds-ellipsis2 0.6s infinite;
  }
  .lds-ellipsis div:nth-child(4) {
      left: 45px;
      animation: lds-ellipsis3 0.6s infinite;
  }
  @keyframes lds-ellipsis1 {
      0% {
          transform: scale(0);
      }
      100% {
          transform: scale(1);
      }
  }
  @keyframes lds-ellipsis3 {
      0% {
          transform: scale(1);
      }
      100% {
          transform: scale(0);
      }
  }
  @keyframes lds-ellipsis2 {
      0% {
          transform: translate(0, 0);
      }
      100% {
          transform: translate(19px, 0);
      }
  }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Point of sale</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-6">
                <div class="panel">
                    <h4 class="text-info">Customer 
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                            Add Customer
                          </button>
                    </h4>
                </div>
                <div class="card card-primary card-outline" style="border: 1px solid;">
                    <div class="card-body box-profile">
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          {{-- <p class="text-center">Product Not added</p> --}}
                      <div class="card">
                        <div class="header loader-div">
                            <h2 style="display: inline-block;">
                                Cart 
                            </h2>
                            <div class="lds-ellipsis m-l-25" style="display: none"><div></div><div></div><div></div><div></div></div>
                        </div>
                          <div class="carts">
                            <div id="tblDiv">
                              @if(count($carts)>0)
                              <table class="table">
                                <thead>
                                    <tr>
                                        <th>item</th>
                                        <th>Name</th>
                                        <th>quantity</th>
                                        <th>unit price</th>
                                        <th>sub total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody >
                                  @foreach ($carts as $cart)
                                  <tr id="cartRow">
                                    <td scope="row"></td>
                                    <td>{{$cart->name}}</td>
                                    <td>{{$cart->cart_quantity}}</td>
                                    <td>{{$cart->selling_price}} ৳</td>
                                    <td>{{$cart->selling_price*$cart->cart_quantity}} ৳</td>
                                    <td>
                                            <a href="" class="col-red btn btn-danger remove-from-cart" id="deleteCartItem">
                                              <i class="fa fa-trash"></i>
                                              <input type="hidden" value="{{$cart->cart_id}}" id="cartId">
                                              <input type="hidden" value="{{$cart->product_id}}" id="itemId">
                                              <input type="hidden" value="{{$cart->cart_quantity}}" id="itemQuantity">
                                          </a>           
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              <div class="text-center">
                                <h3 class="profile-username text-center title amount"><strong>Total: {{$total}}</strong></h3>
                                <h3> <p class="title">Amount to be paid = <span class="amount" id="amountToBePaid"> {{$total}}</span></p></h3>
                                {{-- <a href="#" class="btn btn-primary btn-block"><b>Submit</b></a>   --}}
                                <a href="javascript:void(0);" id="delallcart" class="btn btn-danger m-r-10">Delete all cart</a>
                                <a href="javascript:void(0);" id="paymentbtn" class="btn btn-success">payment</a>            
                              </div>
                          </div>
                        </div>
                        </div>

                        </li>
                      </ul>
                    </div>
 
                    @else
                        <p>Select Items</p>
                </div>    
                  @endif
                    <!-- /.card-body -->
                  </div>
                  </div>
            </div>
            <div class="col-lg-12">
                    <!-- Main content -->
                    <div class="col-md-12">
                      <div class="card">
                          <div class="border-bottom" style="padding: 15px 15px 0px 15px;">
                          </div>
                          <div class="body">
                              <div id="itemswrapper">
                                  <div class="row" id="allItems">
                                      @foreach($product as $item)
                                      <div class="col-md-3 col-sm-12" id="singleItem">
                                          <div class="card clearfix">
                                              <div class="itemwrapper text-center">
                                                  <div id="itemSingle">
                                                      <input type="hidden" id="itemid" value="{{$item->id}}">
                                                      <input type="hidden" id="itemName" value="{{$item->name}}">
                                                      <h2>{{$item->name}}</h2>
                                                      <img src="{{asset('/Files/product/'.$item->images)}}"style="height:50px;width:100px" alt="">
                                                      <p class="price">Price: {{$item->selling_price}} BDT  (Total quantity:<span id="stock" class="quantity"> {{$item->stock_quantity}}</span>)</p>
                                                      <div class="row">
                                                          <div class="col-sm-12 margin-0" style="margin-bottom: 0px;">
                                                              <div class="left_text m-l-25">
                                                                  <label for="quantity">Add Quantity</label>
                                                              </div>
                                                              <div class="right_text">
                                                                  <div class="input-group spinner" data-trigger="spinner" style="margin-bottom: 5px;">
                                                                      <div class="form-line">
                                                                          <input class="form-control margin-0 text-center" id="itemquantity" type="number" name="item_quantity"  value="1" data-rule="quantity" style="font-weight: 700;margin-bottom:0px;width: 50px;">
                                                                      </div>
                                                                      <span class="input-group-addon">
                                                                      <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                                      <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                                                  </span>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-sm-12 text-center" style="margin-bottom: 10px;">
                                                              <a class="btn bg-teal update-cart" id="addToCartBtn">Add to cart</a>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      @endforeach
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
</div>
<form action="{{route('customer.store')}}" method="POST">
@csrf
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add a new customer</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Customer Name <span class="text-danger">*</span></label>
                        <input type="text"name="name" class="form-control" value="{{old('name')}}" required>  
                    </div>
                    <div class="form-group">
                        <label for="name">Customer Phone Number <span class="text-danger">*</span></label>
                        <input type="number"name="phone_number" class="form-control" value="{{old('phone_number')}}" required>  
                    </div>
                    <div class="form-group">
                        <label for="name">Customer Address <span class="text-danger">*</span></label>
                        <input type="text"name="address" class="form-control" value="{{old('address')}}" required>  
                    </div>
                </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">submit</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</form>    
      <!-- /.modal -->
      <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
 
                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <form action="{{route('sellInvoice.show')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="amount_payable">Amount Payable</label>
                                <div class="form-line">
                                    <input type="text" id="amount_payable" class="form-control" disabled>
                                    <input type="hidden" name="amount_payable" id="total_payable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="paid_by">Paid By</label>
                                <select class="form-control show-tick" name="customer_id">
                                    @foreach($customer as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount_paid">Amount Paid</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Amount Paid" id="amount_paid" name="amount_paid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <div class="form-line">
                                    <textarea class="form-control" placeholder="Note.." id="note" name="note"></textarea>
                                </div>
                            </div>
                                <button class="btn btn-primary" id="create_invoice" >Create Invoice</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<script src="{{asset('backend')}}/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $(".update-cart").click(function (e) {
    event.preventDefault();

    var id = $(this).parent().parent().parent().find('#itemid').val();
    var qty = $(this).parent().parent().parent().find('#itemquantity').val();
    var stock = $(this).parent().parent().parent().find('#stock');
    var newStock = parseFloat(stock.text());

      //     var newStock = parseFloat(stock.text());
            if(qty>parseInt(stock.text())){
                alert('Not Enough in Stock');
            }else{
              $('.lds-ellipsis').css('display', 'inline-block');
              $.ajax({
                url: "{{ route('posaddtocart') }}",
                method: "post",
                data: {
                  _token: '{{ csrf_token() }}', 
                    product_id:id, 
                    quantity: qty,
                    
                }, 
                success: function (data) {
                    $('#tblDiv').load(location.href + ' #tblDiv');
                    $('.lds-ellipsis').css('display', 'none');
                    toastr.success(data);
                }
            });
            stock.text(newStock-qty).change();
          }
  });



  $(".remove-from-cart").click(function (e){
    e.preventDefault();
        $('.lds-ellipsis').css('display', 'inline-block');
        var id = $(this).find('#cartId').val();
        $.post('sale/deletecart', {'id':id, '_token': $('input[name=_token]').val()
      }, 
        function(data){
            window.location.reload();
            toastr.success(data);
        });
    });

     //deleting all cart item

     $(document).on('click', '#delallcart', function(){
        var dataId =[];
        var dataQty =[];
        $('tr#cartRow').children('td').each(function(){
            var product_id = $(this).find('input#itemId').val();
            var product_quantity = $(this).find('input#itemQuantity').val();
            if(product_id && product_quantity){
                dataId.push(product_id);
                dataQty.push(product_quantity);
            }   
        });
        $.post('sale/deleteallcart',{'_token': $('input[name=_token]').val(), 'dataId' : dataId, 'dataQty' : dataQty}, 
        function(data){
            window.location.reload();
            toastr.success("successfully deleted!");
        });
    });

    $(document).on('click', '#paymentbtn', function(){
        var amountToBePaid = $('#amountToBePaid').text();
        $('#amount_payable').val(amountToBePaid);
        $('#total_payable').val(amountToBePaid);
        $('#smallModal').modal('show');
    });
   


</script>

@endsection
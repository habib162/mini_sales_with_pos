@extends('layouts.admin')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style type="text/css">
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>New Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">New Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if ($errors->any())
    <div class="alert alert-damger">
      <ul>
        @foreach ($errors->all() as $error)
          <li style="color: red">{{$error}}</li>
        @endforeach
      </ul>
    </div>
      
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
          <!-- left column -->
          @csrf
          <div class="row">
           <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add new product</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group col-lg-12">
                    <label for="name">Product Name <span class="text-danger">*</span></label>
                    <input type="text"name="name" class="form-control" value="{{old('name')}}" required>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Purchase Price</span>*</label>
                        <input type="text" class="form-control" name="purchase_price"value="{{old('purchase_price')}}">
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Selling Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"name="selling_price"value="{{old('selling_price')}}" required>
                      </div>
                  </div>
                   <div class="row">
                      <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Stock Quantity</span></label>
                        <input class="form-control" name="stock_quantity"value="{{old('stock_quantity')}}" id="">
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Product Description</label>
                            <textarea name="description" class="form-control textarea" value="{{old('description')}}"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image <span class="text-danger">*</span></label>
                        <br>
                        <input class="form-control" type="file" name="images" required="" id="dropify">
                        <br>
                    </div>
                </div>
                
                <!-- /.card-body -->
            </div>
            <button class="btn btn-info btn-block"type="submit">Submit</button>
          </div>
         
        </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
    $('#dropify').dropify();
  </script>
@endsection
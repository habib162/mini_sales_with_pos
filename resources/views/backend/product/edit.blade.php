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
              <li class="breadcrumb-item active">Update Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if ($errors->any())
    <div class="alert alert-damger">
      <ul>
        @foreach ($errors->all() as $error)
          <li  style="color: red">{{$error}}</li>
        @endforeach
      </ul>
    </div>
      
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
          <!-- left column -->
          @csrf
          <div class="row">
           <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update product</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group col-lg-12">
                    <label for="name">Product Name <span class="text-danger">*</span></label>
                    <input type="text"name="name" class="form-control" value="{{ $product->name }}" required>
                  </div>
                  <input type="hidden" name="id" value="{{ $product->id }}">
                  <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Purchase Price</span>*</label>
                        <input type="text" class="form-control" name="purchase_price"value="{{ $product->purchase_price }}">
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Selling Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"name="selling_price"value="{{$product->selling_price}}" required>
                      </div>
                  </div>
                   <div class="row">
                      <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Stock Quantity</span></label>
                        <input class="form-control" name="stock_quantity"value="{{$product->stock_quantity}}" id="">
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="exampleInputEmail1">Product Description</label>
                            <textarea name="description" class="form-control textarea" value="">{!!$product->description!!}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images">Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control dropify"data-height="140" id="input-file-now" name="images">
                        <input type="hidden" name="old_image" value="{{$product->images}}">
                        <small id="emailHelp" class="form-text text-muted">This is your product image</small>
                    </div>
                </div>
                
                <!-- /.card-body -->
            </div>
            <button class="btn btn-info btn-block"type="submit">Update</button>
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
    $('.dropify').dropify({
        messages:{
            'defaoult': 'Click Here',
            'replace' : 'Drag and drop to replace',
            'remove'  : 'Remove',
            'error'   : 'Ooops, something wrong'
        }
    });
</script>
@endsection
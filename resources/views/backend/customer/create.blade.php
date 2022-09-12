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
            <h1>New Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">New Customer</li>
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
       
        <form action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
          <!-- left column -->
          @csrf
          <div class="row">
           <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add new Customer</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
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
@endsection
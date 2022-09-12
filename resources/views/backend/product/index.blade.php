@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <a class="breadcrumb-item active btn btn-info" href="{{route('product.create')}}">+Add Products</a>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                    <th>description</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($product as $row)
                    <tr>
                        <td>{{$row->name}}</td>
                        <td>{{$row->stock_quantity}} </td>
                        <td>{{$row->purchase_price}}</td>
                        <td> {{$row->selling_price}}</td>
                        <td> {!!$row->description!!}</td>
                        <td><img src="{{asset('Files/product/'.$row->images)}}" alt="" srcset="" height="100px" width="150px" ></td>
                        <td>
                            <a href="{{route('product.edit',$row->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> edit</a>
                            <a href="{{route('product.destroy',$row->id)}}"id="delete" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> delete</a>
                        </td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
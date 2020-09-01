@extends('admin.layouts.main')

@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        All products
        <span class="pull-right">
            <a href="{{route('products.create')}}" class=" btn btn-success btn-sm"> Add New Product</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            @if(count($products) > 0)
                <input type="text" placeholder="Search Here" class="input-sm form-control">
            @else 
                <p>No records found!</p>
            @endif
            </div>
        </div>
    </div>
    @if(count($products) > 0)
    <table class="table table-hover p-table">
        <thead>
        <tr>
            <th>Product Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Vendor</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><a href="#"><img alt="image" class="" src="{{asset('img/product-list/pro-thumb-1.jpg')}}"></a></td>
                <td class="p-name">
                    {{$product->title}}
                </td>
                <td></td>
                <td>{{$product->price}}</td>
                <td>
                    <span class="badge badge-primary">{{ucfirst($product->status)}}</span>
                </td>
                <td>{{$product->vendor->shop_name}}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                    <a href="#" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</section>
<!-- page end-->
@endsection
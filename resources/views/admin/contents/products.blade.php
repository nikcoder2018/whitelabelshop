@extends('admin.layouts.main')

@section('stylesheets')
<style>
    .p-thumb img {
        width: 50px;
        height: 50px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>
@endsection
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
                <td><a href="#" class="thumb p-thumb"><img alt="image" src="{{asset($product->image_url)}}"></a></td>
                <td class="p-name">
                    {{$product->title}}
                </td>
                <td>
                    @if($product->categories)
                        @foreach($product->categories as $category)
                            @php $category = App\Category::where('id', $category->category_id)->first(); @endphp
                            <span>{{$category->name}}</span> <br>
                        @endforeach
                    @endif
                </td>
                <td>{{$product->regular_price}}</td>
                <td>
                    <span class="badge badge-primary">{{ucfirst($product->status)}}</span>
                </td>
                <td>{{$product->vendor->vendor_name}}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm btn-view"><i class="fa fa-eye"></i> View </a>
                    <a href="{{route('products.edit', $product->id)}}" class="btn btn-info btn-sm btn-edit"><i class="fa fa-pencil"></i> Edit </a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{$product->id}}"><i class="fa fa-trash-o"></i> Delete </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</section>
<!-- page end-->
@endsection

@section('scripts')
<script>
    $('.btn-delete').on('click', function(){
        let product_id = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(async (willDelete) => {
                if (willDelete) {

                    let goDelete = await $.ajax({
                        url: "{{route('products.destroy')}}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: product_id
                        }
                    });

                    if(goDelete.success){
                        swal(goDelete.msg, {
                            icon: "success",
                        }).then(()=>{
                            location.reload();
                        });
                    }else{
                        swal(goDelete.msg, {
                            icon: "error"
                        });
                    }
                    
                }
            });
    });
</script>
@endsection
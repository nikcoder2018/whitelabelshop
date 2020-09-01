@extends('admin.layouts.main')

@section('external_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/fuelux/css/tree-style.css')}}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Add Category
            </div>
            <div class="card-body">
                <form action="{{route('categories.store')}}" id="form-add-category" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="input-name">Name</label>
                        <input type="text" name="name" class="form-control" id="input-name" placeholder="e.g Men's Clothing" required>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g mens-clothing">
                    </div>
                    <div class="form-group">
                        <label for="input-parent">Parent</label>
                        <select name="parent" class="form-control">
                            <option value="">No parent</option>
                            @if(count($categories) > 0)
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Categories
            </div>
            <div class="card-body">
                <div id="FlatTree3" class="tree tree-plus-minus tree-solid-line tree-unselectable">
                    {!!$categories_tree!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('external_js')
    <script src="{{asset('assets/fuelux/js/tree.min.js')}}"></script>
@endsection

@section('scripts')
    <script src="{{asset('js/tree.js')}}"></script>
    <script>
        $(document).ready(function() {
            TreeView.init();

            $('#form-add-category').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(resp){
                        if(resp.success){
                            $('#FlatTree3').hide();
                            $('#FlatTree3').html(resp.html_build).fadeIn();
                        }
                    }
                });
            });
        });
    </script>
@endsection
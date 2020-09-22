@extends('admin.layouts.main')

@section('external_css')
    <link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/fuelux/css/tree-style.css')}}" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        select {
            font-family: 'FontAwesome', 'sans-serif';
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card" id="card-add-category">
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
                        <label for="input-slug">Description</label>
                        <textarea name="description" cols="30" rows="6" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Select Icon</label>
                        {!!view('admin.components.input-select-icons', ['name' => 'icon'])->render()!!}
                    </div>
                    <div class="form-group">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 300px; height: 250px;">
                                <img src="http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 20px;"></div>
                            <div>
                             <span class="btn btn-sm btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="image" class="default" />
                             </span>
                            <span class="btn btn-sm btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</span>
                            </div>
                        </div>
                        <span class="badge badge-danger">NOTE!</span>
                       <span>
                       Attached image thumbnail is
                       supported in Latest Firefox, Chrome, Opera,
                       Safari and Internet Explorer 10 only
                       </span>
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

        <div class="card" style="display:none" id="card-edit-category">
            <div class="card-header">
                Update Category
            </div>
            <div class="card-body">
                <form action="{{route('categories.update')}}" id="form-edit-category" method="POST">
                    @csrf 
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="input-name">Name</label>
                        <input type="text" name="name" class="form-control" id="input-name" placeholder="e.g Men's Clothing" required>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g mens-clothing">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Description</label>
                        <textarea name="description" cols="30" rows="6" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Select Icon</label>
                        {!!view('admin.components.input-select-icons', ['name' => 'icon'])->render()!!}
                    </div>
                    <div class="form-group">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 300px; height: 250px;">
                                <img src="http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image" class="thumbnail-image" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 250px; line-height: 20px;"></div>
                            <div>
                             <span class="btn btn-sm btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="image" class="default" />
                             </span>
                            <span class="btn btn-sm btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</span>
                            </div>
                        </div>
                        <span class="badge badge-danger">NOTE!</span>
                       <span>
                       Attached image thumbnail is
                       supported in Latest Firefox, Chrome, Opera,
                       Safari and Internet Explorer 10 only
                       </span>
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
                    <button type="button" class="btn btn-danger  btn-addnew">Add New</button>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
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
    <script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
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
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(resp){
                        if(resp.success){
                            $('#FlatTree3').hide();
                            $('#FlatTree3').html(resp.html_build).fadeIn();
                            $('#form-add-category')[0].reset();
                        }
                    }
                });
            });
            $('#form-add-category').on('change keypress keyup', 'input[name=name]', async function(){
                const slug = await $.ajax({
                    url: "{{route('slugify')}}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        text: $(this).val()
                    }
                });

                if(slug){
                    $('#form-add-category').find('input[name=slug]').val(slug);
                }
            });
            $('#form-edit-category').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(resp){
                        if(resp.success){
                            swal(resp.msg, {
                                icon: "success",
                            }).then(()=>{
                                $('#FlatTree3').hide();
                                $('#FlatTree3').html(resp.html_build).fadeIn();
                                $('#form-edit-category').find('.thumbnail-image').attr('src', 'http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image');
                                $('#form-edit-category')[0].reset();
                            });
                            
                        }
                    }
                });
            });
            $('#form-edit-category').on('change keypress keyup', 'input[name=name]', async function(){
                const slug = await $.ajax({
                    url: "{{route('slugify')}}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        text: $(this).val()
                    }
                });

                if(slug){
                    $('#form-edit-category').find('input[name=slug]').val(slug);
                }
            });
            $('#FlatTree3').on('click', '.edit-category', async function(e){
                e.stopPropagation();
                let category_id = $(this).data('id');
                let card_add = $('#card-add-category');
                let card_edit = $('#card-edit-category');
                let form_edit = $('#form-edit-category');
                let category = await $.ajax({
                    url: "{{route('json.getcategorydata')}}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: category_id
                    }
                });
                card_add.hide();
                card_edit.show();

                form_edit.find('input[name=id]').val(category.id);
                form_edit.find('input[name=name]').val(category.name);
                form_edit.find('input[name=slug]').val(category.slug);
                form_edit.find('textarea[name=description]').val(category.description);
                form_edit.find('select[name=icon]').val(category.icon);
                if(category.image != '' && category.image != null){
                    form_edit.find('.thumbnail-image').attr('src', category.image);
                }else{
                    form_edit.find('.thumbnail-image').attr('src', 'http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image');
                }
                form_edit.find('select[name=parent]').val(category.parent);
                
            });

            $('#FlatTree3').on('click', '.delete-category', function(e){
                e.stopPropagation();
                let category_id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this category!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willDelete) => {
                    if (willDelete) {

                        let goDelete = await $.ajax({
                            url: "{{route('categories.destroy')}}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: category_id
                            }
                        });

                        if(goDelete.success){
                            swal(goDelete.msg, {
                                icon: "success",
                            }).then(()=>{
                                $('#FlatTree3').html(goDelete.html_build);
                            });
                        }else{
                            swal(goDelete.msg, {
                                icon: "error",
                            });
                        }
                        
                    }
                });
            });

            $('.btn-addnew').on('click',function(){
                let card_add = $('#card-add-category');
                let card_edit = $('#card-edit-category');

                card_edit.hide();
                card_add.show();
                
            });

        });

        
    </script>
@endsection
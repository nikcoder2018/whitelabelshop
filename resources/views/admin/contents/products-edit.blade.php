@extends('admin.layouts.main')

@section('external_css')
    <link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('assets/switchery/switchery.css')}}" rel="stylesheet"/>
@endsection
@section('stylesheets')
<style>
    .category-list{
        padding: 1rem
    }

    .category-list .children{
        margin-left: 18px;
    }
    #categoryTab .nav-link{
        padding: .3rem .5rem !important;
    }

    #categoryTabContent{
        border-bottom: 1px solid #dee2e6;
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;

        max-height: 250px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
@endsection
@section('content')
<form class="form-edit-product" action="{{route('products.update')}}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$product->id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    All products |
                    <a href="{{route('products.index')}}" class="btn btn-white btn-sm">Products List</a>
                    <span class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                        {{-- <button type="sumbit" class="btn btn-primary btn-sm">Save as draft</button> --}}
                    </span>
                </header>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Product Title
                </div>
                <div class="card-body">
                    <input type="text" name="title" id="input-title" class="form-control round-input" value="{{$product->title}}" placeholder="E.g. Blue Jeans">
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <div class="summernote">{!!$product->description!!}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Options
                </div>
                <div class="card-body">
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                        <li class="nav-item general"><a class="nav-link active show" href="#tab_general" data-toggle="tab">General</a></li>
                        <li class="nav-item inventory"><a class="nav-link" href="#tab_stock" data-toggle="tab">Inventory</a></li>
                        {{-- <li class="nav-item attribute"><a class="nav-link" href="#tab_attribute" data-toggle="tab">Attributes</a></li> --}}
                        </ul>
                        <div class="tab-content">
                        <div class="tab-general tab-pane fade active show" id="tab_general">  
                            <div class="form-group mt-3">
                                <div class="row">
                                    <label class="col-sm-6 control-label" for="input-regular_price">Regular Price ($)</label>
                                    <div class="col-sm-6">
                                        <input type="number" placeholder="Regular Price" id="input-regular_price" name="regular_price" class="form-control" min="0" step="any" value="{{$product->regular_price}}">
                                    </div>
                                </div>  
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-6 control-label" for="input-sale_price">Sale Price ($)</label>
                                    <div class="col-sm-6">
                                        <input type="number" placeholder="Sale Price" id="input-sale_price" name="sale_price" class="form-control" min="0" step="any" value="{{$product->sale_price}}"> 
                                    </div>
                                </div>  
                            </div>
                        </div>
                        
                        <div class="tab-stock tab-pane fade" id="tab_stock">
                            <div class="form-group mt-3">
                                <div class="row">
                                    <label class="col-sm-6 control-label">Manage Stock</label>
                                    <div class="col-sm-6">
                                    <label class="">
                                            <input type="checkbox" @if($product->stock_management == 'Y') checked @endif class="enable-stock-switch"/> &nbsp; Enable stock management for product
                                    </label>                                             
                                    </div>
                                </div>    
                            </div>
                            <div class="form-group stock-qty" @if($product->stock_management == 'N') style="display: none;" @endif>
                                <div class="row">  
                                    <label class="col-sm-6 control-label" for="input-stock_qty">Stock Qty</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" placeholder="Stock Qty" id="input-stock_qty" name="stock_qty" class="form-control" value="{{$product->stock_qty}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">  
                                    <label class="col-sm-6 control-label" for="input-stock_availability_status">Stock Availability</label>
                                    <div class="col-sm-6">
                                    <select id="input-stock_availability_status" name="stock_availability_status" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option @if($product->stock_availability == 'in_stock') selected @endif value="in_stock">In Stock</option>
                                        <option @if($product->stock_availability == 'out_of_stock') selected @endif value="out_of_stock">Out of Stock</option>                  
                                    </select>
                                    
                                    </div>
                                </div>  
                            </div>
                        </div>
                                                                                                            
                        {{-- <div class="tab-advanced tab-pane fade" id="tab_attribute">
                            <div class="form-group mt-3">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="attrNameByProduct" id="attrNameByProduct" placeholder="name example - size or colors or quantity">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="attrValuesByProduct" id="attrValuesByProduct" placeholder="attribute values example - small,medium,large">
                                        <span>Enter attribute values by comma separator</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <a class="btn btn-default btn-sm add-new-attribute" href="">Add Attribute</a>
                                    </div>
                                </div>    
                            </div>
                        </div>   --}}
                        
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            {{-- <div class="card">
                <div class="card-header">
                    Publish
                </div>
                <div class="card-body">
                    
                </div>
            </div> --}}

            <div class="card">
                <div class="card-header">
                    Category
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="categoryTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mostused-tab" data-toggle="tab" href="#mostused" role="tab" aria-controls="mostused" aria-selected="false">Most used</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="categoryTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <ul class="category-list">
                                {!!$categoriesHTML!!}
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="mostused" role="tabpanel" aria-labelledby="mostused-tab">

                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Image
                </div>
                <div class="card-body">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 300px; height: 250px;">
                            @if($product->image_url)
                                <img src="{{asset($product->image_url)}}" alt="" />
                            @else 
                                <img src="http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            @endif
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
            </div>
            <div class="card">
                <div class="card-header">
                    Tags
                </div>
                <div class="card-body">
                    @php 
                    $productTags = array();
                    if($product->tags){
                        foreach($product->tags as $tag){
                            array_push($productTags,$tag->tag);
                        }
                    }
                    @endphp
                    <input name="tags" id="tagsinput" class="tagsinput" value="{{implode(',',$productTags)}}" />
                    <span class="badge badge-danger">NOTE!</span><span class="help-inline">Press enter or commas to separate tags</span>

                    <p class="mb-2 mt-3">Choose from your tags list:</p>
                    @foreach($tags as $tag)
                        <button type="button" data-id="{{$tag->id}}" data-tag="{{$tag->tag}}" class="btn btn-sm btn-primary btn-tag">{{$tag->tag}}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="pull-right">
                <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                {{-- <button type="sumbit" class="btn btn-primary btn-sm">Save as draft</button> --}}
            </span>
        </div>
    </div>
</form>
@endsection

@section('external_js')
    <script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
    <script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap-switch/static/js/bootstrap-switch.js')}}"></script>
    <script src="{{asset('assets/switchery/switchery.js')}}"></script>

    <script src="{{asset('js/jquery.tagsinput.js')}}"></script>
    
@endsection

@section('scripts')
<script src="{{asset('js/form-component.js')}}"></script>
<script>

    $(document).ready(function(){
        $('.form-edit-product').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('description', $(this).find('.summernote').summernote('code'));
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(resp){
                    if(resp.success){
                        swal(resp.msg, {
                            icon: 'success'
                        }).then(()=>{
                            location.href = "{{route('products.index')}}";
                        });
                    }else{
                        swal(resp.msg, {
                            icon: 'error'
                        });
                    }
                },
                error: function(resp){
                    let form = $('.form-edit-product');
                    $.each(resp.responseJSON.errors, function(name, error){
                        form.find('#input-'+name).siblings('.invalid-feedback').remove();
                        form.find('#input-'+name).siblings('.valid-feedback').remove();
                        form.find('#input-'+name).siblings('.invalid-feedback.valid-feedback').remove();
                        form.find('#input-'+name).addClass('is-invalid');
                        form.find('#input-'+name).after(`
                            <div class="invalid-feedback">
                            ${error}
                            </div>
                        `);
                    });
                }
            });
        });

        $('.form-add-product').on('change, keypress', 'input', function(){
            $(this).removeClass("is-invalid is-valid");
            $(this).siblings('.invalid-feedback').remove();
            $(this).siblings('.valid-feedback').remove();
        });


        $('.summernote').summernote({
            height: 250,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });
        
        $('.btn-tag').on('click', function(){
            let tag = $(this).data('tag');
            let tagsInput = $('#tagsinput');
            if(!tagsInput.tagExist(tag)){
                tagsInput.importTags(tagsInput.val()+','+tag);
            }
        });

        //small
        var elem = document.querySelector('.enable-stock-switch');
        var switchery = new Switchery(elem, { size: 'small' });

        $('.enable-stock-switch').on('change', function(){
            if($(this).prop('checked')){
                $('.stock-qty').show();
            }else{
                $('.stock-qty').hide();
            }
        })
    });

</script>
@endsection


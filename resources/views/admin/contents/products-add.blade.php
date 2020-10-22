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
<form class="form-add-product" action="{{route('products.store')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    All products |
                    <a href="{{route('products.index')}}" class="btn btn-white btn-sm">Products List</a>
                    <span class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm">Save & Publish</button>
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
                    <input type="text" name="title" id="input-title" class="form-control round-input" placeholder="E.g. Blue Jeans">
                </div>
            </div>  

            <div class="card">
                <div class="card-header">
                    Slug
                </div>
                <div class="card-body">
                    <input type="text" name="slug" id="input-title" class="form-control" placeholder="E.g. blue-jeans">
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <div class="summernote"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Pricing
                </div>
                <div class="card-body">
                    <div class="form-group mt-3">
                        <div class="row">
                            <label class="col-sm-6 control-label" for="input-regular_price">Regular Price ($)</label>
                            <div class="col-sm-6">
                            <input type="number" placeholder="Regular Price" id="input-regular_price" name="regular_price" class="form-control" min="0" step="any" value="">
                            </div>
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
                    Vendor
                </div>
                <div class="card-body">
                    @if(count($vendors) > 0)
                    <select name="vendor" class="form-control">
                        @foreach($vendors as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
                        @endforeach
                    </select>
                    @else 
                    <p>No vendors registered</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Image
                </div>
                <div class="card-body">
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
            </div>
            <div class="card">
                <div class="card-header">
                    Tags
                </div>
                <div class="card-body">
                    <input name="tags" id="tagsinput" class="tagsinput" value="" />
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
        <div class="col-md-12">
            <span class="pull-right">
                <button type="submit" class="btn btn-success btn-sm">Save & Publish</button>
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
        $('.form-add-product').on('submit', function(e){
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
                    let form = $('.form-add-product');
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

        $('.form-add-product').on('change keypress keyup', 'input[name=title]', async function(){
            const slug = await $.ajax({
                url: "{{route('slugify')}}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    text: $(this).val()
                }
            });

            if(slug){
                $('.form-add-product').find('input[name=slug]').val(slug);
            }
        });
        $('.form-add-product').on('change keypress', 'input', function(){
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

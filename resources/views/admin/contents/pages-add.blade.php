@extends('admin.layouts.main')

@section('external_css')
<link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        Create Page
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('pages.store')}}" id="form-add-page" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="input-title">Title</label>
                        <input type="text" name="title" class="form-control" id="input-title" placeholder="e.g About us">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g about_us">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Content</label>
                        <div class="content-editor"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
</section>
<!-- page end-->
@endsection


@section('external_js')
    <script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.content-editor').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });

        $('#form-add-page').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize()+ '&content='+$('#form-add-page').find('.content-editor').summernote('code'),
                success: function(resp){
                    if(resp.success){
                        swal(resp.msg, {
                            icon: 'success'
                        }).then(()=>{
                            location.href = "{{route('pages.index')}}"
                        });
                    }else{
                        swal(resp.msg, {
                            icon: 'error'
                        });
                    }
                },
                error: function(resp){
                    let form = $('#form-add-page');
                    let errorFields = [];
                    $.each(resp.responseJSON.errors, function(name, error){
                        errorFields.push(name);
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

                    $.each(form.find('input'), function(i, field){
                        if($.inArray($(field).attr('name'), errorFields) == -1){
                            if($(field).attr('name') != '_token'){
                                $(field).addClass('is-valid');
                                $(field).siblings('.invalid-feedback').remove();
                                $(field).siblings('.valid-feedback').remove();
                                $(field).after('<div class="valid-feedback">Looks good!</div>'); 
                            } 
                        }
                    });
                }
            });
        });

        $('#form-add-page').on('change, keypress', 'input', function(){
            $(this).removeClass("is-invalid is-valid");
            $(this).siblings('.invalid-feedback').remove();
            $(this).siblings('.valid-feedback').remove();
        });
    });
</script>
@endsection
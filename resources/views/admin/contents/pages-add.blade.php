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
                        <input type="text" name="title" class="form-control" id="input-title" placeholder="e.g About us" required>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g about_us">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Content</label>
                        <div class="content-editor"></div>
                    </div>
                    <button type="button" class="btn btn-primary">Submit</button>
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
    jQuery(document).ready(function(){
        $('.content-editor').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });
    });
</script>
@endsection
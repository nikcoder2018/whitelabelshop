@extends('admin.layouts.main')

@section('external_css')
<link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        All pages
        <span class="pull-right">
            <a data-toggle="modal" href="#modal-add" class=" btn btn-success btn-sm"> Add New Page</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($pages) > 0)
                    <table class="table table-hover p-table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                                <tr>
                                    <td class="p-name">
                                        {{$page->title}}
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ucfirst($page->status)}}</span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                                        <button class="btn btn-info btn-sm btn-edit" data-id="{{$page->id}}"><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{$page->id}}"><i class="fa fa-trash-o"></i> Delete </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else 
                    <p>No records found!</p>
                @endif
            </div>
        </div>
    </div>
    
</section>
<!-- page end-->
@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Create New Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pages.store')}}" id="form-add-page" method="POST">
                @csrf
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Edit Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pages.update')}}" id="form-edit-page" method="POST">
                <input type="hidden" name="id">
                @csrf
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->
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
                        $('#modal-add').modal('hide');
                        swal(resp.msg, {
                            icon: 'success'
                        }).then(()=>{
                            location.reload();
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

        $('.btn-edit').on('click', async function(){
            let form = $('#form-edit-page');
            let modal = $('#modal-edit');
            let page_id = $(this).data('id');
            let page = await $.ajax({
                url: "{{route('json.getpagedata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: page_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(page.id);
            form.find('input[name=title]').val(page.title);
            form.find('input[name=slug]').val(page.slug);
            form.find('.content-editor').summernote('code',page.content);
        });

        $('#form-edit-page').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(resp){
                    if(resp.success){
                        $('#modal-edit').modal('hide');
                        swal(resp.msg, {
                            icon: 'success'
                        }).then(()=>{
                            location.reload();
                        });
                    }else{
                        swal(resp.msg, {
                            icon: 'error'
                        });
                    }
                },
                error: function(resp){
                    let form = $('#form-edit-page');
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

        $('.btn-delete').on('click', function(){
            let page_id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this page!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willDelete) => {
                    if (willDelete) {

                        let goDelete = await $.ajax({
                            url: "{{route('pages.destroy')}}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: page_id
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
    });
</script>
@endsection
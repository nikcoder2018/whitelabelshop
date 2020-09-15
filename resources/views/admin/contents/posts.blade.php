@extends('admin.layouts.main')

@section('external_css')
<link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
<link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        Posts
        <span class="pull-right">
            <a data-toggle="modal" href="#modal-add" class=" btn btn-success btn-sm"> Add New</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($posts) > 0)
                    <table class="table table-hover p-table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Tags</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="p-name">
                                        {{$post->title}}
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ucfirst($post->author->firstname)}} {{ucfirst($post->author->lastname)}}</span>
                                    </td>
                                    <td>
                                        @if($post->tags)
                                            @foreach($post->tags as $tag)
                                                <span class="badge badge-info">{{$tag->tag}}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                                        <button class="btn btn-info btn-sm btn-edit" data-id="{{$post->id}}"><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{$post->id}}"><i class="fa fa-trash-o"></i> Delete </button>
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
                <h5 class="modal-title" id="myModal2">Create New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('posts.store')}}" id="form-add-post" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-title">Title</label>
                        <input type="text" name="title" class="form-control" id="input-title" placeholder="e.g Write your post title">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g write_your_post_slug">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Content</label>
                        <div class="content-editor"></div>
                    </div>
                    <div class="form-group">
                        <label for="input-content">Featured Image</label>
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
                        <label for="input-content">Tags</label>
                        <input name="tags" id="tagsinput" class="add-tagsinput" value="" />
                        <span class="badge badge-danger">NOTE!</span><span class="help-inline">Press enter or commas to separate tags</span>

                        <p class="mb-2 mt-3">Choose from your tags list:</p>
                        @foreach($tags as $tag)
                            <button type="button" data-id="{{$tag->id}}" data-tag="{{$tag->tag}}" class="btn btn-sm btn-primary btn-tag">{{$tag->tag}}</button>
                        @endforeach
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
                <h5 class="modal-title" id="myModal2">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('posts.update')}}" id="form-edit-post" method="POST">
                <input type="hidden" name="id">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-title">Title</label>
                        <input type="text" name="title" class="form-control" id="input-title" placeholder="e.g Write your post title">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g write_your_post_slug">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Content</label>
                        <div class="content-editor"></div>
                    </div>
                    <div class="form-group">
                        <label for="input-content">Featured Image</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 300px; height: 250px;">
                                <img src="http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image" alt=""  class="thumbnail-image"/>
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
                        <label for="input-content">Tags</label>
                        <input name="tags" id="tagsinput" class="edit-tagsinput" value="" />
                        <span class="badge badge-danger">NOTE!</span><span class="help-inline">Press enter or commas to separate tags</span>

                        <p class="mb-2 mt-3">Choose from your tags list:</p>
                        @foreach($tags as $tag)
                            <button type="button" data-id="{{$tag->id}}" data-tag="{{$tag->tag}}" class="btn btn-sm btn-primary btn-tag">{{$tag->tag}}</button>
                        @endforeach
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
    <script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
    <script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('js/jquery.tagsinput.js')}}"></script>
    <script src="{{asset('js/form-component.js')}}"></script>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(".add-tagsinput").tagsInput();
        $(".edit-tagsinput").tagsInput();
        $('.content-editor').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });

        $('#form-add-post').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('content', $(this).find('.content-editor').summernote('code'));
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  formData,
                contentType: false,
                cache: false,
                processData:false,
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
                    let form = $('#form-add-post');
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

        $('#form-add-post').on('change, keypress', 'input', function(){
            $(this).removeClass("is-invalid is-valid");
            $(this).siblings('.invalid-feedback').remove();
            $(this).siblings('.valid-feedback').remove();
        });

        $('.btn-edit').on('click', async function(){
            let form = $('#form-edit-post');
            let modal = $('#modal-edit');
            let post_id = $(this).data('id');
            let post = await $.ajax({
                url: "{{route('json.getpostdata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: post_id
                }
            });
            modal.modal('show');
            
            if(post.tags){
                $.each(post.tags, function(i, tag){
                    let tagsInput = $('.edit-tagsinput');
                    if(!tagsInput.tagExist(tag.tag)){
                        tagsInput.importTags(tagsInput.val()+','+tag.tag);
                    }
                });
            }
            form.find('input[name=id]').val(post.id);
            form.find('input[name=title]').val(post.title);
            form.find('input[name=slug]').val(post.slug);
            form.find('.thumbnail-image').attr('src', post.thumbnail);
            form.find('.content-editor').summernote('code',post.content);
        });

        $('#form-edit-post').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('content', $(this).find('.content-editor').summernote('code'));
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  formData,
                contentType: false,
                cache: false,
                processData:false,
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
                    let form = $('#form-edit-post');
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
                            url: "{{route('posts.destroy')}}",
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

        $('.btn-tag').on('click', function(){
            let tag = $(this).data('tag');
            let tagsInput = $('#tagsinput');
            if(!tagsInput.tagExist(tag)){
                tagsInput.importTags(tagsInput.val()+','+tag);
            }
        });
    });
</script>
@endsection
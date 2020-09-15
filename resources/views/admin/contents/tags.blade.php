@extends('admin.layouts.main')

@section('external_css')
    <link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
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
        <div class="card" id="card-add-tag">
            <div class="card-header">
                Create New Tag
            </div>
            <div class="card-body">
                <form action="{{route('tags.store')}}" id="form-add-tag" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="input-name">Tag</label>
                        <input type="text" name="tag" class="form-control" id="input-tag" placeholder="e.g Tag" required>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g tag">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Description</label>
                        <textarea name="description" cols="30" rows="4" class="form-control"></textarea>
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
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </form>
            </div>
        </div>
        <div class="card" id="card-edit-tag" style="display:none" >
            <div class="card-header">
                Create New Tag
            </div>
            <div class="card-body">
                <form action="{{route('tags.update')}}" id="form-edit-tag" method="POST">
                    @csrf 
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="input-name">Tag</label>
                        <input type="text" name="tag" class="form-control" id="input-tag" placeholder="e.g Tag" required>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="input-slug" placeholder="e.g tag">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Description</label>
                        <textarea name="description" cols="30" rows="4" class="form-control"></textarea>
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
                    <button type="button" class="btn btn-success  btn-addnew">Add New</button>
                    <button type="button" class="btn btn-danger  btn-delete">Remove</button>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Tags
            </div>
            <div class="card-body">
                <div class="tags-container">
                    @if(count($tags) > 0)
                        @foreach($tags as $tag)
                        <button type="button" data-id="{{$tag->id}}" class="btn btn-round btn-primary btn-tag">{{$tag->tag}}</button>
                        @endforeach
                    @else 
                    <p>No tags yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#form-add-tag').on('submit', function(e){
            let form = this;

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
                        $('.tags-container').append(`<button type="button" data-id="${resp.details.id}" class="btn btn-round btn-primary btn-tag">${resp.details.tag}</button>`);
                        form.reset();
                    }
                }
            });
        });

        $('#form-edit-tag').on('submit', function(e){
                let form = this;

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
                                location.reload();
                            });
                            
                        }
                    }
                });
            });

        $('.btn-tag').on('click',async function(){
            let tag_id = $(this).data('id');
            let card_add = $('#card-add-tag');
            let card_edit = $('#card-edit-tag');
            let form_edit = $('#form-edit-tag');
            let tag = await $.ajax({
                url: "{{route('json.gettagdata')}}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: tag_id
                }
            });

            card_add.hide();
            card_edit.show();

            form_edit.find('input[name=id]').val(tag.id);
            form_edit.find('input[name=tag]').val(tag.tag);
            form_edit.find('input[name=slug]').val(tag.slug);
            form_edit.find('textarea[name=description]').val(tag.description);
            form_edit.find('select[name=icon]').val(tag.icon);

            if(tag.image != "")
            form_edit.find('.thumbnail-image').attr('src', tag.image);
            else 
            form_edit.find('.thumbnail-image').attr('src', "http://www.placehold.it/300x250/EFEFEF/AAAAAA&amp;text=no+image");

            form_edit.find('.btn-delete').attr('data-id', tag.id);
        });

        $('.btn-addnew').on('click',function(){
            let card_add = $('#card-add-tag');
            let card_edit = $('#card-edit-tag');

            card_edit.hide();
            card_add.show();
            
        });
        $('.btn-delete').on('click', function(e){
                let tag_id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this tag!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willDelete) => {
                    if (willDelete) {

                        let goDelete = await $.ajax({
                            url: "{{route('tags.destroy')}}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: tag_id
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
                                icon: "error",
                            });
                        }
                        
                    }
                });
            });

    });
</script>
@endsection


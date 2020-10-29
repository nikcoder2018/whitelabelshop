@extends('admin.layouts.main')

@section('external_css')
<link href="{{asset('assets/fuelux/css/tree-style.css')}}" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
<style>
    select {
        font-family: 'FontAwesome', 'sans-serif';
    }
</style>
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        Locations
        <span class="pull-right">
            <a data-toggle="modal" href="#modal-add" class=" btn btn-success btn-sm"> Add Location</a>
            <a data-toggle="modal" href="#modal-import" class=" btn btn-success btn-sm"> Add Import</a>
        </span>
    </header>
    <div class="card-body">
        <div id="FlatTree3" class="tree tree-plus-minus tree-solid-line tree-unselectable">
            @foreach($regions as $region)
            <div class="tree-folder">
                <div class="tree-folder-header">
                    <i class="fa fa-folder"></i>
                    <div class="tree-folder-name">
                        {{$region->name}} <div class="tree-actions"><i class="fa fa-edit edit-category" data-id=""></i><i class="fa fa-trash-o delete-category" data-id=""></i></div>
                    </div>
                </div>
                <div class="tree-folder-content" style="display: none;">
                    @if(count($region->countries) > 0)
                        @foreach($region->countries as $country)
                        <div class="tree-folder">
                            <div class="tree-folder-header">
                                <i class="fa fa-folder"></i>
                                <div class="tree-folder-name">
                                    {{$country->name}} <div class="tree-actions"><i class="fa fa-edit edit-category" data-id=""></i><i class="fa fa-trash-o delete-category" data-id=""></i></div>
                                </div>
                            </div>
                            <div class="tree-folder-content" style="display:none;">
                                @if(count($country->cities) > 0)
                                    @foreach($country->cities as $city)
                                    <div class="tree-item">
                                        <i class="tree-dot"></i>
                                        <div class="tree-item-name">
                                            {{$city->name}} <div class="tree-actions"><i class="fa fa-edit edit-category" data-id=""></i><i class="fa fa-trash-o delete-category" data-id=""></i></div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="tree-item">
                                        <i class="tree-dot"></i>
                                        <div class="tree-item-name">
                                            {{$country->name}} <div class="tree-actions"><i class="fa fa-edit edit-category" data-id=""></i><i class="fa fa-trash-o delete-category" data-id=""></i></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tree-loader"></div>
                        </div>
                        @endforeach
                    @else
                    @endif
                </div>
                <div class="tree-loader"></div>
            </div>
            @endforeach
        </div>
    </div>
    
</section>
<!-- page end-->
@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Add Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.store')}}" id="form-add-location" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Region</label>
                        <input type="text" name="region" class="form-control" id="input-region" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="input-city">City</label>
                        <input type="text" name="city" class="form-control" id="input-city" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="input-street">Street</label>
                        <input type="text" name="street" class="form-control" id="input-street" placeholder="">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Edit Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.update')}}" id="form-edit-location" method="POST">
                <input type="hidden" name="id">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Region</label>
                        <input type="text" name="region" class="form-control" id="input-region" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="input-city">City</label>
                        <input type="text" name="city" class="form-control" id="input-city" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="input-street">Street</label>
                        <input type="text" name="street" class="form-control" id="input-street" placeholder="">
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
    <script src="{{asset('assets/fuelux/js/tree.min.js')}}"></script>
@endsection

@section('scripts')
<script src="{{asset('js/tree.js')}}"></script>
<script>
    $(document).ready(function(){

        TreeView.init();

        $('#form-add-location').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  $(this).serialize(),
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
                    let form = $('#form-add-location');
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

        $('#form-add-location').on('change, keypress', 'input', function(){
            $(this).removeClass("is-invalid is-valid");
            $(this).siblings('.invalid-feedback').remove();
            $(this).siblings('.valid-feedback').remove();
        });

        $('.btn-edit').on('click', async function(){
            let form = $('#form-edit-location');
            let modal = $('#modal-edit');
            let location_id = $(this).data('id');
            let location = await $.ajax({
                url: "{{route('json.getlocationdata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: location_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(location.id);
            form.find('input[name=region]').val(location.region);
            form.find('input[name=city]').val(location.city);
            form.find('input[name=street]').val(location.street);
        });

        $('#form-edit-location').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  $(this).serialize(),
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
                    let form = $('#form-edit-location');
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
            let location_id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this location!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willDelete) => {
                    if (willDelete) {

                        let goDelete = await $.ajax({
                            url: "{{route('locations.destroy')}}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: location_id
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
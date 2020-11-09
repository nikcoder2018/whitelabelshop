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
            <a data-toggle="modal" href="#modal-region-add" class=" btn btn-success btn-sm"> Add Region</a>
            <a data-toggle="modal" href="#modal-country-add" class=" btn btn-success btn-sm"> Add Country</a>
            <a data-toggle="modal" href="#modal-city-add" class=" btn btn-success btn-sm"> Add City</a>
        </span>
    </header>
    <div class="card-body">
        <div id="FlatTree3" class="tree tree-plus-minus tree-solid-line tree-unselectable">
            @foreach($regions as $region)
            <div class="tree-folder">
                <div class="tree-folder-header">
                    <i class="fa fa-folder"></i>
                    <div class="tree-folder-name">
                        {{$region->name}} <div class="tree-actions"><i class="fa fa-edit edit-region" data-id="{{$region->id}}"></i><i class="fa fa-trash-o delete-region" data-id="{{$region->id}}"></i></div>
                    </div>
                </div>
                <div class="tree-folder-content" style="display: none;">
                    @if(count($region->countries) > 0)
                        @foreach($region->countries as $country)
                        <div class="tree-folder">
                            <div class="tree-folder-header">
                                <i class="fa fa-folder"></i>
                                <div class="tree-folder-name">
                                    {{$country->name}} <div class="tree-actions"><i class="fa fa-edit edit-country" data-id="{{$country->id}}"></i><i class="fa fa-trash-o delete-country" data-id="{{$country->id}}"></i></div>
                                </div>
                            </div>
                            <div class="tree-folder-content" style="display:none;">
                                @if(count($country->cities) > 0)
                                    @foreach($country->cities as $city)
                                    <div class="tree-item">
                                        <i class="tree-dot"></i>
                                        <div class="tree-item-name">
                                            {{$city->name}} <div class="tree-actions"><i class="fa fa-edit edit-city" data-id="{{$city->id}}"></i><i class="fa fa-trash-o delete-city" data-id="{{$city->id}}"></i></div>
                                        </div>
                                    </div>
                                    @endforeach
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
<div class="modal fade" id="modal-region-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Add Region</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.store')}}" class="form-add" method="POST">
                @csrf
                <input type="hidden" name="type" value="region">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Region Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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
<div class="modal fade" id="modal-country-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Add Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.store')}}" class="form-add" method="POST">
                @csrf
                <input type="hidden" name="type" value="country">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Select Region</label>
                        <select name="region_id" id="" class="form-control">
                            @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-country">Country Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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
<div class="modal fade" id="modal-city-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Add City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.store')}}" class="form-add" method="POST">
                @csrf
                <input type="hidden" name="type" value="city">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Select Country</label>
                        <select name="country_id" id="" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-country">City Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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
<div class="modal fade" id="modal-region-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Edit Region</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.update')}}" class="form-update" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="type" value="region">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Region Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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
<div class="modal fade" id="modal-country-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Edit Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.update')}}" class="form-update" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="type" value="country">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Select Region</label>
                        <select name="region_id" id="" class="form-control">
                            @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-country">Country Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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
<div class="modal fade" id="modal-city-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Edit City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('locations.update')}}" class="form-update" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="type" value="city">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-region">Select Country</label>
                        <select name="country_id" id="" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-country">City Name</label>
                        <input type="text" name="name" class="form-control" placeholder="">
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

        $('.form-add').on('submit', function(e){
            e.preventDefault();
            let form = $(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  $(this).serialize(),
                success: function(resp){
                    if(resp.success){
                        $('#modal-region-add').modal('hide');
                        $('#modal-country-add').modal('hide');
                        $('#modal-city-add').modal('hide');
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

        $('.form-update').on('submit', function(e){
            e.preventDefault();
            let form = $(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  $(this).serialize(),
                success: function(resp){
                    if(resp.success){
                        $('#modal-region-add').modal('hide');
                        $('#modal-country-add').modal('hide');
                        $('#modal-city-add').modal('hide');
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

        $('#FlatTree3').on('click', '.edit-region', async function(e){
            e.stopPropagation();
            let region_id = $(this).data('id');
            let modal = $('#modal-region-edit');
            let form = modal.find('form');
            let region = await $.ajax({
                url: "{{route('json.getlocationdata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: 'region',
                    id: region_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(region.id);
            form.find('input[name=name]').val(region.name);
        });
        $('#FlatTree3').on('click', '.edit-country', async function(e){
            e.stopPropagation();
            let country_id = $(this).data('id');
            let modal = $('#modal-country-edit');
            let form = modal.find('form');
            let country = await $.ajax({
                url: "{{route('json.getlocationdata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: 'country',
                    id: country_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(country.id);
            form.find('select[name=region_id]').val(country.region);
            form.find('input[name=name]').val(country.name);
        });
        $('#FlatTree3').on('click', '.edit-city', async function(e){
            e.stopPropagation();
            let city_id = $(this).data('id');
            let modal = $('#modal-city-edit');
            let form = modal.find('form');
            let city = await $.ajax({
                url: "{{route('json.getlocationdata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: 'city',
                    id: city_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(city.id);
            form.find('select[name=country_id]').val(city.country);
            form.find('input[name=name]').val(city.name);
        });

        $('#FlatTree3').on('click', '.delete-region', function(e){
            e.stopPropagation();
            let region_id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this region!",
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
                            type: 'region',
                            id: region_id
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
        $('#FlatTree3').on('click', '.delete-country', function(e){
            e.stopPropagation();
            let country_id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this country!",
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
                            type: 'country',
                            id: country_id
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
        $('#FlatTree3').on('click', '.delete-city', function(e){
            e.stopPropagation();
            let city_id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this region!",
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
                            type: 'city',
                            id: city_id
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
@extends('admin.layouts.main')

@section('external_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/select2/css/select2.min.css')}}"/>
@endsection
@section('stylesheets')
<style>
    .ui-widget-content{
        border-radius: 0 !important;
        border: 1px solid #dddddd !important; 
        background: #ffffff !important;
        color: #333333 !important;
        z-index: 9999 !important;
    }
</style>
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        All vendors
        <span class="pull-right">
            <a data-toggle="modal" href="#modal-add" class=" btn btn-success btn-sm"> Add New Vendor</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($vendors) > 0)
                    <table class="table table-hover p-table">
                        <thead>
                        <tr>
                            <th>Shop</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $vendor)
                                <tr>
                                    <td class="p-name">
                                        <a href="{{env('APP_FRONT_URL').'/restaurants/'.$vendor->id.'/details'}}" target="_blank">{{$vendor->vendor_name}}</a>
                                        <br>
                                        <small>Registered {{date('m.d.Y',strtotime($vendor->created_at))}}</small>
                                    </td>
                                    <td>{{$vendor->email}}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ucfirst($vendor->status)}}</span>
                                    </td>
                                    <td>
                                        <a href="{{env('APP_FRONT_URL').'/restaurants/'.$vendor->id.'/details'}}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                                        <button class="btn btn-info btn-sm btn-edit" data-id="{{$vendor->id}}"><i class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{$vendor->id}}"><i class="fa fa-trash-o"></i> Delete </button>
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
<div class="modal fade " id="modal-add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">Add new vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('vendors.store')}}" id="form-add-vendor" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-shop">*Restaurant name (Naziv restorana)</label>
                            <input type="text" name="shop_name" class="form-control input-shop_name" placeholder="Enter shopname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-email">*Email address</label>
                            <input type="email" name="email" class="form-control input-email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-fname">First name</label>
                            <input type="text" name="firstname" class="form-control input-firstname" placeholder="Enter firstname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-lname">Last name</label>
                            <input type="text" name="lastname" class="form-control input-lastname" placeholder="Enter lastname">
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="input-address">Address (Adresa)</label>
                            <input type="text" name="address" class="form-control input-address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="input-country">Country</label>
                            <select name="country" class="input-country"></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-city">City(Grad)</label>
                            <select name="city" class="input-city"></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-phone">Phone number</label>
                            <input type="text" name="phone" class="form-control input-phone" placeholder="Phone number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-contactperson">Name of contact persone (Ime kontakt osobe) </label>
                            <input type="text" name="contactperson" class="form-control input-contactperson" placeholder="Contact Person">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-contactpersonnumber">*Phone of contact persone (Telefon kontakt osobe)</label>
                            <input type="text" name="contactpersonnumber" class="form-control input-contactpersonnumber" placeholder="Contact Person Phone Number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="input-contactperson">*PIB (number unique)</label>
                            <input type="number" name="vat" class="form-control input-vat" placeholder="VAT" maxlength="9">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-contactperson">*Matični broj (number unique)</label>
                            <input type="number" name="vat_sec" class="form-control input-vat" placeholder="VAT" maxlength="9">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-subscription">Subscription Plan</label>
                            <select name="subscription" class="form-control">
                                <option value="basic">Basic Plan</option>
                                <option value="premium">Premium Plan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-password">Password</label>
                            <input type="password" name="password" class="form-control input-password" placeholder="Password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-cpassword">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control input-password_confirmation" placeholder="Confirm Password">
                        </div>
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
<div class="modal fade " id="modal-edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">Edit vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('vendors.update')}}" id="form-edit-vendor" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-shop">*Restaurant name (Naziv restorana)</label>
                            <input type="text" name="shop_name" class="form-control input-shop_name" placeholder="Enter shopname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-email">*Email address</label>
                            <input type="email" name="email" class="form-control input-email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-fname">First name</label>
                            <input type="text" name="firstname" class="form-control input-firstname" placeholder="Enter firstname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-lname">Last name</label>
                            <input type="text" name="lastname" class="form-control input-lastname" placeholder="Enter lastname">
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="input-address">Address (Adresa)</label>
                            <input type="text" name="address" class="form-control input-address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="input-country">Country</label>
                            <select name="country" class="edit-input-country"></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-city">City(Grad)</label>
                            <select name="city" class="edit-input-city"></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-phone">Phone number</label>
                            <input type="text" name="phone" class="form-control input-phone" placeholder="Phone number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-contactperson">Name of contact persone (Ime kontakt osobe) </label>
                            <input type="text" name="contactperson" class="form-control input-contactperson" placeholder="Contact Person">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-contactpersonnumber">*Phone of contact persone (Telefon kontakt osobe)</label>
                            <input type="text" name="contactpersonnumber" class="form-control input-contactpersonnumber" placeholder="Contact Person Phone Number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-contactperson">*VAT (PDV)</label>
                            <input type="number" name="vat" class="form-control input-vat" placeholder="VAT" maxlength="9">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-subscription">Subscription Plan</label>
                            <select name="subscription" class="form-control">
                                <option value="basic">Basic Plan</option>
                                <option value="premium">Premium Plan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="input-password">Password</label>
                            <input type="password" name="password" class="form-control input-password" placeholder="Password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="input-cpassword">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control input-password_confirmation" placeholder="Confirm Password">
                        </div>
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
@endsection

@section('external_js')
<script type="text/javascript" src="{{asset('assets/select2/js/select2.min.js')}}"></script>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        $(".input-country").select2({
            tags: true,
            ajax:{
                url: "{{route('locations.countries')}}",
                dataType: "json",
                data:{
                    search: $( ".input-country").val()
                },
                type: "GET",
                processResults: function (data) {
                    return{
                        results: $.map(data.countries, function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });
        $('.input-country').on('select2:select', function(){
            $(".input-city").empty();
            $(".input-city").select2({
                tags: true,
                ajax:{
                    url: "{{route('locations.cities')}}",
                    dataType: "json",
                    data: function(params){
                        var query = {
                            search:  params.term,
                            country: $( ".input-country").val()
                        }
                        
                        return query;
                    },
                    type: "GET",
                    processResults: function (data) {
                        return{
                            results: $.map(data.cities, function(item){
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            });
        });

        $(".input-city").select2({
            tags: true,
            ajax:{
                url: "{{route('locations.cities')}}",
                dataType: "json",
                data: function(params){
                    var query = {
                        search:  params.term,
                        country: $( ".input-country").val()
                    }
                    
                    return query;
                },
                type: "GET",
                processResults: function (data) {
                    return{
                        results: $.map(data.cities, function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        $(".edit-input-country").select2({
            tags: true,
            ajax:{
                url: "{{route('locations.countries')}}",
                dataType: "json",
                data:{
                    search: $( ".edit-input-country").val()
                },
                type: "GET",
                processResults: function (data) {
                    return{
                        results: $.map(data.countries, function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });
        $('.edit-input-country').on('select2:select', function(){
            $(".input-city").empty();
            $(".input-city").select2({
                tags: true,
                ajax:{
                    url: "{{route('locations.cities')}}",
                    dataType: "json",
                    data: function(params){
                        var query = {
                            search:  params.term,
                            country: $( ".edit-input-country").val()
                        }
                        
                        return query;
                    },
                    type: "GET",
                    processResults: function (data) {
                        return{
                            results: $.map(data.cities, function(item){
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            });
        });

        $(".edit-input-city").select2({
            tags: true,
            ajax:{
                url: "{{route('locations.cities')}}",
                dataType: "json",
                data: function(params){
                    var query = {
                        search:  params.term,
                        country: $( ".edit-input-country").val()
                    }
                    
                    return query;
                },
                type: "GET",
                processResults: function (data) {
                    return{
                        results: $.map(data.cities, function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        $('#form-add-vendor').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
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
                    let form = $('#form-add-vendor');
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

        $('#form-add-vendor').on('change, keypress', 'input', function(){
            $(this).removeClass("is-invalid is-valid");
            $(this).siblings('.invalid-feedback').remove();
            $(this).siblings('.valid-feedback').remove();
        });

        $('.btn-edit').on('click', async function(){
            let form = $('#form-edit-vendor');
            let modal = $('#modal-edit');
            let vendor_id = $(this).data('id');
            let vendor = await $.ajax({
                url: "{{route('json.getvendordata')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: vendor_id
                }
            });
            modal.modal('show');
            form.find('input[name=id]').val(vendor.id);
            form.find('input[name=email]').val(vendor.email);
            form.find('input[name=shop_name]').val(vendor.vendor_name);
            form.find('input[name=country]').val(vendor.country);
            form.find('input[name=city]').val(vendor.city);
            form.find('input[name=vat]').val(vendor.vat);

            if(vendor.vendor_details){
                form.find('input[name=firstname]').val(vendor.vendor_details.firstname);
                form.find('input[name=lastname]').val(vendor.vendor_details.lastname);
                form.find('input[name=address]').val(vendor.vendor_details.address);
                form.find('input[name=phone]').val(vendor.vendor_details.phone);
                
                form.find('input[name=contactperson]').val(vendor.vendor_details.contact_person_name);
                form.find('input[name=contactpersonnumber]').val(vendor.vendor_details.contact_person_number);
                form.find('select[name=subscription]').val(vendor.vendor_details.subscription);
            }
        });

        $('#form-edit-vendor').on('submit', function(e){
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
                    let form = $('#form-edit-vendor');
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
            let vendor_id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this vendor account!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willDelete) => {
                    if (willDelete) {

                        let goDelete = await $.ajax({
                            url: "{{route('vendors.destroy')}}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: vendor_id
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
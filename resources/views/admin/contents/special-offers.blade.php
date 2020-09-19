@extends('admin.layouts.main')


@section('external_css')
<link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-datepicker/css/datepicker.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-datetimepicker/css/datetimepicker.css')}}" />
@endsection

@section('stylesheets')
<style>
    .p-thumb img {
        width: 50px;
        height: 50px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>
@endsection
@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        Special Offers
        <span class="pull-right">
            <a data-toggle="modal" href="#modal-add" class=" btn btn-success btn-sm"> Add Special Offer</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            @if(count($special_offers) > 0)
                <input type="text" placeholder="Search Here" class="input-sm form-control">
            @else 
                <p>No records found!</p>
            @endif
            </div>
        </div>
    </div>
    @if(count($special_offers) > 0)
    <table class="table table-hover p-table">
        <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($special_offers as $offer)
            <tr>
                <td><a href="#" class="thumb p-thumb"><img alt="image" src="{{asset($offer->image)}}"></a></td>
                <td class="p-name">
                    {{$offer->title}}
                </td>
                <td>{{$offer->description}}</td>
                <td>{{$offer->price}}</td>
                <td>
                    <span class="badge badge-primary">{{ucfirst($offer->status)}}</span>
                </td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm btn-view"><i class="fa fa-eye"></i> View </a>
                    <a href="{{route('specialoffers.edit', $offer->id)}}" class="btn btn-info btn-sm btn-edit"><i class="fa fa-pencil"></i> Edit </a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{$offer->id}}"><i class="fa fa-trash-o"></i> Delete </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</section>
<!-- page end-->
@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2">Create Special Offer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('specialoffers.store')}}" id="form-add-offer" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-title">Title</label>
                        <input type="text" name="title" class="form-control" id="input-title" placeholder="e.g What is your special offer?">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Description</label>
                        <textarea name="description" rows="6" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-content">Image</label>
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
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12 ">Date Start</label>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="input-group date dpMonths" data-date-viewmode="months" data-date-format="mm/yyyy" data-date="12-08-2017">
                                <input type="text" name="date_start" class="form-control" placeholder="03-07" aria-label="Right Icon" aria-describedby="dp-mdo">
                                <div class="input-group-append">
                                    <button id="dp-mdo" class="btn btn-primary" type="button"><i class="fa fa-calendar f14"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" name="time_start" class="form-control timepicker-default rounded mr-3" aria-label="Right Icon" aria-describedby="basic-addon15">
                                <span class="input-group-addon btn btn-primary" id="basic-addon15"><i class="fa fa-clock-o f14"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12 ">Date Ends</label>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="input-group date dpMonths" data-date-viewmode="months" data-date-format="mm/yyyy" data-date="12-08-2017">
                                <input type="text" name="date_end" class="form-control" placeholder="03-07" aria-label="Right Icon" aria-describedby="dp-mdo">
                                <div class="input-group-append">
                                    <button id="dp-mdo" class="btn btn-primary" type="button"><i class="fa fa-calendar f14"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" name="start_time" class="form-control timepicker-default rounded mr-3" aria-label="Right Icon" aria-describedby="basic-addon15">
                                <span class="input-group-addon btn btn-primary" id="basic-addon15"><i class="fa fa-clock-o f14"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                       <label for="input-price" class="col-form-label col-lg-2 col-sm-12">Price</label>
                       <div class="col-md-5 col-sm-12">
                            <input type="number" name="price" class="form-control" id="input-price" step="0.1">
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
<!-- modal -->
@endsection

@section('external_js')
    <script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap-daterangepicker/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>

      <!--pickers script-->
    <script src="{{asset('js/pickers/init-date-picker.js')}}"></script>
    <script src="{{asset('js/pickers/init-datetime-picker.js')}}"></script>
    <script src="{{asset('js/pickers/init-color-picker.js')}}"></script>

    <script src="{{asset('js/form-component.js')}}"></script>
@endsection

@section('scripts')
<script>
    $('#form-add-offer').on('submit', function(e){
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
    $('.btn-delete').on('click', function(){
        let product_id = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(async (willDelete) => {
                if (willDelete) {

                    let goDelete = await $.ajax({
                        url: "{{route('products.destroy')}}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: product_id
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
</script>
@endsection
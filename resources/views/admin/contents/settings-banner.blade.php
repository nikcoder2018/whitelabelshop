@extends('admin.layouts.main')

@section('external_css')
    <link href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card" id="card-add-category">
            <div class="card-header">
                Change Home Banner Image
            </div>
            <div class="card-body">
                <form action="{{route('settings.banner')}}" class="form-save-script" method="POST">
                    @csrf 
                    <input type="hidden" name="type" value="home">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 700px; height: 250px;">
                                @if($home_hero != '')
                                    <img src="{{asset($home_hero)}}" alt="" />
                                @else 
                                    <img src="http://www.placehold.it/700x250/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                @endif
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 700px; max-height: 250px; line-height: 20px;"></div>
                            <div>
                            <span class="btn btn-sm btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="image" class="default" />
                            </span>
                            <span class="btn btn-sm btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</span>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card" id="card-add-category">
            <div class="card-header">
                Change Dashboard Banner Image
            </div>
            <div class="card-body">
                <form action="{{route('settings.banner')}}" class="form-save-script" method="POST">
                    @csrf 
                    <input type="hidden" name="type" value="dashboard">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 700px; height: 250px;">
                                @if($dashboard_banner != '')
                                    <img src="{{asset($dashboard_banner)}}" alt="" />
                                @else 
                                    <img src="http://www.placehold.it/700x250/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                @endif
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 700px; max-height: 250px; line-height: 20px;"></div>
                            <div>
                            <span class="btn btn-sm btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="image" class="default" />
                            </span>
                            <span class="btn btn-sm btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</span>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('external_js')
    <script src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.form-save-script').on('submit', function(e){
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
                        swal({
                            title: 'Success!',
                            text: resp.msg,
                            icon: "success",
                        }).then(()=>{
                            location.reload();
                        });
                    }
                }
            });
        });
    });

    
</script>
@endsection
@extends('admin.layouts.main')

@section('external_css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/nestable/jquery.nestable.css')}}" />
    <style>
        select {
            font-family: 'FontAwesome', 'sans-serif';
        }

        .nestable-actions{
            position: absolute;
            margin-top: -20px;
            right: 4px;
            z-index: 1;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card" id="card-add-category">
            <div class="card-header">
                Add footer scripts
            </div>
            <div class="card-body">
                <form action="{{route('settings.footer')}}" id="form-save-script" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="input-slug">Javascript</label>
                        <textarea name="footer_scripts" cols="30" rows="15" class="form-control">{!!$footer_scripts!!}</textarea>
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
            $('#form-save-script').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data:  $(this).serialize(),
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
@extends('admin.layouts.main')

@section('content')
<!-- page start-->
<section class="card">
    <header class="card-header">
        All admins
        <span class="pull-right">
            <a data-toggle="modal" href="#myModal" class="btn btn-success btn-sm"> Add New Admin</a>
        </span>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($admins) > 0)
                    @foreach($admins as $admin)
                    <table class="table table-hover p-table">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="p-name">
                                <a href="#">{{$admin->firstname}} {{$admin->lastname}}</a>
                                <br>
                                <small>Registered {{date('m.d.Y',strtotime($admin->created_at))}}</small>
                            </td>
                            <td>{{$admin->email}}</td>
                            <td>
                                <span class="badge badge-primary">{{ucfirst($admin->status)}}</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                
                        </tbody>
                    </table>
                    @endforeach
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
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">Add new admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admins.store')}}" id="form-add-admin" method="POST">
                @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label for="input-email">Email address</label>
                            <input type="email" name="email" class="form-control" id="input-email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="input-fname">First name</label>
                            <input type="text" name="firstname" class="form-control" id="input-fname" placeholder="Enter firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="input-lname">Last name</label>
                            <input type="text" name="lastname" class="form-control" id="input-lname" placeholder="Enter lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="input-password">Password</label>
                            <input type="password" name="password" class="form-control" id="input-password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="input-cpassword">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" id="input-cpassword" placeholder="Confirm Password" required>
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

@section('scripts')
<script>
    $(document).ready(function(){
        $('#form-add-admin').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(resp){

                }
            });
        });
    });
</script>
@endsection
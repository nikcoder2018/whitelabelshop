@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Create Attribute
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Attributes
            </div>
            <div class="card-body">
                <table class="table table-hover p-table">
                    <thead>
                    <tr>
                        <th>Attributes Name</th>
                        <th>Attributes Values</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="p-name">
                            Size
                        </td>
                        <td>S,M,L,XL</td>
                        <td>
                            <span class="badge badge-primary">Active</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View </a>
                            <a href="#" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </a>
                        </td>
                    </tr>
            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


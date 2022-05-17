@extends('layouts.default')

@section('title', 'Contract - Po')

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Type Config Type</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit rerum neque praesentium natus, amet fugit qui eius atque reprehenderit aperiam! Amet odit quam velit delectus laboriosam earum natus enim perspiciatis!</p>

    <!-- List Config Type -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Config Type
                <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#status-create">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Create Config Type</span>
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="type_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">display</th>
                            <th class="text-center">Required</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $type)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$type->name}}</td>
                            <td class="text-center">{{$type->display}}</td>
                            <td class="text-center">
                                @if ($type->required == 1)
                                <i class="nav-icon fas fa-check text-success"></i>
                                @else
                                <i class="nav-icon fas fa-times text-red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-primary btn-sm dropdown-hover" data-toggle="modal" data-target="#type-edit" data-id="{{$type->id}}" data-name="{{$type->name}}" data-display="{{$type->display}}" data-required="{{$type->required}}" onclick="editData(this)">
                                        <i class="nav-icon fas fa-pen"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Edit</a>
                                        </div>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <form action="/types/{{$type->id}}" onsubmit="return confirm('Are you sure you want to delete?')" method="post" class="d-inline my-0">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm dropdown-hover">
                                            <i class="nav-icon fas fa-trash"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">Delete</a>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">display</th>
                            <th class="text-center">Required</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Config Type -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#type_table").DataTable({
            // processing: true,
            // serverSide: true,
            language: {
                searchPlaceholder: "Search",
                search: '<i class="fas fa-search"></i>',
                'paginate': {
                    'previous': '<a>Back <i class="fas fa-hand-point-left"></i></a>',
                    'next': '<a><i class="fas fa-hand-point-right"></i> Next</a>',
                }
            }
        });
    });
</script>
@stop

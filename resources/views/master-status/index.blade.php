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
    <h1 class="h3 mb-2 text-gray-800">Master Status</h1>
    <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repudiandae, corrupti magni impedit a voluptate enim eum obcaecati aperiam, tenetur ipsam sint non necessitatibus delectus unde, asperiores quis dolore temporibus ea!</p>

    <!-- List Master Status -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Master Status
                <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#status-create">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Create Status</span>
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="status_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">ID Number</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($progress_status as $status)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$status->id}}</td>
                            <td>{{$status->status}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}" method="get" class="d-inline my-0">
                                        <button class="btn btn-sm btn-warning dropdown-hover">
                                            <i class="nav-icon fas fa-eye"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">Show</a>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}/edit" method="get" class="d-inline my-0">
                                        <button class="btn btn-sm btn-primary dropdown-hover">
                                            <i class="nav-icon fas fa-pen"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">Edit</a>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}" onsubmit="return confirm('Are you sure you want to delete?')" method="post" class="d-inline my-0">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger dropdown-hover">
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
                            <th class="text-center">ID Number</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Master Status -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#status_table").DataTable({
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

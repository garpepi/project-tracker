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
    <h1 class="h3 mb-2 text-gray-800">Type Config Email</h1>
    <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita architecto harum autem nemo eos, doloremque quisquam libero dolore! Commodi placeat quasi eveniet recusandae a asperiores? Corrupti id porro libero! Omnis.</p>

    <!-- List Config Email -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Config Email
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="email_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">Frequency</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Emails</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ec as $e)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$e->frequency->name}}</td>
                            @if ($e->frequency->name == 'Day')
                            <td class="text-center">{{$e->duration}}:00</td>
                            @elseif($e->frequency->name == 'Month')
                            <td class="text-center">{{$e->duration}}th</td>
                            @elseif($e->frequency->name == 'Week')
                            <td class="text-center">Day {{$e->duration}}</td>
                            @endif
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-warning btn-sm dropdown-hover" data-toggle="modal" data-target="#show-email" data-id="{{$e->id}}" onclick="emailShow(this)">
                                        <i class="nav-icon fas fa-eye"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Cek Email</a>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-primary btn-sm dropdown-hover" data-toggle="modal" data-target="#email-edit" data-id="{{$e->id}}" data-freq-id="{{$e->frequency->id}}" data-duration="{{$e->duration}}" data-email-id="{{$e->email}}" onclick="editData(this)">
                                        <i class="nav-icon fas fa-pen"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Edit</a>
                                        </div>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <form action="/email_configuration/{{$e->id}}" onsubmit="return confirm('Are you sure you want to delete?')" method="post" class="d-inline my-0">
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
                            <th class="text-center">Frequency</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Emails</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Config Email -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#email_table").DataTable({
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

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
    <h1 class="h3 mb-2 text-gray-800">Project Status</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nisi eius nulla molestias earum reiciendis voluptates nemo voluptas omnis quidem tenetur doloremque praesentium perspiciatis, cupiditate explicabo odio repellat sequi eligendi quod!</p>

    <!-- List Project Status -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
                Project Status
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="status_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Progress Status</th>
                            <th class="text-center">Invoicing Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects_status as $status)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td>{{$status->name}}</td>
                            <td class="text-right">{{$status->no_po}}</td>
                            <td class="text-center text-bold {{$status->status <= 30 ? 'text-red' :
                            ($status->status <= 99 ? 'text-blue' : 'text-green') }}" style="font-size: 130%"> {{$status->status}}%</td>
                            <td class="text-center text-bold {{$status->invoice_status <= 30 ? 'text-red' :
                            ($status->status <= 99 ? 'text-blue' : 'text-green') }}" style="font-size: 130%"> {{$status->invoice_status}}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Progress Status</th>
                            <th class="text-center">Invoicing Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Project Status -->

</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    console.log("here");
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

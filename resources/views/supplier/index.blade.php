@extends('layouts.default')

@section('title', 'Supplier')

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
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, sed doloremque magnam fuga ad doloribus minima dolores asperiores corrupti quidem sapiente dignissimos impedit distinctio aut repudiandae recusandae ea debitis enim.</p>

    <!-- List Supplier -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')
                        <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#suplier-create">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Create Supplier</span>
                        </button>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="supplier_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supliers as $item)
                                <tr>
                                    <th class="text-center" width="30px">{{$loop->iteration}}</th>
                                    <td class="text-center">{{$item->name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Supplier -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#supplier_table").DataTable({
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
    //button submit
    $('#myFormIdEdit').submit(function() {
        $("#myButtonID", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
    //Create
    $('#myFormIdCreate').submit(function() {
        $("#myButtonIDCreate", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@stop

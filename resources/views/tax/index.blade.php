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
    <h1 class="h3 mb-2 text-gray-800">Tax Proof</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, ullam delectus reprehenderit distinctio ea ab repudiandae quis natus dolore velit doloremque ipsa alias doloribus corrupti ad voluptatum et placeat molestias!</p>

    <!-- List Tax Proof -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Tax Proof
                <a href="{{ route('payments.index') }}" class="btn btn-primary btn-icon-split">
                    <span class="text">Payment</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tax_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO</th>
                            <th class="text-center">Invoice Number</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taxproof as $key => $item)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$item->project->no_po}}</td>
                            <td class="text-center">{{$item->invoice->invoice_number}}</td>
                            <td class="text-center">
                                @foreach ($taxproofwithtaxcollect as $val)
                                @if ($val->progress_id == $item->progress_id)
                                {{$val->tax->name}},
                                @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <form action="/taxproof/{{$item->id}}" method="get" class="d-inline">
                                        <button class="btn btn-sm btn-warning dropdown-hover">
                                            <i class="nav-icon fas fa-eye"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">Show</a>
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
                            <th class="text-center">PO</th>
                            <th class="text-center">Invoice Number</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">detail</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Tax Proof -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#tax_table").DataTable({
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

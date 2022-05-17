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
    <h1 class="h3 mb-2 text-gray-800">Account Receivable</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam ipsa praesentium hic vero doloremque odit nesciunt omnis in officiis, dolorum ea! Tempora sapiente unde illum optio adipisci? Delectus, dolores doloremque!</p>

    <!-- List Payment -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Account Receivable</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="payment_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Client</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Amount need to be paid</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoiceList as $invoice)
                        @if ($invoice->close != 1)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-left">{{$invoice->project->name}}</td>
                            <td class="text-right">{{$invoice->project->no_po}}</td>
                            <td class="text-left">{{$invoice->project->contract->client->name}}</td>
                            <td class="text-left">{{$invoice->progress_item->name_progress}}</td>
                            <td class="text-right">
                                @if ($invoice->actualPay != null)
                                @rupiah($invoice->amount_total - $invoice->actualPay)
                                @else
                                @rupiah($invoice->amount_total)
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" id="paymentCreate" data-invoice_id="{{$invoice->id}}" data-project_id="{{$invoice->project->id}}" data-project_name="{{$invoice->project->name}}" data-project_no_po="{{$invoice->project->no_po}}" data-client="{{$invoice->project->contract->client->name}}" data-progress_name="{{$invoice->progress_item->name_progress}}" data-tax_proof="{{$invoice->tax_proof}}" data-amount="@rupiah($invoice->amount_total)" data-amountcount="{{$invoice->amount_total}}" data-paid="{{$invoice->actualPay}}" data-paidrp="@rupiah($invoice->actualPay)" data-amountntbp="{{$invoice->amount_total}}" class="btn btn-primary btn-sm dropdown-hover" data-toggle="modal" data-target="#payment-create" onclick="createData(this)">
                                        <i class="nav-icon fas fa-credit-card"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Payment</a>
                                        </div>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <button type="button" data-id="{{$invoice->id}}" class="btn btn-warning btn-sm dropdown-hover" data-toggle="modal" data-target="#payment-show" onclick="showData(this)">
                                        <i class="nav-icon fas fa-eye"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Show</a>
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Client</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Amount need to be paid</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Payment -->

</div>

@stop

@include('supplier.modal_create')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#payment_table").DataTable({
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

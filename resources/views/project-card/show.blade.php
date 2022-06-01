@extends('layouts.default')

@section('title', 'Project Card - Detail')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<link href="{{asset('assets/')}}/costume/tablecostume.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/')}}/dist/css/custom/dropdowncustom.css">
<style>
    .form-control:disabled {
        background-color: #007bff33 !important;
        opacity: 1 !important;
    }
</style>
@stop

@section('custom_script')
<!-- Page level custom scripts -->
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="{{ url('/pages/js/helper.js') }}"></script>
@stop

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>

    <!-- Basic Card Example -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')
                        <div class="btn-group">
                            <form action="/projectcard/export/excel/{{$projectcarddetail->id}}" method="get" class="d-inline">
                                <button class="btn btn-sm btn-warning dropdown-hover">
                                    <i class="nav-icon fas fa-file-excel"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">Generate Excel</a>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <a class="float-right text-sm" href="/projectcard" style="color: red"><i class="fas fa-undo-alt"></i> Back</a>
                    </h6>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-around">
                        <div class="form-group col-4">
                            <label for="name">Contract Number</label>
                            <input type="text" class="form-control" name="name" value="{{$projectcarddetail->contract->cont_num}}" disabled="disabled">
                        </div>
                        <div class="form-group col-4">
                            <label for="name">Total Account Receiveable</label>
                            <input type="text" class="form-control" name="name" value="@rupiah($projectcarddetail->actualPay)" disabled="disabled">
                        </div>
                    </div>
                    <div class="d-flex justify-content-around">
                        <div class="form-group col-4">
                            <label for="name">PO Number</label>
                            <input type="text" class="form-control" name="name" value="{{$projectcarddetail->no_po}}" disabled="disabled">
                        </div>
                        <div class="form-group col-4">
                            <label for="name">Total Cost</label>
                            <input type="text" class="form-control" name="name" value="@rupiah($projectcarddetail->totalcost)" disabled="disabled">
                        </div>
                    </div>
                    <div class="d-flex justify-content-around mb-3">
                        <div class="form-group col-4">
                            <label for="name">Margin</label>
                            <input type="text" class="form-control @if($projectcarddetail->actualPay - $projectcarddetail->totalcost < 0) text-red @endif" name="name" value="@rupiah($projectcarddetail->actualPay - $projectcarddetail->totalcost)" disabled="disabled">
                        </div>
                    </div>


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Invoice</h3>
                            <!-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div> -->
                        </div>
                        <div class="card-body">
                            <table id="invoice_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Progress Name</th>
                                        <th class="text-center">Invoice Number</th>
                                        <th class="text-center">Total Tax</th>
                                        <th class="text-center">Total Invoice</th>
                                        <th class="text-center">Payment Total</th>
                                        <th class="text-center">Pay Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice as $key => $inv)
                                    <tr>
                                        <td class="text-center">{{$inv->progress_item->name_progress}}</td>
                                        <td class="text-center">{{$inv->invoice_number}}</td>
                                        <td class="text-center">
                                            @rupiah(($inv->percentagetax / 100) * $inv->amount_total)
                                        </td>
                                        <td class="text-center">
                                            @rupiah((($inv->percentagetax / 100) * $inv->amount_total) + $inv->amount_total)
                                        </td>
                                        <td class="text-center">@rupiah($inv->actualPay)</td>
                                        @if ($inv->actualPay > 0)
                                        @foreach ($inv->actual_payment as $item)
                                        <td class="text-center">{{$item->payment_date}}</td>
                                        @break
                                        @endforeach
                                        @else
                                        <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Progress Name</th>
                                        <th class="text-center">Invoice Number</th>
                                        <th class="text-center">Total Tax</th>
                                        <th class="text-center">Total Invoice</th>
                                        <th class="text-center">Payment Total</th>
                                        <th class="text-center">Pay Date</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Modal And Cost</h3>

                            <!-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div> -->
                        </div>
                        <div class="card-body">
                            <table id="modal_cost_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Progress Name</th>
                                        <th class="text-center">Supplier</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Already Paid</th>
                                        <th class="text-center">Bill Of Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projectcost as $key => $pro)
                                    <tr>
                                        @if (!empty($pro->progress_item))
                                        <td class="text-center">{{$pro->progress_item->name_progress}}</td>
                                        @else
                                        <td class="text-center text-red">not set</td>
                                        @endif
                                        <td class="text-center">{{$pro->suplier->name}}</td>
                                        <td class="text-center">{{$pro->desc}}</td>
                                        <td class="text-center">
                                            @if ($pro->payed == 1)
                                            <i class="fas fa-check-circle" style="color: rgb(39, 214, 39)"></i>
                                            @else
                                            <i class="fas fa-times-circle" style="color: rgb(163, 0, 0)"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">@rupiah($pro->budget_of_quantity)</td>
                                    </tr>
                                    @empty
                                    <tr id="empty-data" class="d-flex justify-content-center">
                                        <td style="color: #dc3545">-- Data Empty --</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Progress Name</th>
                                        <th class="text-center">Supplier</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Already Paid</th>
                                        <th class="text-center">Bill Of Quantity</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('custom-script')
<script>
    $(function() {
        $("#invoice_table").DataTable({
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
        $("#modal_cost_table").DataTable({
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

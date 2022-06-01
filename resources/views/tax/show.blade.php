@extends('layouts.default')

@section('title', 'Tax Proof')

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<style>
    .callout {
        border-radius: 0.25rem;
        box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%);
        background-color: #fff;
        border-left: 5px solid #e9ecef;
        margin-bottom: 1rem;
        padding: 1rem;
    }

    .callout.callout-info {
        border-left-color: #117a8b;
    }

    .invoice {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, .125);
        position: relative;
    }
</style>
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

    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')
                        <a href="{{ route('payments.index') }}" class="btn btn-primary btn-icon-split">
                            <span class="text">Payment</span>
                        </a>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Note:</h5>
                        Tax is displayed based on unpaid invoices.
                    </div>

                    <div class="invoice p-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-landmark"></i> Tax Invoice
                                    <small class="float-right">Created Date: {{ date('d M Y', $getproject->created_at->timestamp) }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Project
                                <br>
                                <b>Project Name :</b> {{$getproject->project->name}}<br>
                                <b>Project Number:</b> {{$getproject->project->no_po}}<br>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Contract
                                <br>
                                <b>Contract Name :</b> {{$getproject->project->contract->name}}<br>
                                <b>Contract Number:</b> {{$getproject->project->contract->cont_num}}<br>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{$getproject->invoice->id}}</b><br>
                                <b>Invoice Number:</b> {{$getproject->invoice->invoice_number}}<br>
                                <b>Amount Total Invoice:</b> @rupiah($getproject->invoice->amount_total)<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <hr>
                        <div class="row mt-3">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <div class="col-12">
                                    <p>
                                        <i class="fas fa-tasks"></i> Progress Item:
                                    </p>
                                </div>
                                <b>Progress Name :</b> {{$getproject->progress_item->name_progress}}<br>


                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:30%">Total Invoice:</th>
                                            <td></td>
                                            <td></td>
                                            <td>@rupiah($getproject->invoice->amount_total)</td>
                                        </tr>
                                        @php
                                        $sumTax = [];
                                        @endphp
                                        @foreach ($taxdetail as $key => $item)
                                        <tr>
                                            <th style="width:30%">{{$item->tax->name}}:</th>
                                            <td>
                                                @if ($item->received == 1)
                                                <input type="checkbox" checked disabled>
                                                @else
                                                <input id="cb{{$item->id}}" type="checkbox" value="{{$item->id}}" />
                                                @endif
                                            </td>
                                            <td>{{$item->percentage}}%</td>
                                            <td>@rupiah(($item->percentage / 100) * $getproject->invoice->amount_total)</td>
                                        </tr>
                                        @php
                                        $sumtax = ($item->percentage / 100) * $getproject->invoice->amount_total;
                                        $parshInt = (int)$sumtax;
                                        array_push($sumTax,$parshInt)
                                        @endphp
                                        @endforeach
                                        <tr>
                                            <th style="width:30%">Paid:</th>
                                            <td></td>
                                            <td></td>
                                            <td><b>@rupiah($actualPay->actualPay)</b></td>
                                        </tr>
                                        @php
                                        if ($actualPay->actualPay != null) {
                                        $total = array_sum($sumTax) + $getproject->invoice->amount_total - $actualPay->actualPay;
                                        } else {
                                        $total = array_sum($sumTax) + $getproject->invoice->amount_total;
                                        }
                                        @endphp
                                        <tr>
                                            <th style="width:30%">Total:</th>
                                            <td></td>
                                            <td></td>
                                            <td><b>@rupiah($total)</b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>

                    </div>
                    <div class="card-footer text-center float-right">
                        <a href="/taxproof" type="submit" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('input:checkbox').click(function() {
        var checked = $(this).is(':checked');
        if (checked) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-3'
                },
                buttonsStyling: false,
                allowOutsideClick: false
            })

            swalWithBootstrapButtons.fire({
                title: 'are you sure?',
                text: "Has the tax been paid?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var value = $('#' + this.id).val();
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: "/applytax/" + value,
                        type: 'get',
                        data: {
                            "id": value,
                            "_token": token,
                        },
                        success: function(data) {
                            if (data.received == "acc") {
                                swalWithBootstrapButtons.fire({
                                    title: 'Success',
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Error',
                                    'Data undefined :)',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, data, error) {}
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    $('#' + this.id).prop('checked', false);
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Thanks :)',
                        'error'
                    );
                }
            })
        }
    });
</script>
<script type="text/javascript">
    @if(count($errors) > 0)
    $('#type-create').modal('show');
    @endif
</script>
@stop

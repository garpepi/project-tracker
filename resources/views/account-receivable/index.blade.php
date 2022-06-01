@extends('layouts.default')

@section('title', 'Account Receivable')

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link href="{{asset('assets/')}}/costume/switchcostume.css" rel="stylesheet">
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
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam ipsa praesentium hic vero doloremque odit nesciunt omnis in officiis, dolorum ea! Tempora sapiente unde illum optio adipisci? Delectus, dolores doloremque!</p>

    <!-- List Payment -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')</h6>
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
        </div>
    </div>
    <!-- End List Payment -->
</div>
@include('account-receivable.modal_create')
@include('account-receivable.modal_show')
@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{asset('assets/')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{{asset('assets/')}}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

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
</script>
<script>
    $('#myFormIdCreate').submit(function() {
        $("#myButtonID", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
<script type="text/javascript">
    @if(count($errors) > 0)
    $('#payment-create').modal('show');
    console.log($errors);
    @endif
</script>
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<script>
    function createData(e) {
        console.log("hehe");
        var invoiceId = $(e).data("invoice_id");
        console.log(invoiceId);
        var projectId = $(e).data("project_id");
        var projectName = $(e).data("project_name");
        var projectNoPo = $(e).data("project_no_po");
        var client = $(e).data("client");
        var progressName = $(e).data("progress_name");
        var taxproof = $(e).data("tax_proof");
        // console.log(taxproof);
        var amount = $(e).data("amount");
        var amountcount = $(e).data("amountcount");
        var amountpaid = $(e).data("paid");
        var amountpaidrp = $(e).data("paidrp");
        var amountntbp = $(e).data("amountntbp");
        if (e != 0) {
            document.getElementById("invoice_id").value = invoiceId;
            document.getElementById("project_id").value = projectId;
            document.getElementById("po_name").value = projectName;
            document.getElementById("no_po").value = projectNoPo;
            document.getElementById("client").value = client;
            document.getElementById("progress_name").value = progressName;
            var countANTBP = amountpaid - amountntbp;
            var countANTBPrp = rubahkeRP(countANTBP);
            document.getElementById("amountNeedToBePaid").value = "Rp. " + countANTBPrp;
            document.getElementById("paid").value = amountpaidrp;
            // console.log(taxproof);
            if (taxproof.length != 0) {
                var arrayvaluesumtax = [];
                $("#taxprooflist div").remove();
                taxproof.forEach(element => {
                    if (element.received != 1) {
                        var countTax = (element.percentage / 100) * amountcount;
                        var taxsetMath = Math.round(countTax);
                        var taxsetParse = parseInt(taxsetMath);
                        var taxsetRP = rubahkeRP(taxsetMath);
                        arrayvaluesumtax.push(taxsetParse);
                        $("#taxprooflist").show();
                        var div = '<div class="form-group"><div class="input-group">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text"><strong>' + element.tax.name +
                            '</strong></span>' +
                            '</div>' +
                            '<input id="progress_name" name="tax[]" type="text" class="form-control text-right text-bold"' +
                            'value="Rp. ' + taxsetRP + '" readonly />' +
                            '</div>' +
                            '</div>';
                        $("#taxprooflist").append(div);
                    }
                });
                var TaxProofSUM = arrayvaluesumtax.reduce((a, b) => a + b, 0);
                if (TaxProofSUM == 0) {
                    $("#taxprooflist div").remove();
                    $("#taxdisplay").hide();
                } else {
                    var amountntbpSUMwithTax = TaxProofSUM + amountntbp;
                    var amountntbpSUMwithTaxRP = rubahkeRP(amountntbpSUMwithTax);
                    document.getElementById("amountWithTax").value = 'Rp. ' + amountntbpSUMwithTaxRP;
                    $("#taxdisplay").show();
                }
            } else {
                $("#taxprooflist div").remove();
                $("#taxdisplay").hide();
                // var amountntbpRP = rubahkeRP(amountntbp);
                // document.getElementById("amountWithTax").value = 'Rp. '+amountntbpRP;
            }
            document.getElementById("amountInvoice").value = amount;

            // alert(amountntbp);
        } else {
            alert("no");
            // console.log("")
        }
    }

    function rubahkeRP(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>
<script>
    function showData(e) {
        var id = $(e).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        // console.log(id);
        if (e) {
            $('#aldiTable').DataTable({
                processing: true,
                // serverSide: true,
                destroy: true,
                responsive: true,
                ajax: {
                    url: "/payments/show" + id,
                    type: 'get',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    // "dataSrc": "dataPay"
                    dataSrc: function(json) {
                        if (json.dataPay === null) {
                            return [];
                        }
                        // var amount = JSON.parse(json.dataPay);
                        // console.console.log(json.dataPay);
                        return json.dataPay;
                    }
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "invoice.progress_item.name_progress"
                    },
                    {
                        data: "invoice.project.contract.client.name"
                    },
                    {
                        data: "invoice.project.name"
                    },
                    {
                        data: "amount",
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
                    },
                    {
                        data: "invoice.amount_total",
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
                    },
                    {
                        data: "payment_date"
                    },
                ],
                "columnDefs": [{
                    "data": null
                }],
                language: {
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: "Search",
                    'paginate': {
                        'previous': '<a>Back <i class="fas fa-hand-point-left"></i></a>',
                        'next': '<a><i class="fas fa-hand-point-right"></i> Next</a>',
                    }
                }
            });
        }
    }
</script>
<script>
    $(function() {
        $('#payment_date').datetimepicker({
            // useCurrent: false,
            //disabled: true,
            format: 'YYYY-MM-DD',
        });
    });
</script>
<!-- Rupiah -->
<script type="text/javascript">
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<script>
    function Fclose() {
        var checkbox = $("#customSwitch2");
        if (checkbox.is(':checked')) {
            $("#desccomponen").show();
            $("#desc").prop('required', true);
        } else {
            $("#desccomponen").hide();
            $("#desc").prop('required', false);
        }
    }
    // var close = ;
    // console.log(close);
</script>
@stop

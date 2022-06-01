@extends('layouts.default')

@section('title', 'Payable ' . $progress->project->name)

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link href="{{asset('assets/')}}/costume/tablecostume.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
    <h1 class="h3 mb-2 text-gray-800">{{ 'No: ' . $progress->project->no_po . ' Progress: ' . $progress->progress_item->name_progress }}</h1>

    <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tenetur dolorum provident molestias tempore culpa corrupti harum amet aut voluptatibus. Illum at tempore totam hic, eum voluptatem cupiditate vero delectus! Consequatur?</p>

    <!-- List Account Payable -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="payable_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Bill Of Quantity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projectcost as $key => $pro)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$pro->suplier->name}}</td>
                                    <td class="text-center">{{$pro->desc}}</td>
                                    @if ($pro->payablePaid != 0)
                                    <td class="text-center">@rupiah($pro->budget_of_quantity - $pro->payablePaid)</td>
                                    @else
                                    <td class="text-center">@rupiah($pro->budget_of_quantity)</td>
                                    @endif
                                    <td class="text-center">
                                        <!-- Pay -->
                                        <div class="btn-group">
                                            <button onclick="payCost(this)" data-id="{{$pro->id}}" data-projectid="{{$pro->project_id}}" data-paidcheck="{{$pro->payablePaid}}" data-paid="@rupiah($pro->payablePaid)" data-supplier="{{$pro->suplier->name}}" data-boq="@rupiah($pro->budget_of_quantity)" data-antbp="@rupiah($pro->budget_of_quantity - $pro->payablePaid)" class="btn btn-sm btn-success dropdown-hover">
                                                <i class="nav-icon far fa-credit-card"></i>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item">Pay</a>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-data" class="d-flex justify-content-center">
                                    <td style="color: #dc3545">-- Data Empty --</td>
                                </tr>
                                @endforelse
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Bill Of Quantity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Account Payable -->
</div>

@stop

@include('account-payable.modal_pay_cost')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('assets/')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{{asset('assets/')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        $("#payable_table").DataTable({
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

<script>
    $(function() {
        $("#example1").DataTable({
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

<script>
    function initializeSelect2(selectElementObj) {
        selectElementObj.select2({
            //   theme: 'bootstrap',
            width: "100%",
            tags: true
        });
    }
    //onload: call the above function
    $(".select-to-select2").each(function() {
        initializeSelect2($(this));
    });
    var tax = {!!$taxs!!};
    // initailizeSelect2();
    var state = 0;
    $("#add-btnTax").click(function() {
        $("#add-btnTax").css("display", "none");
        $("#empty-data").remove();
        var tr1 = $("<tr>");
        var td1 = $("<td>").css("font-size", "16px");
        var select2 = $("<select>").addClass('form-control').addClass('select-to-select2').css("width", "100%").attr('name', 'tax[]');
        var option1 = $("<option>");
        select2.append(option1);
        $.each(tax, function(i, item) {
            if (item.id == 3) {
                select2.append($('<option>', {
                    selected: true,
                    value: item.id,
                    text: item.name
                }));
            }
        });
        var td =
            '</td>' +
            '<td class="col-4"> <div class="input-group">' +
            '<input style="text-align: right;" id="percentage' + state + '" type="number" name="percentage[]" step="0.01" data-state="' + state + '" onchange="getIDpercentage(this,' + state + ')" value="" placeholder="e.g 1,2" class="form-control" />' +
            '<div class="input-group-append"><div class="input-group-text"><i class="fas fa-percent"></i></div></div> </td>' +
            '<td><input id="total_tax' + state + '" readonly type="text" name="total_tax[]" class="form-control text-right" value="" /> <input type="hidden" name="tax_project_cost_id[]" value=""></td> ';
        var del = '<td><a type="button" class="btn btn-danger removeCost-tr">-</a></td>';
        td1.append(select2);
        tr1.append(td1);
        tr1.append(td);
        tr1.append(del);
        state++;

        $("#dynamicTax").append(tr1);
        initializeSelect2(select2);
    });
    $(document).on('click', '.removeCost-tr', function() {
        $(this).parents('tr').remove();
        $("#add-btnTax").css("display", "block");

        var projectcostDel = {!!$projectcost!!};
        var getProjectCostIDdel = $("#project_cost_id").val();
        // console.log(getProjectCostID);
        var getBOQdel;
        projectcostDel.forEach(element => {
            if (element.id == getProjectCostIDdel) {
                getBOQdel = element.budget_of_quantity;
            }
        });
        $("#BOQ").val(formatNum(getBOQdel, 'Rp. '));

        var getpaiddel;
        projectcostDel.forEach(element => {
            if (element.id == getProjectCostIDdel) {
                getpaiddel = element.payablePaid;
            }
        });
        var setpaiddel = getpaiddel;
        if (setpaiddel != null) {
            var setamtbpwithpaid = parseInt(getBOQdel) - parseInt(setpaiddel);
            $("#amountNeedToBePaid").val(formatNum(setamtbpwithpaid, 'Rp. '));
        }

        var checkBox = document.getElementById("checkboxPrimary1");
        var getBOQd = $("#BOQ").val();
        var getANTBPd = $("#amountNeedToBePaid").val();
        if (getANTBPd == "Rp. 0") {
            if (checkBox.checked == true) {
                $("#rupiah").val(getBOQd);
            } else {
                $("#rupiah").val('');
            }
        } else {
            if (checkBox.checked == true) {
                $("#rupiah").val(getANTBPd);
            } else {
                $("#rupiah").val('');
            }
        }
    });

    function getIDpercentage(v, state) {
        var getval = $(v).val();
        var getdpp = $("#dpp").val();
        var fixeddpp = getdpp.replace(/([a-z ._\-]+)/gi, '');
        var bagi100 = getval / 100;
        var jumlah = fixeddpp * bagi100;
        var fixjumlah = Math.round(jumlah);
        var changeRP = formatNum(fixjumlah, 'Rp. ');
        $("#total_tax" + state).val(changeRP);

        var projectcost = {!!$projectcost!!};
        var getProjectCostID = $("#project_cost_id").val();
        // console.log(getProjectCostID);
        var getBOQ;
        projectcost.forEach(element => {
            if (element.id == getProjectCostID) {
                getBOQ = element.budget_of_quantity;
            }
        });
        var setBOQ = getBOQ;
        var jumBOQ = setBOQ - fixjumlah;
        $("#BOQ").val(formatNum(jumBOQ, 'Rp. '));

        var getpaid;
        projectcost.forEach(element => {
            if (element.id == getProjectCostID) {
                getpaid = element.payablePaid;
            }
        });
        var setpaid = getpaid;
        if (setpaid != null) {
            var setamtbpwithpaid = parseInt(setBOQ) - parseInt(setpaid);
            var countAntbp = setamtbpwithpaid - fixjumlah;
            $("#amountNeedToBePaid").val(formatNum(countAntbp, 'Rp. '));
        }

        var checkBox = document.getElementById("checkboxPrimary1");
        var getBOQv = $("#BOQ").val();
        var getANTBPv = $("#amountNeedToBePaid").val();
        if (getANTBPv == "Rp. 0") {
            if (checkBox.checked == true) {
                $("#rupiah").val(getBOQv);
            } else {
                $("#rupiah").val('');
            }
        } else {
            if (checkBox.checked == true) {
                $("#rupiah").val(getANTBPv);
            } else {
                $("#rupiah").val('');
            }
        }

    }

    function formatNum(rawNum, prefix) {
        rawNum = "" + rawNum; // converts the given number back to a string
        var retNum = "";
        var j = 0;
        for (var i = rawNum.length; i > 0; i--) {
            j++;
            if (((j % 3) == 1) && (j != 1))
                retNum = rawNum.substr(i - 1, 1) + "." + retNum;
            else
                retNum = rawNum.substr(i - 1, 1) + retNum;
        }
        return prefix == undefined ? retNum : (retNum ? 'Rp. ' + retNum : '');
    }
</script>

<script>
    function payCost(e) {
        var project_cost_id = $(e).data("id");
        var projectid = $(e).data("projectid");
        var supplier = $(e).data("supplier");
        var boq = $(e).data("boq");
        var paidcheck = $(e).data("paidcheck");
        var paid = $(e).data("paid");
        var antbp = $(e).data("antbp");
        var urlname = "checkppn";
        $("#project_cost_id").val(project_cost_id);
        $("#project_id").val(projectid);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/taxprojectcost/" + project_cost_id,
            type: 'Get',
            async: false,
            data: {
                "id": project_cost_id,
                "urlname": urlname,
            },
            success: function(data) {
                $("#dynamicTax tr td").remove();
                $("#add-btnTax").css("display", "block");
                $("#dpp-form").css("display", "none");
                $("#taxdisplay").css("display", "none");
                $("#payed").css("display", "none");
                document.getElementById("myFormIdCreate").reset();
                $("#BOQ").css({
                    "color": "red",
                    "font-size": "150%"
                });

                if (data.ppnavailable == 'yes') {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            cancelButton: 'btn btn-secondary mr-3',
                            denyButton: 'btn btn-danger mr-3',
                            confirmButton: 'btn btn-success',
                        },
                        buttonsStyling: false,
                        allowOutsideClick: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Include PPN?',
                        text: "PPN ?",
                        icon: 'question',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        denyButtonText: `No`,
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                customClass: {
                                    input: 'text-center col-md-6 input-sweetalert-costume',
                                },
                                title: 'PPN Percentage',
                                input: 'number',
                                inputAttributes: {
                                    autocapitalize: 'off',
                                    step: '0.01',
                                    required: 'required'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Submit',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (result.value) {
                                        // console.log("Result: " + result.value);
                                        var urlname = 'setppn10';
                                        var percentage = result.value;
                                        // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                                        $.ajax({
                                            url: "/taxprojectcost/" + project_cost_id,
                                            async: false,
                                            type: 'Get',
                                            data: {
                                                "id": project_cost_id,
                                                "project_id": projectid,
                                                "urlname": urlname,
                                                "percentage": percentage,
                                            },
                                            success: function(data) {
                                                console.log(data.success);
                                                if (data.success == 'ok') {
                                                    let timerInterval
                                                    Swal.fire({
                                                        icon: data.icon,
                                                        title: data.alerttitle,
                                                        html: 'Generate PPN <b></b> milliseconds.',
                                                        allowOutsideClick: false,
                                                        timer: 1500,
                                                        timerProgressBar: true,
                                                        didOpen: () => {
                                                            Swal.showLoading()
                                                            const b = Swal.getHtmlContainer().querySelector('b')
                                                            timerInterval = setInterval(() => {
                                                                b.textContent = Swal.getTimerLeft()
                                                            }, 100)
                                                        },
                                                        willClose: () => {
                                                            clearInterval(timerInterval)
                                                        }
                                                    }).then((result) => {
                                                        swalWithBootstrapButtons.fire({
                                                            title: 'Success Generate PPN',
                                                            icon: 'success',
                                                            confirmButtonText: 'Ok',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                var urlname = 'projectcostwithtax';
                                                                $.ajax({
                                                                    url: "/taxprojectcost/" + project_cost_id,
                                                                    type: 'Get',
                                                                    async: false,
                                                                    data: {
                                                                        "id": project_cost_id,
                                                                        "urlname": urlname,
                                                                    },
                                                                    success: function(data) {
                                                                        if (data.taxuse == "empty") {
                                                                            $("#BOQ").css({
                                                                                "color": "red",
                                                                                "font-size": "150%"
                                                                            });
                                                                            $("#dynamicTax tr td").remove();
                                                                            $("#pay-cost").modal("show", true);
                                                                            $("#dpp-form").css("display", "none");
                                                                            $("#taxdisplay").css("display", "none");
                                                                            if (paidcheck != 0) {
                                                                                $("#payed").css("display", "block");
                                                                                $("#paid").val(paid);
                                                                                $("#amountNeedToBePaid").val(antbp);
                                                                            }
                                                                            $("#supplier").val(supplier);
                                                                            $("#BOQ").val(boq);
                                                                        } else if (data.taxuse == "filled") {
                                                                            $("#dynamicTax tr td").remove();
                                                                            $("#pay-cost").modal("show", true);
                                                                            $("#dpp-form").css("display", "block");
                                                                            $("#taxdisplay").css("display", "block");
                                                                            $("#supplier").val(supplier);
                                                                            $("#BOQ").val(boq);
                                                                            $("#dpp").val(data.dpp);
                                                                            $("#dynamicTax").append(data.tr);
                                                                            if (paidcheck != 0) {
                                                                                $("#payed").css("display", "block");
                                                                                $("#paid").val(paid);
                                                                                $("#amountNeedToBePaid").val(antbp);
                                                                            }

                                                                        }
                                                                        // console.log(data.tr);

                                                                    },
                                                                    error: function(xhr, data, error) {}
                                                                });
                                                            }
                                                        })

                                                        if (result.dismiss === Swal.DismissReason.timer) {
                                                            // console.log('I was closed by the timer')
                                                        }
                                                    });
                                                }
                                            },
                                            error: function(xhr, data, error) {}
                                        });
                                    }
                                }
                            });


                        } else if (result.isDenied) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "No Tax",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#dynamicTax tr td").remove();
                                    $("#pay-cost").modal("show", true);
                                    $("#supplier").val(supplier);
                                    $("#BOQ").val(boq);
                                }
                            })
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // $('#'+this.id).prop('checked', false);
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Thanks :)',
                                'error'
                            );
                        }
                    })
                } else if (data.ppnavailable == 'no') {
                    var urlname = 'projectcostwithtax';
                    $.ajax({
                        url: "/taxprojectcost/" + project_cost_id,
                        type: 'Get',
                        async: false,
                        data: {
                            "id": project_cost_id,
                            "urlname": urlname,
                        },
                        success: function(data) {
                            $("#BOQ").css({
                                "color": "red",
                                "font-size": "150%"
                            });
                            if (data.taxuse == "empty") {
                                $("#dynamicTax tr td").remove();
                                $("#pay-cost").modal("show", true);
                                $("#dpp-form").css("display", "none");
                                $("#taxdisplay").css("display", "none");
                                if (paidcheck != 0) {
                                    $("#payed").css("display", "block");
                                    $("#paid").val(paid);
                                    $("#BOQ").css({
                                        "color": "#495057",
                                        "font-size": "unset"
                                    });
                                    $("#amountNeedToBePaid").css({
                                        "color": "red",
                                        "font-size": "150%"
                                    });
                                    $("#amountNeedToBePaid").val(antbp);
                                }
                                $("#supplier").val(supplier);
                                $("#BOQ").val(boq);
                            } else if (data.taxuse == "filled") {
                                $("#dynamicTax tr td").remove();
                                $("#pay-cost").modal("show", true);
                                $("#dpp-form").css("display", "block");
                                $("#taxdisplay").css("display", "block");
                                $("#supplier").val(supplier);
                                $("#BOQ").val(boq);
                                $("#dpp").val(data.dpp);
                                $("#dynamicTax").append(data.tr);
                                if (paidcheck != 0) {
                                    $("#payed").css("display", "block");
                                    $("#paid").val(paid);
                                    if (data.taxPPH23 != null) {
                                        var taxPPH23 = data.taxPPH23;
                                        var antbpwithpph23 = antbp.replace(/([a-z ._\-]+)/gi, '');
                                        $("#BOQ").css({
                                            "color": "#495057",
                                            "font-size": "unset"
                                        });
                                        $("#amountNeedToBePaid").css({
                                            "color": "red",
                                            "font-size": "150%"
                                        });
                                        $("#amountNeedToBePaid").val(formatNum(antbpwithpph23 - taxPPH23, 'Rp. '));
                                        $("#add-btnTax").css("display", "none");
                                    } else {
                                        $("#amountNeedToBePaid").val(antbp);
                                    }
                                }
                                if (data.taxPPH23 != null) {
                                    var taxPPH23 = data.taxPPH23;
                                    var antbpwithpph23 = antbp.replace(/([a-z ._\-]+)/gi, '');
                                    $("#BOQ").css({
                                        "color": "#495057",
                                        "font-size": "unset"
                                    });
                                    $("#amountNeedToBePaid").css({
                                        "color": "red",
                                        "font-size": "150%"
                                    });
                                    $("#amountNeedToBePaid").val(formatNum(antbpwithpph23 - taxPPH23, 'Rp. '));
                                    $("#add-btnTax").css("display", "none");
                                }

                            }
                            // console.log(data.tr);

                        },
                        error: function(xhr, data, error) {}
                    });

                }
            },
            error: function(xhr, data, error) {}
        });
    }
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
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
<script>
    $('#exampleInputFile').on('change', function() {
        var fileName = $(this).val();
        fileName = fileName.replace("C:\\fakepath\\", "");
        if (fileName != undefined || fileName != "") {
            $(this).next(".custom-file-label").attr('data-content', fileName);
            $(this).next(".custom-file-label").text(fileName);
        }
    })
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
@if (session('errorPayment'))
<script>
    toastr.error("{{session('errorPayment')}}");
    $("#pay-cost").modal("show", true);
    $("#add-btnTax").css("display", "none");
</script>
@endif

@if (session('successPayment'))
<script>
    toastr.success("{{session('successPayment')}}");
</script>
@endif
<script>
    function addalltotal() {
        var checkBox = document.getElementById("checkboxPrimary1");
        var getBOQ = $("#BOQ").val();
        var getANTBP = $("#amountNeedToBePaid").val();
        if (getANTBP == "Rp. 0") {
            if (checkBox.checked == true) {
                $("#rupiah").val(getBOQ);
            } else {
                $("#rupiah").val('');
            }
        } else {
            if (checkBox.checked == true) {
                $("#rupiah").val(getANTBP);
            } else {
                $("#rupiah").val('');
            }
        }
    }
</script>
@stop

@extends('layouts.default')

@section('title', 'Contract - Po')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

    .choices__inner {
        border-radius: 0.35rem;
    }
</style>
@stop

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Project</h1>

    <!-- Basic Card Example -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create Project</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.store') }}" class="col-md-12">
                        @csrf
                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="contract_id">Contract Refference</label>
                                <select name="contract_id" class="form-control @error('contract_id') is-invalid @enderror" id="contra" class="form-control @error('contract_id') is-invalid @enderror" onchange="myFunction()">
                                    <option value="">No Contract</option>
                                    @foreach($contracts as $contract)
                                    <option id="op" value="{{$contract->id}}" data-name="{{$contract->name}}" data-id="{{$contract->id}}" data-cont_num="{{$contract->cont_num}}" data-client_id="{{$contract->client_id}}" data-volume="{{$contract->volume}}" data-unit="{{$contract->unit}}" data-price="{{$contract->price}}" data-sign_date="{{$contract->sign_date}}" data-start_date="{{$contract->start_date}}" data-end_date="{{$contract->end_date}}" data-type_id="{{$contract->type_id}}" data-type_display="{{$contract->type->display}}" data-blanket="{{$contract->blanket}}" @if (old('contract_id')==$contract->id)
                                        selected="selected" @endif >
                                        {{$contract->cont_num}} - {{$contract->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12" style="border:3px dashed black;">
                                <div class="mt-3 d-flex justify-content-center">
                                    <div id="nocontract" class="alert alert-danger" style="display:block">
                                        <strong>Info!</strong> Not Found!
                                    </div>

                                    <div id="Iscontract" class="alert alert-success" style="display:none">
                                        <div class="form">
                                            <div class="d-flex justify-content-around">
                                                <div class="form-group col-4">
                                                    <label for="name_contract">Contract Name</label>
                                                    <input type="text" class="form-control" id="name_contract" name_contract="name_contract" value="" disabled="disabled">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Client</label>
                                                    <select id=client_id name="client_id" class="form-control" disabled="disabled">
                                                        <option>--option--</option>
                                                        @foreach($clients as $client)
                                                        <option value="{{$client->id}}" {{old('client_id', $contract->client_id) == $client->id ? 'selected': null}}>
                                                            {{$client->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-around">
                                                <div class="form-group col-4">
                                                    <label for="cont_num">No. Contract</label>
                                                    <input type="text" class="form-control" id="cont_num" name="cont_num" value="" disabled="disabled">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Contract Sign Date</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="sign_date" id="sign_date" value="no data" disabled="disabled" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-around">
                                                <div class="form-group col-4">
                                                    <label>Start Date</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="start_date" value="" id="start_date" disabled="disabled" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>End Date</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="end_date" value="" id="end_date" disabled="disabled" />
                                                        <div class=" input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-around">
                                                <div class="form-group col-6">
                                                    <label>Type</label>
                                                    <select id="type_id" name="type_id" class="form-control @error('type_id') is-invalid @enderror" disabled="disabled">
                                                        <option value="">--option--</option>
                                                        @foreach($types as $type)
                                                        <option id="op" value="{{$type->id}}" data-name="{{$type->name}}" data-display="{{$type->display}}" {{old('type_id', $contract->type_id) == $type->id ? 'selected': null}}>{{$type->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('type_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="IsVolumeUnit" style="display:{{$typecek->type->display}}">
                            <div class="mt-4 d-flex justify-content-center">
                                <h6 class="font-weight-bold">Blanket</h6>
                            </div>
                            @if (session('blanketUse'))
                            <div class="alert alert-danger  d-flex justify-content-center">
                                {{ session('blanketUse') }}
                            </div>
                            @endif

                            <div id="quantity-input" class="justify-content-center col-6 mt-3 ml-3" style="display: none">
                                <div class="row col-8" style="padding-left: 16%;">
                                    <label>Global Quantity</label>
                                    <input readonly id="quantity" type="number" class="form-control" name="quantity" value="" />
                                </div>
                            </div>
                            <div id="total-value-input" class="justify-content-center col-6 mt-3" style="display: none">
                                <div class="row col-8" style="padding-left: 16%;">
                                    <label>Global Total Value</label>
                                    <input readonly id="total_value" type="text" class="form-control" name="value" value="" />
                                </div>
                            </div>
                            <table class="table table-borderless d-flex justify-content-center mt-3" id="dynamicBlanket">
                                <tr>
                                    <th id="descH" class="text-center">Desc</th>
                                    <th id="satuanH" class="text-center">Satuan</th>
                                    <th id="volumeH" class="text-center">Volume</th>
                                    <th id="priceH" class="text-center">Price@</th>
                                    <th>Volume use</th>
                                </tr>
                                {{-- @foreach(old('desc', []) as $dataBlanket) --}}
                                {{-- <tr>
                                            <td>
                                                <input type="text" class="form-control" name="desc" value="Mandays" disabled="disabled" />
                                            </td>
                                            <td width="100">
                                                <input type="number" class="form-control text-center" name="volume" value="20" disabled="disabled" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control text-right" name="price@" value="RP. 1.000.000" disabled="disabled" />
                                            </td>
                                            <td><input type="number" name="volume_use[]" value="{{old('volume_use')}}"
                                placeholder="Enter volume use " class="form-control" />
                                </td>
                                </tr> --}}
                                {{-- @endforeach --}}
                            </table>
                        </div>

                        <div class="d-flex justify-content-around mt-5">
                            <div class="form-group col-4">
                                <label for="name">Project Name</label><label style="color:#dc3545;">*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name')}}" name="name" placeholder="Enter project name">
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for=no_po>No. PO</label>
                                <input type="number" class="form-control @error('no_po') is-invalid @enderror" name="no_po" id="no_po" value="{{old('no_po')}}" placeholder="Enter no. po">
                                @error('no_po')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="po_sign_date">Project Sign Date</label>
                                <div class="md-form md-outline input-with-post-icon datepicker" id="po_sign_date" data-target-input="nearest">
                                    <input type="date" class="form-control @error('po_sign_date') is-invalid @enderror datetimepicker-input" data-target="#po_sign_date" name="po_sign_date" placeholder="dd/mm/yyyy" value="{{old('po_sign_date')}}" />
                                    @error('po_sign_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="po_start_date">Start Date</label>
                                <div class="md-form md-outline input-with-post-icon datepicker" id="po_start_date" data-target-input="nearest">
                                    <input type="date" class="form-control @error('po_start_date') is-invalid @enderror datetimepicker-input" data-target="#po_start_date" name="po_start_date" value="{{old('po_start_date')}}" placeholder="dd/mm/yyyy" />
                                    @error('po_start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="po_end_date">End Date</label>
                                <div class="md-form md-outline input-with-post-icon datepicker" id="po_end_date" data-target-input="nearest">
                                    <input type="date" name="po_end_date" class="form-control @error('po_end_date') is-invalid @enderror datetimepicker-input" data-target="#po_end_date" value="{{old('po_end_date')}}" placeholder="dd/mm/yyyy" />
                                    @error('po_end_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="total_price">Total Price</label>
                                <input type="text" name="total_price" class="form-control" onkeyup="formatrupiah_titik()" value="{{old('total_price')}}" id="total_price" placeholder="Rp." onchange="math()">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <!-- Bootstrap Switch -->
                            <div class="col-sm-4">
                                <!-- checkbox -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        Tax
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($taxs as $key => $item)
                                            @if ($item->name == 'PPN')
                                            <div class="icheck-primary d-inline col-12">
                                                <input type="checkbox" name="tax[]" id="checkboxPrimary{{$key}}" value="{{$item->id}}" checked>
                                                <label for="checkboxPrimary{{$key}}">
                                                    {{$item->name}}
                                                </label>
                                            </div>
                                            @else
                                            <div class="icheck-primary d-inline col-12">
                                                <input type="checkbox" name="tax[]" id="checkboxPrimary{{$key}}" value="{{$item->id}}">
                                                <label for="checkboxPrimary{{$key}}">
                                                    {{$item->name}}
                                                </label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <div class="card card-primary">
                                    @if (session('statusProgress'))
                                    <div class="alert alert-danger  d-flex justify-content-center">
                                        {{ session('statusProgress') }}
                                    </div>
                                    @endif
                                    <div class="card-header text-center">
                                        PROGRESS
                                    </div>
                                    <div class="card-body">
                                        <input id="setType" name="set_type_id" type="hidden">
                                        <table class=" table table-borderless d-flex justify-content-center" id="dynamicProgress">
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">% Invoice</th>
                                                <th><a type="button" name="add" id="add-btn" class="btn btn-success">+</a></th>
                                            </tr>
                                            @foreach(old('name_progress', []) as $dataProgress)
                                            <tr>
                                                <td><input type="text" name="name_progress[]" value="{{old('name_progress')[$loop->index]}}" placeholder="Enter name" class="form-control" />
                                                </td>
                                                <td><input type="number" name="payment_percentage[]" value="{{old('payment_percentage')[$loop->index]}}" placeholder="Enter % invoice" class="form-control" />
                                                </td>
                                                <td><a type="button" class="btn btn-danger remove-tr">-</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(!old('name_progress'))
                                            <tr>
                                                <td>
                                                    <input required type="text" name="name_progress[]" placeholder="Enter name" value="" class="form-control" />
                                                </td>
                                                <td><input required type="number" name="payment_percentage[]" value="" placeholder="Enter % invoice" class="form-control" />
                                                </td>
                                                <td><a type="button" class="btn btn-danger remove-tr">-</a></td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('contractProjects.index') }}" class="btn btn-danger">Back</a>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button id="myButtonID" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('custom_script')
<!-- Page level custom scripts -->
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="{{ url('/pages/js/helper.js') }}"></script>
<script src="{{ url('/pages/js/contract.create.js') }}"></script>

<script>
    $('#myFormId').submit(function() {
        $("#myButtonID", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>

<script type="text/javascript">
    $("#add-btn").click(function() {
        var tr = '<tr>' +
            '<td>' +
            '<input required type="text" name="name_progress[]" value="{{old(' + name_progress +
            ')}}" placeholder="Enter name" class="form-control" /> </td>' +
            '<td><input required type = "number" name = "payment_percentage[]"  value="{{old(' + payment_percentage +
            ')}}" placeholder = "Enter % invoice" class = "form-control" />' +
            '</td>' +
            '<td><a type="button" class="btn btn-danger remove-tr">-</a></td>' +
            '</tr>';
        $("#dynamicProgress").append(tr);
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>

<script>
    function myFunction() {
        $("#dynamicBlanket tr td").remove();
        // const vcount = [];
        // $("#dynamicBlanket tbody tr").remove();
        var x = document.getElementById("contra").value;
        var op = document.getElementById("contra");
        var name = op.options[op.selectedIndex].getAttribute('data-name');
        var cont_num = op.options[op.selectedIndex].getAttribute('data-cont_num');
        var client_id = op.options[op.selectedIndex].getAttribute('data-client_id');
        // var volume = op.options[op.selectedIndex].getAttribute('data-volume');
        // var unit = op.options[op.selectedIndex].getAttribute('data-unit');
        // var priceget = op.options[op.selectedIndex].getAttribute('data-price');

        var contract_id = op.options[op.selectedIndex].getAttribute('data-id');

        var sign_date = op.options[op.selectedIndex].getAttribute('data-sign_date');
        var start_date = op.options[op.selectedIndex].getAttribute('data-start_date');
        var end_date = op.options[op.selectedIndex].getAttribute('data-end_date');
        var type_id = op.options[op.selectedIndex].getAttribute('data-type_id');
        var type_display = op.options[op.selectedIndex].getAttribute('data-type_display');
        console.log(op.options[op.selectedIndex].getAttribute('data-type_display'))
        if (x != 0) {
            document.getElementById("nocontract").style.display = "none";
            document.getElementById("Iscontract").style.display = "block";
            document.getElementById("name_contract").value = name;
            document.getElementById('client_id').value = client_id;
            document.getElementById("cont_num").value = cont_num;
            document.getElementById("sign_date").value = sign_date;
            // document.getElementById("volume").value = volume;
            // document.getElementById("unit").value = unit;
            // document.getElementById("price_contract").value = price;
            document.getElementById("start_date").value = start_date;
            document.getElementById("end_date").value = end_date;
            document.getElementById('type_id').value = type_id;
            document.getElementById("IsVolumeUnit").style.display = type_display;
            var blanket = op.options[op.selectedIndex].getAttribute('data-blanket');
            // var blanketparse = JSON.parse("[" + blanket + "]");
            var blanketparse = JSON.parse(blanket);
            // console.log(blanketparse);
            if (blanketparse.length != 0) {
                // alert('uyy');
                console.log(type_id);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: "/blanket/" + contract_id,
                    type: 'get',
                    data: {
                        "id": contract_id,
                        "type_id": type_id,
                        "_token": token,
                    },
                    success: function(data) {
                        $("#setType").val(type_id);
                        $("#dynamicBlanket tr td").remove();
                        $("#dynamicBlanket").append(data.blanket);
                        // console.log(data.global.name);
                        if (data.global.name == "global quantity") {
                            $("#total-value-input").hide();
                            $("#volumeH").hide();
                            $("#quantity-input").show();
                            $("#quantity").val(data.global.value);
                        } else if (data.global.name == "global total value") {
                            $("#quantity-input").hide();
                            $("#volumeH").hide();
                            $("#total-value-input").show();
                            $("#total_value").val(data.global.value);
                        } else {
                            $("#quantity-input").hide();
                            $("#total-value-input").hide();
                            $("#volumeH").show();
                        }
                        // $("#total-value-input").append(data.global);
                        // console.log(data.blanket);
                    }
                });
            }

            if (type_display == "block") {
                // document.getElementById("hiddvolume").style.visibility = "visible";
            } else {
                // document.getElementById("hiddvolume").style.visibility = "hidden";
            }
        } else {
            document.getElementById("nocontract").style.display = "block";
            document.getElementById("Iscontract").style.display = "none";
            // document.getElementById("volume_use").value = "";
            // document.getElementById("hiddvolume").style.visibility = "hidden";
        }
        // console.log(vcount);
    }

    myFunction();
</script>

<script>
    function math(x, blength) {
        for (let index = 0; index < blength; index++) {
            if (index === x) {
                var volumeuse = document.getElementById('volume_use' + x).value;
                var price = document.getElementById('price' + x).value;
                var fixed = price.replace(/([a-z ._\-]+)/gi, '');
                var p = parseInt(volumeuse);
                var v = parseInt(fixed);
                if (p && v) {
                    var totaluse = p * v;
                    document.getElementById('setvalue' + x).value = totaluse;
                }
                if (volumeuse == '') {
                    document.getElementById('setvalue' + x).value = 0;
                }
            } else {}
        }
        return matchtotal(blength);
    }

    function matchtotal(blength) {
        var arraytotalcount = [];
        var arrayvaluesum = [];
        for (let index = 0; index < 100; index++) {
            if (document.getElementById('setvalue' + index) != null) {
                var total = document.getElementById('setvalue' + index).value;
                arraytotalcount.push(parseInt(total));
                var valueSum = document.getElementById('volume_use' + index).value;
                arrayvaluesum.push(parseInt(valueSum));
            }
        }
        for (i = 0; i < arraytotalcount.length; i++) {
            // check if array value is false or NaN
            if (arraytotalcount[i] === false || Number.isNaN(arraytotalcount[i])) {
                // return 0;
                // break;
            } else {
                // console.log();
                function rubah(angka) {
                    var reverse = angka.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    ribuan = ribuan.join('.').split('').reverse().join('');
                    return ribuan;
                }
                var UseBlanketSum = arrayvaluesum.reduce((a, b) => a + b, 0);
                var totalsemuanya = rubah(arraytotalcount.reduce((a, b) => a + b, 0));
                document.getElementById("total_price").value = 'Rp. ' + totalsemuanya;
            }

        }
        // validation Global Total Value
        var checkType = $("#type_id").val();
        // console.log(checkType);
        if (checkType == 1) {
            for (let index = 0; index < blength; index++) {
                var volume_useV = document.getElementById('volume_use' + index).value;
                var volumeV = document.getElementById('volume' + index).value;
                // console.log(volume_useV,volumeV);
                if (parseInt(volume_useV) > parseInt(volumeV)) {
                    var getIdVolumeUse = document.getElementById('volume_use' + index);
                    getIdVolumeUse.setCustomValidity('Use Volume tidak boleh lebih dari Volume');
                    toastr.remove();
                    toastr.options = {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: false
                    };
                    toastr.error('Use Volume tidak boleh lebih dari Volume.');
                } else {
                    var getIdVolumeUse = document.getElementById('volume_use' + index);
                    getIdVolumeUse.setCustomValidity('');
                    toastr.remove();
                    toastr.options = {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: true
                    };
                    toastr.success("Jumlah volume sesuai.");
                }

            }

        } else if (checkType == 2) {
            var g_qty = $("#quantity").val();
            // console.log(g_qty);
            if (UseBlanketSum > g_qty) {
                var validation = document.getElementById('volume_use0');
                validation.setCustomValidity('Jumlah keseluruhan Volume Use tidak boleh lebih dari Global Quantity');
                toastr.remove();
                toastr.options = {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: false
                };
                toastr.error('Jumlah keseluruhan Volume Use tidak boleh lebih dari Global Quantity.');
            } else if (Number.isNaN(UseBlanketSum)) {
                toastr.remove();
                toastr.options = {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: false
                };
                toastr.warning('Silakan mengisi semua volume use, jika tidak ingin inputkan 0.');
            } else {
                var validation = document.getElementById('volume_use0');
                validation.setCustomValidity('');
                toastr.remove();
                toastr.options = {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: true
                };
                toastr.success("Jumlah keseluruhan volume sesuai. Volume Use = " + UseBlanketSum);
            }
            // console.log(UseBlanketSum);

        } else if (checkType == 3) {
            var g_volume = $("#total_value").val();
            var fixed = g_volume.replace(/([a-z ._\-]+)/gi, '');
            var fixed2 = totalsemuanya.replace(/([a-z ._\-]+)/gi, '');
            var validationGlobalvalue = fixed - fixed2;
            if (validationGlobalvalue < 0) {
                var validation = document.getElementById('total_price');
                validation.setCustomValidity('Total Price tidak boleh lebih dari Global Total Value');
                toastr.remove();
                toastr.options = {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: false
                };
                toastr.error('Total Price tidak boleh lebih dari Global Total Value.');
            } else {
                var validation = document.getElementById('total_price');
                validation.setCustomValidity('');
                toastr.remove();
                toastr.options = {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: true
                };
                toastr.success('Total Price Sesuai.');
            }

        }
    }
</script>
@stop

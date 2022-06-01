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
    <h1 class="h3 mb-2 text-gray-800">Detail Project</h1>

    <!-- Basic Card Example -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Project</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="contract_id">Contract Refference</label>
                                <select id="contra" name="contract_id" disabled="disabled" class="form-control @error('contract_id') is-invalid @enderror" onchange="myFunction()">
                                    <option value="">No Contract</option>
                                    @foreach($contracts as $contract)
                                    <option value="{{$contract->id}}" data-name="{{$contract->name}}" data-id="{{$contract->id}}" data-cont_num="{{$contract->cont_num}}" data-client_id="{{$contract->client_id}}" data-volume="{{$contract->volume}}" data-unit="{{$contract->unit}}" data-price="{{$contract->price}}" data-sign_date="{{$contract->sign_date}}" data-start_date="{{$contract->start_date}}" data-end_date="{{$contract->end_date}}" data-type_id="{{$contract->type_id}}" data-type_display="{{$contract->type->display}}" data-blanket="{{$contract->blanket}}" {{old('contract_id', $project->contract_id) == $contract->id ? 'selected': null}}>
                                        {{$contract->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('contract_id')
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
                                                        <input type="text" class="form-control datetimepicker-input" name="sign_date" id="sign_date" value="no data" disabled="disabled" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="d-flex justify-content-center">
                                            <div class="form-group col-4" @if($projContract[0]->contract->type_id == 2)style="
                                    visibility:hidden; @endif>
                                                <label for="volume">Volume</label>
                                                <input type="text" class="form-control" id="volume" name="volume"
                                                    value="no data" disabled="disabled">

                                            </div>
                                            <div class="form-group col-2" @if($projContract[0]->contract->type_id == 2)style="
                                    visibility:hidden; @endif>
                                                <label for="unit">Unit</label>
                                                <input type="text" class="form-control" id="unit" name="unit"
                                                    value="no data" disabled="disabled">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="price_contract">Price</label>
                                                <input type="text" class="form-control" id="price_contract"
                                                    name="price_contract" value="" disabled="disabled">
                                            </div>
                                        </div> --}}
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
                                    <th class="text-center">Desc</th>
                                    <th class="text-center">Satuan</th>
                                    <th id="volumeH" class="text-center">Volume</th>
                                    <th class="text-center">Price@</th>
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
                                <label for="name">Project Name</label>
                                <input type="hidden" id="projectID" value="{{$project->id}}">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name', $project->name)}}" disabled="disabled" name="name" placeholder="Enter project name">
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for=no_po>No. PO</label>
                                <input type="number" class="form-control" name="no_po" id="no_po" value="{{old('no_po', $project->no_po)}}" disabled="disabled" placeholder="Enter no. po">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>Project Sign Date</label>
                                <div class="input-group date" id="po_sign_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#po_sign_date" name="po_sign_date" placeholder="dd/mm/yyyy" value="{{old('po_sign_date', $project->po_sign_date)}}" disabled="disabled" />
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>Start Date</label>
                                <div class="input-group date" id="po_start_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#po_start_date" name="po_start_date" value="{{old('po_start_date', $project->po_start_date)}}" placeholder="dd/mm/yyyy" disabled="disabled" />
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>End Date</label>
                                <div class="input-group date" id="po_end_date" data-target-input="nearest">
                                    <input type="text" name="po_end_date" class="form-control datetimepicker-input" data-target="#po_end_date" value="{{old('po_end_date', $project->po_end_date)}}" disabled="disabled" placeholder="dd/mm/yyyy" />
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="total_price">Total Price</label>
                                <input type="text" name="total_price" value="Rp {{old('total_price', number_format($project->total_price,0,',','.'))}}" class="form-control" id="total_price" placeholder="Rp." onchange="math()" disabled="disabled">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <!-- Bootstrap Switch -->
                            <div class="col-sm-4">
                                <!-- checkbox -->
                                @if(!$tax_proof->isEmpty())
                                <div class="card card-primary">
                                    <div class="card-header">
                                        Tax
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($tax as $key => $item)
                                            @foreach ($tax_proof as $txp)
                                            @if ($item->id == $txp->tax_id)
                                            <div class="icheck-secondary d-inline col-12">
                                                <input type="checkbox" name="tax[]" id="checkboxPrimary{{$key}}" value="{{$item->id}}" checked disabled>
                                                <label for="checkboxPrimary{{$key}}">
                                                    {{$item->name}}
                                                </label>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                    @if (session('status'))
                                    <div class="alert alert-danger  d-flex justify-content-center">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <table class=" table table-borderless d-flex justify-content-center" id="dynamicProgress">
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">% Invoice</th>
                                            </tr>
                                            @foreach($progress_item as $progress)
                                            <tr>
                                                <td>
                                                    <input type="text" name="name_progress[]" value="{{old('name_progress[]', $progress->name_progress)}}" placeholder="Enter name" class="form-control" disabled="disabled" />
                                                </td>
                                                <td><input type="text" name="payment_percentage[]" value="{{old('payment_percentage[]', $progress->payment_percentage)}}" placeholder="
                                        Enter % invoice" class="form-control" disabled="disabled" />
                                                </td>

                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('contractProjects.index') }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
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
    function myFunction() {
        var x = document.getElementById("contra").value;
        var op = document.getElementById("contra");
        var name = op.options[op.selectedIndex].getAttribute('data-name');
        var cont_num = op.options[op.selectedIndex].getAttribute('data-cont_num');
        var client_id = op.options[op.selectedIndex].getAttribute('data-client_id');
        var volume = op.options[op.selectedIndex].getAttribute('data-volume');
        var unit = op.options[op.selectedIndex].getAttribute('data-unit');
        var price = op.options[op.selectedIndex].getAttribute('data-price');
        var sign_date = op.options[op.selectedIndex].getAttribute('data-sign_date');
        var start_date = op.options[op.selectedIndex].getAttribute('data-start_date');
        var end_date = op.options[op.selectedIndex].getAttribute('data-end_date');
        var contract_id = op.options[op.selectedIndex].getAttribute('data-id');
        var type_id = op.options[op.selectedIndex].getAttribute('data-type_id');
        var type_display = op.options[op.selectedIndex].getAttribute('data-type_display');
        console.log(type_display);
        // console.log(op.options[op.selectedIndex].getAttribute('data-name'))
        if (x) {
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
            var project_id = document.getElementById("projectID").value;
            var blanket = op.options[op.selectedIndex].getAttribute('data-blanket');
            // console.log(blanket);
            // var blanketparse = JSON.parse("[" + blanket + "]");
            var blanketparse = JSON.parse(blanket);
            // console.log(blanketparse);
            if (blanketparse.length != 0) {
                // alert('uyy');
                // console.log(contract_id);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: "/useblanket/" + project_id,
                    type: 'get',
                    data: {
                        "id": project_id,
                        "url": "show",
                        "contract_id": contract_id,
                        "_token": token,
                    },
                    success: function(data) {
                        $("#dynamicBlanket tr td").remove();
                        $("#dynamicBlanket").append(data.blanket);
                        if (data.typename == "global quantity") {
                            $("#total-value-input").hide();
                            $("#volumeH").hide();
                            $("#quantity-input").show();
                            $("#quantity").val(data.value);
                        } else if (data.typename == "global total value") {
                            $("#quantity-input").hide();
                            $("#volumeH").hide();
                            $("#total-value-input").show();
                            $("#total_value").val(data.value);
                        } else {
                            $("#quantity-input").hide();
                            $("#total-value-input").hide();
                            $("#volumeH").show();
                        }

                        // console.log(data.blanket);
                        console.log(data.typename);
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
    }
    myFunction();
</script>
@stop

@extends('layouts.default')

@section('title', 'Operational & Cost - Detail')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<style>
    .has-error .select2-selection {
        border-color: rgb(185, 74, 72) !important;
    }
</style>
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
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <form role="form" action="/operationals/{{$id}}" onsubmit="return confirm('Are you sure you want to Submit?')" method="post">
                        @method('patch')
                        @csrf
                        <div class="card-body">
                            <div class="form">
                                <div class="d-flex justify-content-center">
                                    <table class="table table-bordered" id="refresh-after-ajax">
                                        <tr>
                                            <th class="text-center">Operational & Progress</th>
                                            <th class="text-center">Progress</th>
                                            <th class="text-center">Invoicing</th>
                                        </tr>
                                        <tr>
                                            @foreach($progress_items as $progress_item)
                                            <td>
                                                <div class="d-flex justify-content-around">
                                                    <div class="form-group col-4">
                                                        <p class="font-weight-bolder">
                                                            {{$progress_item->name_progress}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group col-4">

                                                        <div class="input-group">
                                                            <a type="button" class="btn btn-primary" value="/operationals/{{$progress_item->id}}" data-toggle="modal" data-target="#exampleModal" data-id="{{$progress_item->id}}" data-whatever="{{$progress_item->name_progress}}">Upload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if(!$progress_item->status_id)
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <a data-name="status" data-id="{{$progress_item->id}}" data-on="Completed" data-off="inProgress" class="btn btn-primary changeStatus">Done</a>
                                                @else
                                                <i class="nav-icon fas fa-check text-success"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (!$progress_item->status_id)
                                                <a class="btn btn-secondary alertNotSet">in Progress</a>
                                                @else
                                                @if (!$progress_item->invoice_status_id)
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <a data-name="invoice_status" data-id="{{$progress_item->id}}" data-on="Completed" data-off="inProgress" class="btn btn-primary changeStatus">Sending</a>
                                                @else
                                                <i class="nav-icon fas fa-check text-success"></i>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="d-flex justify-content-around mb-3">
                                    <div class="card card-primary">
                                        <div class="card-header text-center">
                                            File Upload
                                        </div>
                                        <div class="card-body">
                                            <table class="table d-flex justify-content-center mb-3" id="refresh-after-ajax">
                                                <tr>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Show</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                                @foreach($progress_docs as $progress_doc)
                                                <tr>
                                                    <td>{{$progress_doc->name_progress}}</td>

                                                    @foreach($progress_doc->doc as $doc)
                                                    @if ($doc->filename != null)
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <div class="form-group col-12">
                                                                <a href="{{ asset('progress_docs') }}/{{$doc->filename}}" class="form-group col">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                    <a type="button" data-id="{{ $doc->id }}" class="removedoc"><i class="nav-icon fas fa-trash" style="color:#dc3545;"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @else

                                                    @endif
                                                    @endforeach

                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="card card-primary">
                                        @if (session('statusCost'))
                                        <div class="alert alert-danger  d-flex justify-content-center">
                                            {{ session('statusCost') }}
                                        </div>
                                        @endif
                                        <div class="card-header text-center">
                                            COSTING
                                            <div class="float-right">
                                                <a href="/payable" class="btn btn-sm btn-warning"><i class="fas fa-credit-card"></i> Pay</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if (session('statusCost'))
                                            <div class="alert alert-danger  d-flex justify-content-center">
                                                {{ session('statusCost') }}
                                            </div>
                                            @endif
                                            <table class="table table-borderless d-flex justify-content-around" id="dynamicCosting">
                                                <tr>
                                                    <th class="text-center">Supplier</th>
                                                    <th class="text-center">Desc</th>
                                                    <th class="text-center">BOQ</th>
                                                    <th class="text-center">Progress Name</th>
                                                    <th><a type="button" name="addcost" id="add-btnCost" class="btn btn-success">+</a>
                                                    </th>
                                                </tr>
                                                @if (old('suplier') == null)
                                                @forelse($project_cost as $key => $cost)
                                                <tr>
                                                    <input type="hidden" name="cost_id[]" value="{{old('cost_id[]', $cost->id)}}">
                                                    <td>
                                                        <select name="suplier[]" class="form-control select2" style="width: 100%">
                                                            <option value=""></option>
                                                            @foreach ($suppliers as $item)
                                                            <option value="{{$item->id}}" @if ($cost->suplier_id == $item->id)
                                                                selected="selected" @endif>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="desc[]" value="{{old('desc[]', $cost->desc)}}" placeholder="Enter desc" class="form-control" />
                                                    </td>
                                                    <td><input type="text" id="BOQs{{$key}}" name="BOQ[]" value="@rupiah(old('BOQ[]', $cost->budget_of_quantity))" onclick="getIDBOQ(this)" placeholder="Budget Of Quantity" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <select name="progress[]" class="form-control select2" style="width: 100%">
                                                            <option value=""></option>
                                                            @foreach ($progress_items as $item)
                                                            <option value="{{$item->id}}" @if ($cost->progress_item_id == $item->id)
                                                                selected="selected" @endif>{{$item->name_progress}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr id="empty-data" class="d-flex justify-content-center">
                                                    <td style="color: #dc3545">-- Data Empty --</td>
                                                </tr>
                                                @endforelse
                                                @else
                                                @foreach(old('suplier', []) as $key => $dataCost)
                                                <tr>
                                                    <input type="hidden" name="cost_id[]" value=" @if(!empty(old('cost_id')[$key])) {{old('cost_id')[$key]}} @endif">
                                                    <td>
                                                        <div class="form-group {{ $errors->has('suplier.'.$key) ? ' has-error' : '' }}">
                                                            <select name="suplier[]" class="form-control select2" {{ $errors->has('suplier.'.$key) ? 'autofocus' : '' }}>
                                                                <option value=""></option>
                                                                @foreach ($suppliers as $item)
                                                                <option value="{{$item->id}}" @if (old('suplier')[$key]==$item->id)
                                                                    selected="selected" @endif>{{$item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('suplier.'.$key)
                                                            <small class="text-danger">Please select supplier</small>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="desc[]" value="{{old('desc')[$key]}}" placeholder="Enter desc" class="form-control" />
                                                    </td>
                                                    <td><input id="BOQr{{$key}}" class="form-control {{ $errors->has('BOQ1.'.$key) ? ' is-invalid' : '' }}" type="text" name="BOQ[]" value="@rupiah(old('BOQ1')[$key])" onclick="getIDBOQ(this)" placeholder="Budget Of Quantity" class="form-control" {{ $errors->has('BOQ1.'.$key) ? 'autofocus' : '' }} />
                                                        @error('BOQ1.'.$key)
                                                        <small class="text-danger">Please Input Budget Of Quantity</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <div class="form-group {{ $errors->has('progress.'.$key) ? ' has-error' : '' }}">
                                                            <select name="progress[]" class="form-control select2" {{ $errors->has('progress.'.$key) ? 'autofocus' : '' }}>
                                                                <option value=""></option>
                                                                @foreach ($progress_items as $item)
                                                                <option value="{{$item->id}}" @if (old('progress')[$key]==$item->id)
                                                                    selected="selected" @endif>{{$item->name_progress}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('progress.'.$key)
                                                            <small class="text-danger">Please select Progress</small>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    @if($errors->has('suplier.'.$key) || $errors->has('BOQ1.'.$key))
                                                    <td><a type="button" class="btn btn-danger removeCost-tr">-</a>
                                                    </td>
                                                    @endif

                                                </tr>
                                                @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer mt-2">
                            <div class="text-center">
                                <a href="/operationals" type="submit" class="btn btn-danger">Back</a>
                                <button type="submit" class="btn btn-primary">Submit Cost</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('progress_doc') }}" id="upload_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="progress_id" id="progress_id">
                        <label></label>
                        <input type="file" class="form-control @error('filename') is-invalid @enderror" id="filename" name="filename[]" multiple>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="$('#upload_modal_form').submit();" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('operational-cost.create_tax_modal')
@stop

@section('custom_script')
<!-- Page level custom scripts -->
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="{{ url('/pages/js/helper.js') }}"></script>
<script src="{{asset('assets/')}}/costume/rupiah.js"></script>
<script src="{{asset('assets/')}}/plugins/select2/js/select2.full.min.js"></script>

<script>
    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var progress_id = button.data('id')
        var modal = $(this)
        modal.find('.modal-title').text('Upload ' + recipient)
        modal.find('#progress_id').val(progress_id)
    });
</script>
@if (session('errorUpload'))
<script>
    toastr.error("{{session('errorUpload')}}");
</script>
@endif
@if (session('status'))
<script>
    toastr.success('Upload success!');
</script>
@endif
@if (session('null'))
<script>
    toastr.warning('No files uploaded!');
</script>
@endif
<script>
    $("#exampleModal").on("hidden.bs.modal", function() {
        $("#filename").val("");
    });

    $('.alertNotSet').click(function() {
        // alert()->error('Title','Lorem Lorem Lorem');
        alert('Your progress not runing !!!');
    });
</script>
<script type="text/javascript">
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
    var suplier = {!!$suppliers!!};
    var progress = {!!$progress_items!!};
    // initailizeSelect2();
    var state = 0;
    $("#add-btnCost").click(function() {
        $("#empty-data").remove();
        var tr1 = $("<tr>");
        var td1 = $("<td>");
        var td3 = $("<td>");
        var select2 = $("<select>").addClass('form-control').addClass('select-to-select2').css("width", "100%").attr('name', 'suplier[]');
        var select3 = $("<select>").addClass('form-control').addClass('select-to-select2').css("width", "100%").attr('name', 'progress[]');
        var option1 = $("<option>");
        var option3 = $("<option>");
        select2.append(option1);
        $.each(suplier, function(i, item) {
            select2.append($('<option>', {
                value: item.id,
                text: item.name
            }));
        });
        select3.append(option3);
        $.each(progress, function(i, item) {
            select3.append($('<option>', {
                value: item.id,
                text: item.name_progress
            }));
        });
        var td =
            '</td>' +
            '<td><input type="text" name="desc[]" value="{{old(' + desc +
            ')}}" placeholder="Enter desc" class="form-control" />' +
            '</td>' +
            '<td><input id="BOQ' + state + '" type="text" name="BOQ[]" value="{{old(' + total_cost +
            ')}}" placeholder="Budget Of Quantity" class="form-control" onclick="getIDBOQ(this)" /></td>';
        var del = '<td><a type="button" class="btn btn-danger removeCost-tr">-</a></td>';
        td1.append(select2);
        td3.append(select3);
        tr1.append(td1);
        tr1.append(td);
        tr1.append(td3);
        tr1.append(del);
        state++;

        $("#dynamicCosting").append(tr1);
        initializeSelect2(select2);
        initializeSelect2(select3);
    });
    $(document).on('click', '.removeCost-tr', function() {
        $(this).parents('tr').remove();
    });

    function getIDBOQ(v) {
        v.addEventListener('keyup', function(e) {
            v.value = formatRupiah(this.value, 'Rp. ');
        });
    }
</script>\
<script>
    $(".changeStatus").click(function() {
        var id = $(this).data("id");
        var name = $(this).data("name");
        var dataOn = $(this).data("on");
        var dataOff = $(this).data("off");
        var token = $("meta[name='csrf-token']").attr("content");
        if (name == 'status') {
            var result = confirm("Want to change status?");
            if (result) {
                $.ajax({
                    url: "/changestatus/" + id,
                    type: 'get',
                    data: {
                        "name": name,
                        "id": id,
                        "dataOn": dataOn,
                        "_token": token,
                    },
                    success: function(data) {
                        console.log(data.success);
                        location.reload();
                    },
                    error: function(xhr, data, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(data);
                    }
                });
            }
        } else if (name == 'invoice_status') {

            $.ajax({
                url: "/taxproof/" + id,
                type: 'get',
                data: {
                    "id": id,
                    "urlname": name,
                    "_token": token,
                },
                success: function(data) {
                    $("#input-tax div").remove();
                    // console.log(data.input);
                    if (data.input.length == 0) {
                        var result1 = confirm("Want to sending invoice?");
                        if (result1) {
                            console.log('test');
                            $.ajax({
                                url: "/changestatus/" + id,
                                type: 'get',
                                data: {
                                    "name": name,
                                    "id": id,
                                    "dataOn": dataOn,
                                    "_token": token,
                                },
                                success: function(data) {
                                    location.reload();
                                },
                                error: function(xhr, data, error) {}
                            });
                        }
                    } else {
                        $('#createTaxs').modal('show');
                        $("#input-tax").append(data.input);
                    }
                }
            });
            $('#invoiceForm').submit(function(e) {
                var result2 = confirm("Want to sending invoice?");
                if (result2) {
                    $("#invoice-send", this)
                    var percentage = $("input[name='percentage[]']")
                        .map(function() {
                            return $(this).val();
                        }).get();
                    var idtaxproof = $("input[name='idtaxproof[]']")
                        .map(function() {
                            return $(this).val();
                        }).get();
                    var urlnameinvoice = $("input[name='urlname']").val();
                    var invoice_number = $("input[name='invoice_number']").val();
                    console.log(urlnameinvoice);
                    $("input[type='submit']").prop("disable", true);
                    $.ajax({
                        url: "/changestatus/" + id,
                        type: 'get',
                        async: false,
                        data: {
                            "name": name,
                            "urlname": urlnameinvoice,
                            "id": id,
                            "dataOn": dataOn,
                            "invoice_number": invoice_number,
                            "percentage": percentage,
                            "idtaxproof": idtaxproof,
                            "_token": token,
                        },
                        success: function(data) {
                            // console.log(data);
                            location.reload();
                        },
                        error: function(xhr, data, error) {
                            $("input[type='submit']").prop("disable", false);
                        }
                    });
                    e.preventDefault();
                }
            });
        }

    });
</script>
<script>
    $(".removedoc").click(function() {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var result = confirm("Want to delete?");
        if (result) {
            $.ajax({
                url: "/progress_doc/" + id,
                type: 'get',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function(data) {
                    console.log(data.success);
                    location.reload();
                }
            });
        }
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
@stop

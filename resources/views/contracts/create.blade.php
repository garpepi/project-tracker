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

@section('custom_script')
<!-- Page level custom scripts -->
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="{{ url('/pages/js/helper.js') }}"></script>
<script src="{{ url('/pages/js/contract.create.js') }}"></script>
@stop

@section('content')
<!-- Modal -->
<div class="modal fade" id="choose_category" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="choose_category">Contract Type</h5>
                <a href="{{ route('contractProjects.index') }}" class="close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-12 required">
                    <select class="form-control" id="contract_type" required>
                        <option>Select Contract Type</option>
                        <option value=1>Blanket</option>
                        <option value=2>Blanket Quantity Global</option>
                        <option value=3>Blanket Value Global</option>
                        <option value=4>Non Blanket</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Contract</h1>

    <!-- Basic Card Example -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Contract</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('contracts.store') }}" class="col-md-12">
                @csrf
                <input type="hidden" name="type" id="type_val" />
                <div class="form-row">
                    <div class="form-group col-md-6 required">
                        <label class="control-label" for="contract.name">Contract Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="contract.name" placeholder="Contract Name" name="name" value="{{old('name')}}" required>
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 required">
                        <label class="control-label" for="contract.client">Client</label>
                        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror" id="contract.client" required>
                            <option>Choose Client!</option>
                            @foreach($clients as $client)
                            <option value="{{$client->id}}" {{old('client_id') == $client->id ? 'selected': null}}>{{$client->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('client_id')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 required">
                        <label class="control-label" for="contract.number">No Contract</label>
                        <input name="cont_num" type="text" class="form-control @error('cont_num') is-invalid @enderror" placeholder="No Contract" id="contract.number" required>
                        @error('cont_num')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contract.signdate">Contract Sign-date</label>
                        <div class="md-form md-outline input-with-post-icon datepicker">
                            <input name="sign_date" placeholder="dd/mm/yyyy" type="date" id="contract.signdate" class="form-control" value="{{old('sign_date')}}">
                        </div>
                        @error('sign_date')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contract.startdate">Start Date</label>
                        <div class="md-form md-outline input-with-post-icon datepicker">
                            <input name="start_date" placeholder="dd/mm/yyyy" type="date" id="contract.startdate" class="form-control" value="{{old('start_date')}}">
                        </div>
                        @error('sign_date')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contract.enddate">End Date</label>
                        <div class="md-form md-outline input-with-post-icon datepicker">
                            <input name="end_date" placeholder="dd/mm/yyyy" type="date" id="contract.enddate" class="form-control" value="{{old('end_date')}}">
                        </div>
                    </div>
                </div>

                <br>
                <div id="blanket" style="display: none;">
                    <h6 class="m-0 font-weight-bold text-primary text-center" id="blanket_title">Blanket</h6>
                    <hr class="my-12" />
                    <div class="form-row" id="custom_blanket">
                        <div class="form-group col-md-2 offset-md-2 text-center">
                            <label class="control-label" id="custom_blanket_title">{Maximum}</label>
                            <input name="quantity" type="number" class="form-control numberWithPeriod" placeholder="Maximum" id="custom_blanket_quantity" value=0 required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2 offset-md-2 text-center">
                            <label class="control-label">Description</label>
                        </div>
                        <div class="form-group col-md-2 text-center">
                            <label class="control-label">Unit used</label>
                        </div>
                        <div class="form-group col-md-2 text-center volume_blanket">
                            <label class="control-label">Volume</label>
                        </div>
                        <div class="form-group col-md-2 text-center">
                            <label class="control-label">Price @</label>
                        </div>
                        <div class="form-group col-md-2 text-center ml-auto">
                            <a id="add_blanket-rec" href="#" class="btn-sm btn-success btn-circle">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="blanket_loop">
                        <div class="form-row blanket-rec">
                            <div class="form-group col-md-2 offset-md-2">
                                <input name="desc[]" type="text" class="form-control" placeholder="Description" value="{{old('desc')}}" required>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" placeholder="Ex: man days" name="satuan[]" value="{{old('satuan')}}" required>
                            </div>
                            <div class="form-group col-md-2 volume_blanket">
                                <input name="volume[]" type="number" class="form-control numberWithPeriod " placeholder="Volume" id="contract.name" required>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control rupiahWithdot" placeholder="Price @" id="contract.name" name="price[]" value="" required>
                            </div>
                            <div class="form-group col-md-2 text-center ml-auto">
                                <a href="#" class="btn-sm btn-danger btn-circle remove_blanket-rec">
                                    <i class="fas fa-minus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <br>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="exampleFormControlFile1">Example file input</label>
                        <input name="filename[]" type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group col-md-6 required rounded-please offset-md-3">
                        <label class="control-label" for="contract.client">Viewable By</label>
                        <select class="form-control" id="choices-multiple-remove-button" name="userview[]" multiple>
                            @foreach ($ListroleUser as $key => $item)
                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
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

@stop

@extends('layouts.default')

@section('title', 'Contract - Po')

@section('custom_css')
@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ url('/sb-admin2/js/demo/datatables-demo.js') }}"></script>
@stop

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col">
            <h1 class="h3 mb-2 text-gray-800">Master Client</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Client</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('client.store') }}" class="col-md-12">
                @csrf
                <div class="form-row d-flex justify-content-center">
                    <div class="form-group col-md-6 required">
                        <label class="control-label" for="name">Client Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" name="name" required>
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-center bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <button id="myButtonID" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@stop

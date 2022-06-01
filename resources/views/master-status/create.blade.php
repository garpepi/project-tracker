@extends('layouts.default')

@section('title', 'Create Status')

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
            <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="/progress_status">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <div class="form-group col-4">
                                    <label for="status">Status</label>
                                    <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" id="status" placeholder="Enter status">
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer mt-2 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

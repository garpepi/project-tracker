@extends('layouts.default')

@section('title', 'Contract - Po')

@section('custom_css')
    <!-- Custom styles for this page -->
    <link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('custom_script')
    <!-- Page level plugins -->
    <script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('/pages/js/contract-po.index.js') }}"></script>
@stop

@section('content')

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Contract / PO</h1>
                    <p class="mb-4">List of Contract and Purchase Order (PO) that already recorded.</p>

                    <!-- List Contract -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Contract
                                <a href="{{ route('Operationalcreate.contract') }}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Create Contract</span>
                                </a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="contract" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cont. Number</th>
                                            <th>Cont. Name</th>
                                            <th>Client</th>
                                            <th>History</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-pen"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Edit</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-success">
                                                    <i class="nav-icon fas fa-clone"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Ammend</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="nav-icon fas fa-trash"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Delete</a>
                                                    </div>
                                                </button>     
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-pen"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Edit</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-success">
                                                    <i class="nav-icon fas fa-clone"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Ammend</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="nav-icon fas fa-trash"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Delete</a>
                                                    </div>
                                                </button>   
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End List Contract -->

                    <!-- List PO -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List PO
                                <a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Create PO</span>
                                </a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="po" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cont. Number</th>
                                            <th>Cont. Name</th>
                                            <th>Client</th>
                                            <th>History</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-pen"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Edit</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-success">
                                                    <i class="nav-icon fas fa-clone"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Ammend</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="nav-icon fas fa-trash"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Delete</a>
                                                    </div>
                                                </button>   
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-pen"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Edit</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-success">
                                                    <i class="nav-icon fas fa-clone"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Ammend</a>
                                                    </div>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="nav-icon fas fa-trash"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Delete</a>
                                                    </div>
                                                </button>   
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End List PO -->

                </div>
                
@stop
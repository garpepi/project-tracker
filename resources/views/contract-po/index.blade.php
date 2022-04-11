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
                     @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Contract / PO</h1>
                    <p class="mb-4">List of Contract and Purchase Order (PO) that already recorded.</p>

                    <!-- List Contract -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Contract
                                <a href="{{ route('contracts.create') }}" class="btn btn-primary btn-icon-split">
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
                                        @foreach($contracts as $index => $contract)
                                        <tr>
                                            <th class="text-center">{{$loop->iteration}}</th>
                                            <td>{{$contract->cont_num}}</td>
                                            <td>{{$contract->name}}</td>
                                            <td>{{$contract->client->name}}</td>
                                            <td>
                                                <ul id="myUL">
                                                    <li><span class="caret">{{$contract->cont_num}}</span>
                                                    <ul class="nested">
                                                        @foreach ($contract->his()->orderBy('id', 'DESC')->get() as $cont_his)
                                                        <a href="/contracts/history_show/{{$cont_his->id}}"><li>{{$cont_his->cont_num}}</li></a>
                                                        @endforeach
                                                    </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                            <div class="btn-group">
                                                <form action="/contracts/{{$contract->id}}"
                                                    method="get"
                                                    class="d-inline">
                                                        <button class="btn btn-sm btn-warning dropdown-hover">
                                                            <i class="nav-icon fas fa-eye"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item">Show</a>
                                                            </div>
                                                        </button>
                                                </form>
                                            </div>
                                            <div class="btn-group">
                                                <form action="/contracts/{{$contract->id}}/edit"
                                                    method="get"
                                                    class="d-inline">
                                                        <button class="btn btn-sm btn-primary dropdown-hover">
                                                            <i class="nav-icon fas fa-pen"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item">Edit</a>
                                                            </div>
                                                        </button>
                                                </form>
                                            </div>
                                            <div class="btn-group">
                                                <form action="/contracts/{{$contract->id}}/ammend"
                                                    method="get"
                                                    class="d-inline">
                                                <button class="btn btn-sm btn-success dropdown-hover">
                                                    <i class="nav-icon fas fa-clone"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Ammend</a>
                                                    </div>
                                                </button>
                                                </form>
                                            </div>
                                            <div class="btn-group">
                                                <form action="/contracts/{{$contract->id}}"
                                                    onsubmit="return confirm('Are you sure you want to delete?')" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger dropdown-hover">
                                                        <i class="nav-icon fas fa-trash"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item">Delete</a>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                            </td>
                                        </tr>
                                        @endforeach
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
                                        @foreach($projects as $project)
                                        <tr>
                                            <th class="text-center">{{$loop->iteration}}</th>
                                            @if($project->contract)
                                            <td>{{$project->contract->cont_num}}</td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            <td>{{$project->name}}</td>
                                            {{-- <td>{{$project->no_po}}</td> --}}
                                            <td>
                                                <ul id="myULP">
                                                    <li><span class="caret">{{$project->no_po}}</span>
                                                    <ul class="nested">
                                                        @foreach ($project->his()->orderBy('id', 'DESC')->get() as $pro_his)
                                                        <a href="/projects/history_show/{{$pro_his->id}}"><li>{{$pro_his->no_po}}</li></a>
                                                        @endforeach
                                                    </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                <!-- show -->
                                                <div class="btn-group">
                                                    <form action="/projects/{{$project->id}}"
                                                        method="get"
                                                        class="d-inline">
                                                            <button class="btn btn-sm btn-warning dropdown-hover">
                                                                <i class="nav-icon fas fa-eye"></i>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item">Show</a>
                                                                </div>
                                                            </button>
                                                    </form>
                                                </div>
                                                <!-- edit -->
                                                <!--
                                                <div class="btn-group">
                                                    <form action="/projects/{{$project->id}}/edit"
                                                        method="get"
                                                        class="d-inline">
                                                            <button class="btn btn-sm btn-primary dropdown-hover">
                                                                <i class="nav-icon fas fa-pen"></i>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item">Edit</a>
                                                                </div>
                                                            </button>
                                                    </form>
                                                </div>
                                                -->
                                                <!-- ammend -->
                                                <div class="btn-group">
                                                    <form action="/projects/{{$project->id}}/ammend"
                                                        method="get"
                                                        class="d-inline">
                                                    <button class="btn btn-sm btn-success dropdown-hover">
                                                        <i class="nav-icon fas fa-clone"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item">Adendum</a>
                                                        </div>
                                                    </button>
                                                    </form>
                                                </div>
                                                <!-- delete -->
                                                <div class="btn-group">
                                                    <form action="/projects/{{$project->id}}"
                                                        onsubmit="return confirm('Are you sure you want to delete?')" method="post"
                                                        class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger dropdown-hover">
                                                            <i class="nav-icon fas fa-trash"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item">Delete</a>
                                                            </div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End List PO -->

                </div>
                
@stop
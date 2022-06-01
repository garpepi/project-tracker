@extends('layouts.default')

@section('title', 'Operational & Cost')

@section('custom_css')
<!-- Custom styles for this page -->
<link href="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni expedita cupiditate, aut adipisci ipsa asperiores quae modi nihil nam aliquid explicabo voluptatibus, nobis minus laborum qui esse sequi. Ut, et!</p>

    <!-- List Operational & Cost -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="opcost_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Contract Number</th>
                                    <th>Client</th>
                                    <th>Project Number</th>
                                    <th>Project Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operationals as $index => $operational)

                                <tr>
                                    <th class="text-center">{{$loop->iteration}}</th>
                                    @if($operational->contract_id)
                                    <td class="text-center">{{$operational->contract->cont_num}}</td>
                                    <td>{{$operational->contract->client->name}}</td>
                                    @else
                                    <td class="text-center"></td>
                                    <td></td>
                                    @endif
                                    <td class="text-center">{{$operational->no_po}}</td>
                                    <td>{{$operational->name}}</td>
                                    <td class="text-center">
                                        <!-- show -->
                                        <div class="btn-group">
                                            <form action="/operationals/{{$operational->id}}" method="get" class="d-inline my-0">
                                                <button class="btn btn-sm btn-warning dropdown-hover">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- Edit -->
                                        <div class="btn-group">
                                            <form action="/operationals/{{$operational->id}}/edit" method="get" class="d-inline my-0">
                                                <button class="btn btn-sm btn-primary dropdown-hover">
                                                    <i class="nav-icon fas fa-pen"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Edit</a>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Contract Number</th>
                                    <th>Client</th>
                                    <th>Project Number</th>
                                    <th>Project Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Operational & Cost -->
</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#opcost_table").DataTable({
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
@stop

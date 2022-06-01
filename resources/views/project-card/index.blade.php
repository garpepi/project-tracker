@extends('layouts.default')

@section('title', 'Project Card')

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
    <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Autem, libero veritatis. Provident perspiciatis, molestias repellat sunt nihil unde eos, deleniti esse iste fugit odit, debitis impedit atque. Reiciendis, repellendus nihil?</p>

    <!-- List Project Card -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="project_card_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Contract Number</th>
                                    <th class="text-center">PO</th>
                                    <th class="text-center">Total Account Receiveable</th>
                                    <th class="text-center">Total Cost</th>
                                    <th class="text-center">Margin</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectcard as $key => $pro)

                                <tr>
                                    <th class="text-center">{{$loop->iteration}}</th>
                                    <td class="text-center">{{$pro->contract->cont_num}}</td>
                                    <td class="text-center">{{$pro->no_po}}</td>
                                    <td class="text-center">@rupiah($pro->actualPay)</td>
                                    <td class="text-center">@rupiah($pro->totalcost)</td>
                                    @if ($pro->actualPay - $pro->totalcost > 0)
                                    <td class="text-center text-green">@rupiah($pro->actualPay - $pro->totalcost)</td>
                                    @else
                                    <td class="text-center text-red">@rupiah($pro->actualPay - $pro->totalcost)</td>
                                    @endif
                                    <td class="text-center">
                                        <!-- show -->
                                        <div class="btn-group">
                                            <form action="/projectcard/{{$pro->id}}" method="get" class="d-inline">
                                                <button class="btn btn-sm btn-warning dropdown-hover">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Show</a>
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
                                    <th class="text-center">No</th>
                                    <th class="text-center">Contract Number</th>
                                    <th class="text-center">PO</th>
                                    <th class="text-center">Total Account Receiveable</th>
                                    <th class="text-center">Total Cost</th>
                                    <th class="text-center">Margin</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Project Card -->

</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#project_card_table").DataTable({
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

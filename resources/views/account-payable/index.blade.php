@extends('layouts.default')

@section('title', 'Account Payable')

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
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi fugit earum ratione ipsam optio laborum cupiditate esse officiis nisi temporibus aperiam ea, explicabo sunt fuga facere eos quisquam magni modi.</p>

    <!-- List Account Payable -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="payable_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Project Name</th>
                                    <th class="text-center">Project Number</th>
                                    <th class="text-center">Progress Name</th>
                                    <th class="text-center">Total Bill Of Quantity</th>
                                    <th class="text-center">Total Use</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projectcost as $key => $pro)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$pro->project->name}}</td>
                                    <td class="text-center">{{$pro->project->no_po}}</td>
                                    <td class="text-center">{{$pro->progress_item->name_progress}}</td>
                                    <td class="text-center">@rupiah($pro->countBOQ)</td>
                                    <td class="text-center">{{$pro->countUse}}</td>
                                    <td class="text-center">
                                        <!-- Pay -->
                                        <div class="btn-group">
                                            <form action="/payable/{{$pro->progress_item_id}}/bill" method="get" class="d-inline">
                                                <button class="btn btn-sm btn-primary dropdown-hover">
                                                    <i class="nav-icon far fa-credit-card"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item">Bill</a>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr id="empty-data" class="d-flex justify-content-center">
                                    <td style="color: #dc3545">-- Data Empty --</td>
                                </tr>
                                @endforelse
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Project Name</th>
                                    <th class="text-center">Project Number</th>
                                    <th class="text-center">Progress Name</th>
                                    <th class="text-center">Total Bill Of Quantity</th>
                                    <th class="text-center">Total Use</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Account Payable -->
</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#payable_table").DataTable({
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

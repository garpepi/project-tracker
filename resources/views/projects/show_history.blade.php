@extends('layouts.default')

@section('title', 'Project History')

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
    <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquam dolorem corrupti deleniti, rem laboriosam, maxime reprehenderit eaque dicta, alias reiciendis consequuntur? Non molestiae necessitatibus in, vitae suscipit perspiciatis animi accusamus!</p>

    <!-- List Project History -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-sm-12 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List @yield('title')
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="project_history_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Change Date</th>
                                    <th>Cont. Number</th>
                                    <th>Contract</th>
                                    <th>Project Name</th>
                                    <th>Client</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectsthislis as $index => $his)
                                <tr>
                                    <td>{{$his->changes_date}}</td>
                                    <td>{{$his->no_po}}</td>
                                    <td>{{$his->contract->name}}</td>
                                    <td>{{$his->name}}</td>
                                    <td>{{$his->contract->client->name}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Change Date</th>
                                    <th>Cont. Number</th>
                                    <th>Contract</th>
                                    <th>Project Name</th>
                                    <th>Client</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Project History -->
</div>

@stop

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#project_history_table").DataTable({
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

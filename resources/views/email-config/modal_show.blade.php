<!-- Extra large modal -->
<div class="modal fade" id="show-email">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <form id="myFormIdCreate" role="form" action="/email_configuration" method="post" enctype="multipart/form-data"> --}}
            {{-- @csrf --}}
            <div class="modal-header">
                <h4 class="modal-title"> Email List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                <div class="card">
                    {{-- <div class="card-header text-right">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#email-create">Create config Email</button>

                        </div> --}}
                    <div class="card-body">
                        <table id="aldiTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">Id</th>
                                    <th class="text-center">email</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                    @foreach($ec as $e)
                                    <tr>
                                        <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$e->frequency->name}}</td>
                            <td class="text-center">{{$e->duration}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-warning btn-sm dropdown-hover" data-toggle="modal" data-target="#show-email" data-id="{{$e->id}}" onclick="emailShow(this)">
                                        <i class="nav-icon fas fa-eye"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Cek Mail</a>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <form action="/email_configuration/{{$e->id}}" onsubmit="return confirm('Are you sure you want to delete?')" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm dropdown-hover">
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
                            </tbody> --}}
                            <tfoot>
                                <tr>
                                    <th width="30px">Id</th>
                                    <th class="text-center">email</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{-- <button id="myButtonIDCreate" type="submit" class="btn btn-primary">Save changes</button> --}}
            </div>
            {{-- </form> --}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

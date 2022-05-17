<!-- Extra large modal -->
<div class="modal fade" id="suplier-create">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="myFormIdCreate" class="my-0" role="form" action="/suplier/create" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="my-0">Create Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                    <div class="row">
                        <!-- /.col (left) -->
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="my-0">Create</h5>
                                </div>
                                {{-- <form id="myFormId" role="form" action="/types" method="post"> --}}
                                <div class="card-body">
                                    <!-- Date range -->
                                    {{-- <div class="card-body">
                                <input type="checkbox" name="my-checkbox">
                            </div> --}}

                                    <div class="form-group">
                                        <label>Name :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-edit"></i></div>
                                            </div>
                                            {{-- <input name="id" type="hidden"> --}}
                                            <input name="name" type="text" class="form-control text-right text-bold @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <!-- /.card -->
                        </div>
                        <!-- /.col (right) -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="myButtonIDCreate" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

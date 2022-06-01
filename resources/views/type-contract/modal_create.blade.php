<!-- Extra large modal -->
<div class="modal fade" id="type-create">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="myFormIdCreate" role="form" action="/types" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Create Type</h4>
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
                                    <h3 class="card-title">Create</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-edit"></i></div>
                                            </div>
                                            <input name="name" type="text" class="form-control text-right text-bold @error('name') is-invalid @enderror" value="{{old('name')}}">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Display :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-edit"></i></div>
                                            </div>
                                            <input name="display" type="text" class="form-control text-right text-bold @error('display') is-invalid @enderror" value="{{old('display')}}">
                                            @error('display')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="mr-3 ml-2">Required :</label>
                                            <div class="ml-3 custom-control custom-switch custom-switch-md">
                                                <input name="required" type="checkbox" class="custom-control-input" id="customSwitch2">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
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

<!-- Extra large modal -->
<div class="modal fade" id="payment-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="myFormIdCreate" role="form" action="/payments" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Create Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><strong> PO Info</strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Project Name :</strong></span>
                                            </div>
                                            <input id="invoice_id" name="invoice_id" type="hidden" class="form-control text-right" value="{{old('invoice_id')}}">
                                            <input id="project_id" name="project_id" type="hidden" class="form-control text-right" value="{{old('project_id')}}">
                                            <input id="po_name" name="po_name" type="text" class="form-control text-right text-bold" value="{{old('po_name')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Project Number :</strong></span>
                                            </div>
                                            <input id="no_po" name="no_po" type="text" class="form-control text-right text-bold" value="{{old('no_po')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Client Name :</strong></span>
                                            </div>
                                            <input id="client" name="client" type="text" class="form-control text-right text-bold" value="{{old('client')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Progress Name :</strong></span>
                                            </div>
                                            <input id="progress_name" name="progress_name" type="text" class="form-control text-right text-bold" value="{{old('progress_name')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>Total Amount :</strong></span>
                                            </div>
                                            <input id="amountInvoice" name="amountInvoice" type="text" class="form-control text-right text-bold" value="{{old('amountInvoice')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Paid :</strong></span>
                                            </div>
                                            <input id="paid" name="paid" type="text" class="form-control text-right text-bold" value="{{old('paid')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Amount need to be paid :</strong></span>
                                            </div>
                                            <input id="amountNeedToBePaid" name="amountNeedToBePaid" type="text" class="form-control text-right text-bold" value="{{old('amountNeedToBePaid')}}" readonly>
                                        </div>
                                    </div>
                                    <!-- /.form group -->

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                            <!-- /.card -->

                        </div>
                        <!-- /.col (left) -->
                        <div class="col-md-6">
                            <div id="taxdisplay" style="display: none" class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tax</h3>
                                </div>
                                <div class="card-body">
                                    <div id="taxprooflist" style="display: none">

                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong> Total With Tax :</strong></span>
                                            </div>
                                            <input id="amountWithTax" name="amountWithTax" type="text" class="form-control text-right text-bold" value="{{old('amountInvoice')}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Create</h3>
                                </div>
                                {{-- <form id="myFormId" role="form" action="/projects" method="post"> --}}
                                <div class="card-body">
                                    <!-- Date range -->
                                    <div class="row">
                                        <div class="form-group col-10">
                                            <label>Amount Payed :</label><label style="color:#dc3545;">*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <strong>Rp.</strong>
                                                    </span>
                                                </div>
                                                <input required name="amount" type="text" id="rupiah" class="form-control text-right text-bold @error('amount') is-invalid @enderror" value="{{old('amount')}}">
                                                @error('amount')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label style="display: block;text-align: center">Close</label>
                                            <div class="ml-3 custom-control custom-switch custom-switch-md">
                                                <input name="close" type="checkbox" class="custom-control-input" id="customSwitch2" onchange="Fclose()">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="payment_date">Payment Date :</label><label style="color:#dc3545;">*</label>
                                            <div class="input-group date" id="payment_date" data-target-input="nearest">
                                                <input name="payment_date" type="text" class="form-control @error('payment_date') is-invalid @enderror datetimepicker-input" data-target="#payment_date" name="payment_date" placeholder="dd/mm/yyyy" value="{{old('payment_date')}}" />
                                                <div class="input-group-append" data-target="#payment_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @error('payment_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="exampleInputFile">Proof of payment :</label><label style="color:#dc3545;">*</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="filename" type="file" class="custom-file-input @error('filename') is-invalid @enderror" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @error('filename')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="desccomponen" style="display: none">
                                        <div class="form-group">
                                            <label for="desc">Description</label><label style="color:#dc3545;">*</label>
                                            <textarea name="desc" id="desc" class="form-control @error('desc') is-invalid @enderror" rows="3" value="{{old('desc')}}"></textarea>
                                            @error('desc')
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
                    <button id="myButtonID" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

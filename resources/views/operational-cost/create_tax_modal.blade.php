<!-- Extra large modal -->
<div class="modal fade" id="createTaxs">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <form id="invoiceForm" role="form" action="/taxproof" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Set Tax Rate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                    <!-- /.col (left) -->
                    <input type="hidden" name="urlname" value="invoice-taxproof">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tax Rate</h3>
                            </div>
                            <div class="card-body">
                                <div class='form-group row'>
                                    <label class='col-sm-3 col-form-label'>Invoice</label>
                                    <div class='input-group mb-3 col-sm-9'>
                                        <input required type='text' name='invoice_number' placeholder="Input Number Invoice" class='form-control' style='text-align:right;'>
                                        <div class='input-group-append'>
                                            <span class='input-group-text'><i class="fas fa-envelope-open-text"></i></span>
                                        </div>
                                        {{-- <small class="text-danger">Please Input invoice number</small> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="input-tax">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="invoice-send" type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

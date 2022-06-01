<!-- Extra large modal -->
<div class="modal fade" id="pay-cost" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="myFormIdCreate" role="form" action="/payable" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Bill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                    <div id="modal-group" class="row">
                        <div class="col-md-6 modal-gird">
                            <div class="col-md-12">
                                <div class="card bg-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>Cost Info</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><strong> Supplier Name :</strong></span>
                                                </div>
                                                <input id="project_cost_id" name="project_cost_id" type="hidden" class="form-control text-right" value="{{old('project_cost_id')}}">
                                                <input id="project_id" name="project_id" type="hidden" class="form-control text-right" value="{{old('project_id')}}">
                                                <input id="supplier" name="supplier" type="text" class="form-control text-right text-bold" value="{{old('supplier')}}" readonly>
                                            </div>
                                        </div>
                                        <div id="dpp-form" @if (old('dpp')) style="display: block" @else style="display: none" @endif>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong> DPP :</strong></span>
                                                    </div>
                                                    <input id="dpp" name="dpp" type="text" class="form-control text-right text-bold" value="@rupiah(old('dpp'))" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><strong>Bill of quantity :</strong></span>
                                                </div>
                                                <input id="BOQ" name="BOQ" type="text" onchange="setifchecked()" class="form-control text-right text-bold" value="@rupiah(old('BOQ'))" readonly>
                                            </div>
                                        </div>
                                        <div id="payed" @if (old('paid')) style="display: block" @else style="display: none" @endif>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong> Already Paid :</strong></span>
                                                    </div>
                                                    <input id="paid" name="paid" type="text" class="form-control text-right text-bold" value="@rupiah(old('paid'))" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong> Amount need to be paid :</strong></span>
                                                    </div>
                                                    <input id="amountNeedToBePaid" name="amountNeedToBePaid" type="text" class="form-control text-right text-bold text-red" value="@rupiah(old('amountNeedToBePaid'))" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.form group -->

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="taxdisplay" class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Tax</h3>

                                        <div class="float-right">
                                            <a type="button" name="addcost" id="add-btnTax" class="btn btn-sm btn-csplush">Add PPH 23 <i class="fas fa-plus-square"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless" id="dynamicTax">
                                            <tr>
                                                <th class="text-center" style="font-size: 16px">Tax</th>
                                                <th class="text-center" style="font-size: 16px">Percentage%</th>
                                                <th class="text-center" style="font-size: 16px">Total</th>
                                            </tr>
                                            @if (old('tax') == null)
                                            @else
                                            @foreach(old('tax', []) as $key => $taxold)
                                            <tr>
                                            <tr>
                                                <td class='col-3' style="font-size: 16px !important">
                                                    <input type='hidden' name='tax_project_cost_id[]' value="{{old('tax_project_cost_id')[$key]}}">
                                                    <select name='tax[]' class='form-control select2' style='width: 100%' readonly>
                                                        @foreach ($taxs as $item)
                                                        <option value="{{$item->id}}" @if ($taxold==$item->id)
                                                            selected="selected" @else disabled="disabled" @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class='col-2'><input type='text' name='percentage[]' placeholder='e.g 1.0' class='form-control text-right' value="{{old('percentage')[$key]}}" readonly />
                                                </td>
                                                <td><input type='text' id='total_tax' name='total_tax[]' class='form-control text-right' value="{{old('total_tax')[$key]}}" readonly />
                                                </td>
                                            </tr>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card -->


                            <!-- /.card -->

                        </div>
                        <!-- /.col (left) -->
                        <div class="col-md-6 modal-gird">

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Create</h3>
                                </div>
                                {{-- <form id="myFormId" role="form" action="/projects" method="post"> --}}
                                <div class="card-body">
                                    <!-- Date range -->
                                    <div class="form-group row">
                                        <div class="form-group col-12">
                                            <label>Amount Payed :</label><label style="color:#dc3545;">*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <strong>Rp.</strong>
                                                    </span>
                                                </div>
                                                <input required name="amount" type="text" id="rupiah" class="form-control text-right text-bold @error('amount') is-invalid @enderror" @if (old('amount')) value="@rupiah(old('amount'))" @endif>
                                                <div class="input-group icheck-primary d-inline checkboxbill">
                                                    <input type="checkbox" id="checkboxPrimary1" onclick="addalltotal()">
                                                    <label for="checkboxPrimary1">
                                                        Enter all total bills
                                                    </label>
                                                </div>
                                                @error('amount')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="form-group col-2">
                                    <label style="display: block;text-align: center">Close</label>
                                    <div class="ml-3 custom-control custom-switch custom-switch-md">
                                        <input name="close" type="checkbox" class="custom-control-input" id="customSwitch2" onchange="Fclose()">
                                        <label class="custom-control-label" for="customSwitch2"></label>
                                    </div>
                                </div> --}}
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="payment_date">Date :</label><label style="color:#dc3545;">*</label>
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
                                                    <label class="custom-file-label" for="exampleInputFile"> Choose file</label>
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
                    <button id="myButtonID" type="submit" class="btn btn-primary float-right">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

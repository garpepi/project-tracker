@extends('layouts.default')

@section('title', 'Contract - Po')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<style>
    .form-group.required .control-label:after {
        content:"*";
        color:red;
    }
    .choices__inner {
        border-radius: 0.35rem;
    }
</style>
@stop

@section('custom_script')
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#choose_category').modal('show')
            $('#add_blanket-rec').click(function(){ add_blanket(); return false; });
            $('.remove_blanket-rec').click(function(){ remove_blanket(this); return false; });
            var clone_blanker_rec = $('.blanket-rec').clone().prop('outerHTML')

            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount:5,
                searchResultLimit:5,
                renderChoiceLimit:5
            });

            $(document).on('change','#contract_type',function(){
                hide_content($('#contract_type').val(), $('#contract_type option:selected').text());
                $('#choose_category').modal('hide')
            });
            
            function hide_content(category_type, title){
                switch(category_type) {
                    case "4":
                        return;
                    case "3":
                        $('.volume_blanket').hide();
                        $('#custom_blanket_title').text('Maximum Total Price');
                    case "2":
                        $('.volume_blanket').hide();
                        $('#custom_blanket_title').text('Maximum Quantity');
                    case "1":
                        $('#custom_blanket').hide();
                }

                $('#blanket').show();
                // Change title
                $('#blanket_title').text(title);
                clone_blanker_rec = $('.blanket-rec').clone().prop('outerHTML')
            }

            function add_blanket() {
                // clone_blanker_rec.appendTo('.blanket_loop');
                $('.blanket_loop').append(clone_blanker_rec);
                $('.remove_blanket-rec').click(function(){ remove_blanket(this); return false; });
            }
            
            function remove_blanket(selected) {
                if($('.blanket_loop .blanket-rec').length > 1) {
                    $(selected).closest('.blanket-rec').remove();
                }
            }
        });
    </script>
@stop

@section('content')
                <!-- Modal -->
                    <div class="modal fade" id="choose_category" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="choose_category">Contract Type</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group col-md-12 required">
                                    <select class="form-control" id="contract_type" required>
                                        <option>Select Contract Type</option>
                                        <option value=1>Blanket</option>
                                        <option value=2>Blanket Quantity Global</option>
                                        <option value=3>Blanket Value Global</option>
                                        <option value=4>Non Blanket</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                <!-- End Modal -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Contract / PO</h1>
                    <p class="mb-4">List of Contract and Purchase Order (PO) that already recorded.</p>

                    <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Create Contract</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/profile" class="col-md-12" >
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6 required">
                                                <label class="control-label" for="contract.name">Contract Name</label>
                                                <input type="text" class="form-control" id="contract.name" placeholder= "Contract Name" required>
                                            </div>
                                            <div class="form-group col-md-6 required">
                                                <label class="control-label" for="contract.client">Client</label>
                                                <select class="form-control" id="contract.client" required>
                                                    <option>Choose Client!</option>
                                                    <option>2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6 required">
                                                <label class="control-label" for="contract.number">No Contract</label>
                                                <input type="text" class="form-control" placeholder= "No Contract"  id="contract.number" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contract.signdate">Contract Sign-date</label>
                                                <div class="md-form md-outline input-with-post-icon datepicker">
                                                    <input placeholder="Select date" type="date" id="contract.signdate" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="contract.startdate">Start Date</label>
                                                <div class="md-form md-outline input-with-post-icon datepicker">
                                                    <input placeholder="Select date" type="date" id="contract.startdate" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contract.enddate">End Date</label>
                                                <div class="md-form md-outline input-with-post-icon datepicker">
                                                    <input placeholder="Select date" type="date" id="contract.enddate" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div id="blanket" style="display: none;">
                                            <h6 class="m-0 font-weight-bold text-primary text-center" id="blanket_title">Blanket</h6>
                                            <hr class="my-12"/>
                                            <div class="form-row" id="custom_blanket">
                                                <div class="form-group col-md-2 offset-md-2 text-center">
                                                    <label class="control-label" id="custom_blanket_title">{Maximum}</label>
                                                    <input type="number" class="form-control" placeholder="Maximum" id="custom_blanket" required>
                                                </div>  
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2 offset-md-2 text-center">
                                                    <label class="control-label">Description</label>
                                                </div>
                                                <div class="form-group col-md-2 text-center">
                                                    <label class="control-label">Unit used</label>
                                                </div>
                                                <div class="form-group col-md-2 text-center volume_blanket">
                                                    <label class="control-label">Volume</label>
                                                </div>
                                                <div class="form-group col-md-2 text-center">
                                                    <label class="control-label">Price @</label>
                                                </div> 
                                                <div class="form-group col-md-2 text-center ml-auto">
                                                    <a id="add_blanket-rec" href="#" class="btn-sm btn-success btn-circle">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </a>
                                                </div>    
                                            </div>
                                            <div class="blanket_loop">
                                                <div class="form-row blanket-rec">
                                                    <div class="form-group col-md-2 offset-md-2">
                                                        <input type="text" class="form-control" placeholder="Description" id="contract.name" required>
                                                    </div>
                                                    <div class="form-group col-md-2 volume_blanket">
                                                        <input type="text" class="form-control" placeholder="Unit used" id="contract.name" required>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <input type="text" class="form-control" placeholder="Volume" id="contract.name" required>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <input type="text" class="form-control" placeholder="Price @" id="contract.name" required>
                                                    </div> 
                                                    <div class="form-group col-md-2 text-center ml-auto">
                                                        <a href="#" class="btn-sm btn-danger btn-circle remove_blanket-rec">
                                                            <i class="fas fa-minus-circle"></i>
                                                        </a>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <br>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleFormControlFile1">Example file input</label>
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                            </div>
                                            <div class="form-group col-md-6 required rounded-please">
                                                <label class="control-label" for="contract.client">Viewable By</label>
                                                <select class="form-control" id="choices-multiple-remove-button" multiple required>
                                                    <option>Choose Client!</option>
                                                    <option>2</option>
                                                    <option>12</option>
                                                    <option>aaja</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center bd-highlight mb-3">
                                            <div class="p-2 bd-highlight">
                                                <a href="{{ route('Operationalcontract-po') }}" class="btn btn-danger">Back</a>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <button id="myButtonID" type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>

                    

                </div>
                
@stop
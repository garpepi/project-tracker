<!-- Extra large modal -->
<div class="modal fade" id="payment-show">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            {{-- <form id="myFormIdCreate" role="form" action="/payments" method="post" enctype="multipart/form-data">
                @csrf --}}
            <div class="modal-header">
                <h4 class="modal-title">Payment Received</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: rgb(241, 240, 240)">

                <div class="card">
                    {{-- <div class="card-header text-right">
                            <a href="/progress_status/create" class="btn btn-primary">Create Project</a>
                        </div> --}}
                    <div class="card-body">
                        <table id="aldiTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Progress Name</th>
                                    <th>Client</th>
                                    <th>Po Name</th>
                                    <th>Payment Received</th>
                                    <th>Total Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

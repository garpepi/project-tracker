<!-- Extra large modal -->
<div class="modal fade" id="set-menu">
    <div class="modal-dialog model">
        <div class="modal-content">
            <form id="myFormIdCreate" class="my-0" role="form" action="/access_menu" method="post" enctype="multipart/form-data">
                {{-- @csrf --}}
                <div class="modal-header">
                    <h4 class="my-0">Set Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="dismisModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(241, 240, 240)">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="my-0">Menu</h5>

                            <div class="card-tools">
                                <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button> -->
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <input id="role" type="hidden" name="role_id" value="">
                            <div class="row">
                                @foreach ($menuheader as $key => $mH)
                                <div class="col-12 mt-3">
                                    <h4>{{$mH->name}}</h4>
                                </div>
                                @foreach ($mH->menu as $keym => $menu)
                                @if ($mH->name == 'Configuration')
                                <div class="col-md-6 mb-3">
                                    <div class="icheck-primary d-inline col-12">
                                        <input type="checkbox" name="menu[]" id="checkboxPrimary{{$menu->id}}" onclick="checkedMenu(this)" data-id="{{$menu->id}}" data-on="1" data-off="0" value="" checked disabled>
                                        <label for="checkboxPrimary{{$menu->id}}" style="font-weight: unset;">
                                            {{$menu->name}}
                                        </label>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6 mb-3">
                                    <div class="icheck-primary d-inline col-12">
                                        <input type="checkbox" name="menu[]" id="checkboxPrimary{{$menu->id}}" onclick="checkedMenu(this)" data-name="{{$menu->name}}" data-accessmenuid="" data-menuid="{{$menu->id}}" data-menuheaderid="{{$mH->id}}" value="">
                                        <label for="checkboxPrimary{{$menu->id}}" style="font-weight: unset;">
                                            {{$menu->name}}
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endforeach
                                {{-- @php
                                        dd($accessMenu);
                                    @endphp --}}
                                {{-- @if (!empty($accessMenu))
                                    <h1>1</h1>
                                @endif --}}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default my-0" data-dismiss="modal" onclick="dismisModal()">Close</button>
                    {{-- <button id="myButtonID" type="submit" class="btn btn-primary">Save changes</button> --}}
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

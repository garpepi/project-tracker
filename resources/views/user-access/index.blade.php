@extends('layouts.default')

@section('title', 'Contract - Po')

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
    <h1 class="h3 mb-2 text-gray-800">Access Menu</h1>
    <p class="mb-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam corporis illo voluptas animi expedita, nisi officia libero quis porro illum esse beatae eos fugiat necessitatibus consequuntur fuga dolorum doloribus. Suscipit.</p>

    <!-- List Access Menu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">List Access Menu
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menu_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Role Name</th>
                            <th class="text-center">Set Menu Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role as $key => $r)
                        <tr>
                            <th class="text-center">{{$loop->iteration}}</th>
                            <td class="text-center">{{$r->name}}</td>

                            <td class="text-center">
                                <!-- show -->
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary dropdown-hover" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#set-menu" onclick="showMenu({{$r->id}})">
                                        <i class="nav-icon fas fa-pen"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Set</a>
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Role Name</th>
                            <th class="text-center">Set Menu Access</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End List Access Menu -->

</div>

@stop

@include('user-access.modal_setmenu')

@section('custom_script')
<!-- Page level plugins -->
<script src="{{ url('/sb-admin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/sb-admin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $("#menu_table").DataTable({
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
<script>
    function dismisModal() {
        location.reload();
    }

    function showMenu(id) {
        var roleId = id;
        var urlname = 'access_menu';
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "/access_menu/" + roleId,
            type: 'get',
            data: {
                "urlname": urlname,
                "id": id,
                "_token": token,
            },
            success: function(data) {
                console.log(data.accessMenu);
                var menuchecked = data.accessMenu;
                menuchecked.forEach(element => {
                    $("#checkboxPrimary" + element.menu_id).prop('checked', true);
                    $("#checkboxPrimary" + element.menu_id).val(1);
                    $("#checkboxPrimary" + element.menu_id).attr('data-accessmenuid', element.id);
                });
                $("#role").val(data.role);
                // {{ $accessMenu}} = data.accessMenu;
                // location.reload();
            },
            error: function(xhr, data, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(data);
            }
        });
    }
</script>
<script>
    function checkedMenu(e) {
        // console.log($(e).attr('data-id'));
        // console.log(e.checked);
        if (e.checked == true) {
            var checkedAction = 1;
        } else if (e.checked == false) {
            var checkedAction = 0;
        }
        var menuheader = $(e).attr('data-menuheaderid');
        var menuid = $(e).attr('data-menuid');
        var role = $("#role").val();
        var urlname = 'checked_menu';
        var accessmenuid = $(e).attr('data-accessmenuid');
        var name = $(e).attr('data-name');
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "/access_menu/" + role,
            async: false,
            type: 'get',
            data: {
                "urlname": urlname,
                "name": name,
                "access_menu_id": accessmenuid,
                "menu_id": menuid,
                "menu_header_id": menuheader,
                "role_id": role,
                "active": checkedAction,
                "_token": token,
            },
            success: function(data) {
                var menuchecked = data.accessMenu;
                menuchecked.forEach(element => {
                    $("#checkboxPrimary" + element.menu_id).prop('checked', true);
                    $("#checkboxPrimary" + element.menu_id).val(1);
                    $("#checkboxPrimary" + element.menu_id).attr('data-accessmenuid', element.id);
                });
                $("#role").val(data.role);
                // console.log(data.success);
                // location.reload();
                let timerInterval
                Swal.fire({
                    icon: data.icon,
                    title: data.alerttitle,
                    html: 'I will close in <b></b> milliseconds.',
                    allowOutsideClick: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                });
            },
            error: function(xhr, data, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                // console.log(textStatus);
                console.log(data);
            }
        });
        // else if(e.checked == false){
        //     // e.type = 'hidden';
        //     e.value = 0;
        // }else if(!e.checked){
        //     e.value = 0;
        // }
    }
    // $( document ).ready(function() {
    //     // Checkbox instead of on:off 1:0
    //     $('input:checkbox').on('change', function(){
    //     //   this.value = this.checked ? 1 : 0;
    //       if (this.checked) {
    //         // $("#test").attr("data-id")
    //         // var id = $(this).data("id");
    //         // console.log(id);
    //         // var id = $(this).data("id");
    //         this.value = 'yes';
    //       }
    //       else if (!this.checked) {
    //         this.value = 'no action';
    //       }
    //     }).change();
    //   });
</script>
@stop

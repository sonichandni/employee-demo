<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

</head>
<body>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->has('message'))
    <div class="alert alert-danger">
        {{ $errors->first('message') }}
    </div>
@endif

<div class="container mt-4">
    @php
        $user = auth()->user();
    @endphp
    <div class="row">
        <div class="text-center">
            <h2>Employees</h2>
        </div>
        <div class="col-12 table-responsive">
            <table class="table table-bordered employee_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Designation</th>
                        <th>Address</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


<script type="text/javascript">
    var table;
    $(function () {
        table = $('.employee_datatable').DataTable({
            dom: 'Bfrtip',
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            buttons: [
                @if($user->is_admin == 1)
                {
                    text: 'Add Employee',
                    class: 'btn',
                    action: function ( e, dt, node, config ) {
                        window.location = "{{ route('create') }}";
                    }
                },
                {
                    text: 'Add Bulk Employee',
                    class: 'btn',
                    action: function ( e, dt, node, config ) {
                        window.location = "{{ route('bulk-upload') }}";
                    }
                }
                @endif
            ],
            ajax: "{{ route('dashboard') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'number', name: 'number'},
                {data: 'designation', name: 'designation'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    function delete_data(id) {
        swal({
            title: "Are you sure to delete?",
            text: "Data permanently delete from database",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes!",
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            showLoaderOnConfirm: true,
            preConfirm: false,
            buttonsStyling: false
        }, function (tf) {
            if (tf) {
                if (id > 0) {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{!! route('delete') !!}',
                        data: {id: id},
                        success: function (result) {
                            if (result.status == true) {
                                swal("Success", result.message, "success");
                                var info = table.page.info();
                                var current_page = info['page'];
                                table.page(current_page).draw(false);
                            } else {
                                var info = table.page.info();
                                var current_page = info['page'];
                                table.page(current_page).draw(false);
                                swal("Fail", result.message, "error");
                            }
                        },
                        error: function (result) {
                            var info = table.page.info();
                            var current_page = info['page'];
                            table.page(current_page).draw(false);
                            swal("Fail", result.message, "error");
                        }

                    });
                }
            }
        })
    }
</script>
</html>

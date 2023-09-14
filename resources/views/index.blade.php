<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>CRUD APPLICATION IN LARAVEL AJAX</title>
</head>

<body>
    {{-- add new employee modal start --}}
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store') }}" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                    required>
                            </div>
                            <div class="col-lg">
                                <label for="lname">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                    required>
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="my-2">
                            <label for="phone">Address</label>
                            <input type="tel" name="address" class="form-control" placeholder="Address" required>
                        </div>
                        <div class="my-2">
                            <label for="post">Post</label>
                            <input type="text" name="post" class="form-control" placeholder="Post" required>
                        </div>
                        <div class="my-2">
                            <label for="avatar">Select Avatar</label>
                            <input type="file" name="avatar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add new employee modal end --}}

    {{-- edit employee modal start --}}
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    placeholder="First Name" required>
                            </div>
                            <div class="col-lg">
                                <label for="lname">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="E-mail" required>
                        </div>
                        <div class="my-2">
                            <label for="phone">Address</label>
                            <input type="tel" name="address" id="address" class="form-control"
                                placeholder="Address" required>
                        </div>
                        <div class="my-2">
                            <label for="post">Post</label>
                            <input type="text" name="post" id="post" class="form-control"
                                placeholder="Post" required>
                        </div>
                        <div class="my-2">
                            <label for="avatar">Select Avatar</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>
                        <div class="mt-2" id="avatar">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_employee_btn" class="btn btn-success">Update
                            Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- edit employee modal end --}}


        <div class="container">
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                            <h3 class="text-light">Manage Employees</h3>
                            <button class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#addEmployeeModal"><i class="bi-plus-circle me-2"></i>Add New
                                Employee</button>
                        </div>
                        <div class="card-body" id="show_all_employees">
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // fetch all employees ajax request

            fetchallemployees();

            function fetchallemployees()
            {
                $.ajax({
                    url: "{{ route('fetchall') }}",
                    method: 'get',
                    success: function(res){
                        //console.log(res);
                        $("#show_all_employees").html(res);
                        $("table").DataTable({
                            order: [0, 'asc']
                        });
                    }
                });
            }

            // delete employee ajax request

            $(document).on('click','.deleteIcon',function(e){
                e.preventDefault();
                let id = $(this).attr('id');
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteemployee') }}",
                        method: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res){
                            swal.fire(
                                'Deleted',
                                'Employee Deleted Successfully!',
                                'success'
                            )
                            fetchallemployees();
                        }
                    });
                }
                });
            });

            // update employee ajax request

            $("#edit_employee_form").submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_employee_btn").text("Updating...");

                $.ajax({
                    url: "{{ route('updateemployee') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(res){
                        // console.log(res);
                        if(res.status == 200)
                        {
                            swal.fire(
                                'Updated!',
                                'Employee Added Successfully',
                                'success'
                            )
                            fetchallemployees();
                        }
                        $("#edit_employee_btn").text("Update Employee");
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModal").modal('hide');
                    }
                });
            });



            // edit employee ajax request

            $(document).on('click','.editIcon', function(e){
                e.preventDefault();  //prevent page refresh
                let id = $(this).attr('id');  //fetching id of the user using attribut
                $.ajax({
                    url: "{{ route('editemployee') }}",
                    method:'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        //console.log(res);
                        $("#first_name").val(res.first_name);
                        $("#last_name").val(res.last_name);
                        $("#email").val(res.email);
                        $("#address").val(res.address);
                        $("#post").val(res.post);
                        $("#avatar").html(`<img src = "storage/images/${res.avatar}" width = "100" class = ""img-fluid img-thumbnail>`);
                        $("#emp_id").val(res.id);
                        $("#emp_avatar").val(res.avatar);
                    }
                });
            });


// add new employee ajax request
            $("#add_employee_form").submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Adding...');
                $.ajax({
                    url: "{{ route('store') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(res){
                        if(res.status == 200)
                        {
                            swal.fire(
                                'Added!',
                                'Employee Added Successfully!',
                                'success'
                            )
                            fetchallemployees();
                        }
                        $("#add_employee_btn").text('Add Employee');
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                    }
                });
            });

        </script>
</body>

</html>

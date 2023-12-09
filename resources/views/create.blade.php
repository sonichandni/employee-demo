<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        form label {
            display: inline-block;
            width: 100px;
        }

        form div {
            margin-bottom: 10px;
        }

        .error {
            color: red;
            margin-left: 5px;
        }

        label.error {
            display: inline;
        }

    </style>
</head>
<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="m-4">
        <div class="row d-flex">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h2>Store Employee</h2>
                        <button onclick="dashboard();">Dashboard</button>
                    </div>
                    <form method="POST" action="{{ route('store') }}">
                        @csrf
                        <input type="hidden" value="{{$employee->id ?? null}}" name="eid">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{ old('name') ? old('name') : (!empty($employee) ? $employee->name : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') ? old('email') : (!empty($employee) ? $employee->email : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="number" class="form-label">Number</label>
                                <input type="number" class="form-control" id="number" name="number" placeholder="Enter your number" value="{{ old('number') ? old('number') : (!empty($employee) ? $employee->number : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter your designation" value="{{ old('designation') ? old('designation') : (!empty($employee) ? $employee->designation : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" placeholder="Enter your address">{{ old('address') ? old('address') : (!empty($employee) ? $employee->address : '') }}</textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Store</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                name: {
                    required: true,
                },
                designation: {
                    required: true,
                },
                address: {
                    required: true,
                },
                number: {
                    required: true,
                },
            },
            messages: {
                email: {
                    email: 'Enter a valid email',
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });

    function dashboard () {
        window.location = "{{ route('dashboard') }}";
    }
</script>
</html>

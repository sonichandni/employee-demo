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
                        <h2>Store Bulk Employee</h2>
                        <button onclick="dashboard();">Dashboard</button>
                    </div>
                    <form method="POST" action="{{ route('bulk-upload-store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Employee File</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" >
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
        $.validator.addMethod("csv", function(value, element) {
            return this.optional(element) || /\.(csv)$/i.test(value);
        }, "Please select a CSV file.");

        $('form').validate({
            rules: {
                csv_file: {
                    required: true,
                    csv: true
                },
            },
            messages: {
                csv_file: {
                    csv: 'Please select a CSV file.',
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

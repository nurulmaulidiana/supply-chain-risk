<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Supply Chain Risk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-card{
            border:none;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,.15);
        }

        .login-title{
            color:#7A1F1F;
            font-weight:bold;
        }

        .btn-maroon{
            background:#7A1F1F;
            color:white;
        }

        .btn-maroon:hover{
            background:#5f1717;
            color:white;
        }
    </style>

</head>
<body>

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card login-card">

                <div class="card-body p-5">

                    <h2 class="text-center login-title">
                        Supply Chain Risk
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Global Supply Chain Monitoring System
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="/login">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <button class="btn btn-maroon w-100">
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
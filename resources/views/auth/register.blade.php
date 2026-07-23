<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Supply Chain Risk</title>

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
                        Buat Akun Baru
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required>
                        </div>

                        <button class="btn btn-maroon w-100">
                            Register
                        </button>

                        <p class="text-center mt-3 mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}">Login di sini</a>
                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
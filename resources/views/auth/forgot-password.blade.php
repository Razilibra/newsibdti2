<!-- resources/views/auth/forgot-password.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @include('include.style')
    <style>
        body {
            background-image: url('images/photo122.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #auth {
            background: rgba(0, 0, 0, 0.5); /* Optional: tambahkan overlay gelap */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            max-width: 400px; /* Lebar maksimum form login */
        }

        .logo img {
            width: 100px;
            height: 100px;
        }

        .auth-title {
            margin: 20px 0;
            font-size: 24px;
            color: yellow;
        }

        .auth-subtitle {
            color: #dcdcdc;
        }

        .form-group {
            width: 100%;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 1.25rem 1rem;
            font-size: 1rem;
            background-color: #f8f9fa;
            border: none;
            box-shadow: none;
        }

        .form-control:focus {
            background-color: #e9ecef;
            box-shadow: none;
        }

        .form-control-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 15px;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            font-size: 1rem;
            padding: 0.75rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-check-label {
            color: #dcdcdc;
        }

        .text-gray-600 {
            color: #dcdcdc !important;
        }

        .btn-danger {
            font-size: 12px;
        }

        .mt-5 {
            margin-top: 1.25rem;
        }

        .text-lg {
            font-size: 1.25rem;
        }

        .fs-5 {
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="logo">
            <img src="{{ asset('template/assets/images/logo/favicon.png') }}" alt="Logo">
        </div>
        <h4 class="auth-title">Forgot Password</h4>
        <p class="auth-subtitle mb-5">Enter your email to reset your password.</p>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <div class="form-group position-relative has-icon-left">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror form-control-xl" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                <div class="form-control-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                @error('email')
                <small class="btn btn-danger">{{$message}}</small>
                @enderror
            </div>
            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Reset Password</button>
        </form>

        <div class="text-center mt-5 text-lg fs-5">
            <p class="text-gray-600">Remember your password? <a href="{{ route('login') }}" class="font-bold">Log in</a>.</p>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS for styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000; /* Background color set to black */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            border-radius: 1rem;
        }

        .card-body {
            padding: 4rem !important;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .form-control-icon {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            pointer-events: none;
        }
    </style>
</head>
<body>

<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                alt="register form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form action="{{ route('register.store') }}" method="POST">
                                    @csrf

                                    @if (session()->has('registerError'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('registerError') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">Logo</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create an
                                        account</h5>

                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="Your Name">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        @error('name')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="Email">
                                        <div class="form-control-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        @error('email')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Password">
                                        <div class="form-control-icon">
                                            <i class="bi bi-shield-lock"></i>
                                        </div>
                                        @error('password')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm Password">
                                        <div class="form-control-icon">
                                            <i class="bi bi-shield-lock"></i>
                                        </div>
                                        @error('password_confirmation')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <select id="role" name="role"
                                            class="form-control form-control-lg @error('role') is-invalid @enderror"
                                            required>
                                            <option value="">Select Role</option>
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="dosen">Dosen</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                        @error('role')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="g-recaptcha" data-sitekey="6Lc9S6AZAAAAAOqWVoSesu43oUnK3H5fjRRToZIK"></div>
                                        @error('g-recaptcha-response')
                                        <small class="btn btn-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                                        type="submit">Register</button>

                                    <p class="mt-3 mb-0 text-muted">Already have an account? <a
                                            href="{{ route('login') }}">Login here</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Your custom script -->
<script src="scripts.js"></script>
<!-- Google reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS for styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000;
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

        .btn-dark {
            background-color: #393f81;
            border-color: #393f81;
        }

        .btn-dark:hover {
            background-color: #1d1f3e;
            border-color: #1d1f3e;
        }

        .small {
            color: #393f81;
        }
    </style>
</head>
<body>

<section class="vh-100" style="background-color: #000;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.jpg"
                                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form action="{{ route('login.store') }}" method="POST">
                                    @csrf

                                    @if (session()->has('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('loginError') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">Logo</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                        account</h5>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" id="form2Example17"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="Email address" name="email">
                                        <label class="form-label" for="form2Example17">Email address</label>
                                        @error('email')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="form2Example27"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password">
                                        <label class="form-label" for="form2Example27">Password</label>
                                        @error('password')
                                        <small class="btn btn-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                    </div>

                                    <a class="small text-muted" href="#">Forgot password?</a>
                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                            href="/register" style="color: #393f81;">Register here</a></p>
                                    <a href="#" class="small text-muted">Terms of use.</a>
                                    <a href="#" class="small text-muted">Privacy policy</a>
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
</body>
</html>

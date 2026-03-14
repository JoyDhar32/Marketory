<x-layouts.app title="Login">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 class="font-poppins fw-bold">Welcome Back</h2>
                    <p class="text-muted">Sign in to your Marketory account</p>
                </div>
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com" autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Sign In</button>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-500">Register</a></small>
                    </div>
                    <hr class="my-3">
                    <div class="text-center">
                        <small class="text-muted d-block mb-1">Admin demo credentials:</small>
                        <small class="text-muted">admin@marketory.com / password</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>

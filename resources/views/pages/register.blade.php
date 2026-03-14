<x-layouts.app title="Register">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 class="font-poppins fw-bold">Create Account</h2>
                    <p class="text-muted">Join Marketory and start shopping</p>
                </div>
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Create Account</button>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-500">Sign In</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>

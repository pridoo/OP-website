<x-guest-layout>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('blogimage/seas.gif') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .auth-card {
            background-color: rgba(255, 255, 255, 0.5); 
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: auto;
            margin-top: 10%;
        }

        .auth-card h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        .social-buttons a {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #ea4335; /* Google red */
        }

        .btn-primary {
            background-color: #4267B2; /* Facebook blue */
        }

        .social-buttons a:hover {
            opacity: 0.9;
        }
    </style>

    <div class="auth-card">
        <h1>Login</h1>
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <div class="social-buttons mt-4">
            <a href="{{ url('/auth/google') }}" class="btn btn-danger">Login with Google</a>
            <a href="{{ url('auth/facebook') }}" class="btn btn-primary">Login with Facebook</a>
        </div>
    </div>
</x-guest-layout>

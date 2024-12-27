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
            margin-top: 5%;
        }

        .auth-card h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        .auth-card .form-group {
            margin-bottom: 15px;
        }

        .auth-card label {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .auth-card input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .auth-card .terms {
            font-size: 0.9rem;
            color: #333;
        }

        .auth-card .btn {
            width: 100%;
            background-color: #4A90E2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }

        .auth-card .btn:hover {
            background-color: #357ABD;
        }

        .auth-card a {
            display: block;
            text-align: center;
            font-size: 0.9rem;
            margin-top: 15px;
            color:rgb(18, 18, 18);
            text-decoration: none;
        }

        .auth-card a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="auth-card">
        <h1>Register</h1>

        <x-validation-errors class="mb-4 text-red-500" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>

            <!-- Password Confirmation -->
            <div class="form-group">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="form-group terms">
                    <label for="terms">
                        <input type="checkbox" name="terms" id="terms" required>
                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                        ]) !!}
                    </label>
                </div>
            @endif

            <button type="submit" class="btn">
                {{ __('Register') }}
            </button>

            <a href="{{ route('login') }}">{{ __('Already registered?') }}</a>
        </form>
    </div>
</x-guest-layout>

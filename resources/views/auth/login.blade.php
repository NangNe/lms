<x-guest-layout>
    <style>
        .login-container {
            min-height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f8fc;
        }

        .login-card {
            width: 90%; /* Chiếm 90% chiều rộng của màn hình */
            max-width: 60rem; /* Tăng chiều rộng tối đa */
            background-color: white;
            padding: 30px 50px; /* Tăng padding để rộng rãi hơn */
            border-radius: 20px; /* Tăng bán kính bo tròn */
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2); /* Tăng độ mờ bóng */
            text-align: center;
        }

        .login-title {
            font-size: 2rem; /* Giảm kích thước font của tiêu đề */
            font-weight: bold;
            color: #ffb300;
            margin-bottom: 30px;
        }

        .login-input {
            width: 100%;
            padding: 14px; /* Giảm padding để ô input nhỏ hơn */
            font-size: 1rem; /* Giảm kích thước font trong ô input */
            border-radius: 8px; /* Tăng bán kính bo tròn */
            border: 1px solid #ddd;
            margin-top: 15px; /* Tăng khoảng cách giữa các input */
            margin-bottom: 20px; /* Tăng khoảng cách dưới cùng */
            transition: border-color 0.2s;
        }

        .login-input:focus {
            border-color: #2563eb;
            outline: none;
        }

        .login-button {
            width: 100%;
            padding: 14px; /* Giảm padding của nút đăng nhập */
            border-radius: 8px;
            background-color: #1d4ed8;
            color: white;
            font-size: 1.2rem; /* Giảm kích thước font của nút đăng nhập */
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #1e40af;
        }

        .login-link {
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
            font-size: 0.9rem; /* Giảm kích thước font của link */
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #1e40af;
        }

        .logo img {
            width: 500px; /* Tăng kích thước logo */
            height: auto;
            margin-bottom: 30px;
        }

        /* Media Queries */
        @media (min-width: 640px) {
            .sm\:rounded-lg {
                border-radius: 1rem; /* Tăng bán kính bo tròn */
            }

            .sm\:max-w-md {
                max-width: 37rem; /* Tăng chiều rộng tối đa */
            }
        }
    </style>
    <div class="flex lg:justify-center lg:col-start-2">
        <img src="https://elib.vku.udn.vn/image/LogoVKU.png" alt="">
    </div>
    <div class="login-container">
        <div class="login-card sm:rounded-lg sm:max-w-md">

            <h2 class="login-title">{{ __('Login') }}</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <input id="email" class="login-input" type="email" name="email" placeholder="Email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div>
                    <input id="password" class="login-input" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mt-2">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span class="ml-2 text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button mt-4">
                    {{ __('Log in') }}
                </button>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="login-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>

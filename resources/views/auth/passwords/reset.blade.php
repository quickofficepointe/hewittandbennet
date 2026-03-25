<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Hewitt Bennet International College</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .password-match {
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <!-- Simulating the @extends('layouts.welcomelayout') -->
    <div class="fixed top-0 left-0 w-full bg-white shadow-md py-3 px-6 flex items-center justify-between">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/40x40/4F46E5/FFFFFF?text=HB" alt="Logo" class="h-8 w-8 rounded">
            <span class="ml-2 font-semibold text-gray-800">Hewitt Bennet International College</span>
        </div>
        <div>
            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm">Login</a>
        </div>
    </div>

    <!-- Simulating the @section('content') -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 space-y-6 mt-10">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Reset Password</h2>
            <p class="text-sm text-gray-600 mt-2">Enter your new password below</p>
        </div>

        <form id="passwordResetForm">
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="email" value="user@example.com" required autocomplete="email" autofocus>
                <p class="mt-2 text-sm text-red-500 hidden email-error">Please enter a valid email address</p>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input id="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="password" required autocomplete="new-password">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength bg-gray-200 mt-1"></div>
                <p class="text-xs text-gray-500 mt-1">Use at least 8 characters with a mix of letters, numbers & symbols</p>
                <p class="mt-2 text-sm text-red-500 hidden password-error">Password must be at least 8 characters</p>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password-confirm" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="password_confirmation" required autocomplete="new-password">
                <p id="passwordMatch" class="password-match text-red-600"><i class="fas fa-times-circle mr-1"></i> Passwords do not match</p>
                <p id="passwordMatchSuccess" class="password-match text-green-600"><i class="fas fa-check-circle mr-1"></i> Passwords match</p>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password-confirm');
            const togglePasswordButton = document.getElementById('togglePassword');
            const passwordMatch = document.getElementById('passwordMatch');
            const passwordMatchSuccess = document.getElementById('passwordMatchSuccess');
            const passwordStrength = document.querySelector('.password-strength');
            const form = document.getElementById('passwordResetForm');

            let isPasswordVisible = false;

            // Toggle password visibility
            togglePasswordButton.addEventListener('click', function() {
                isPasswordVisible = !isPasswordVisible;
                passwordInput.type = isPasswordVisible ? 'text' : 'password';
                confirmPasswordInput.type = isPasswordVisible ? 'text' : 'password';
                togglePasswordButton.innerHTML = isPasswordVisible ?
                    '<i class="far fa-eye-slash"></i>' :
                    '<i class="far fa-eye"></i>';
            });

            // Check password strength
            passwordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                let strength = 0;

                // Check password length
                if (password.length >= 8) strength += 20;

                // Check for lowercase letters
                if (password.match(/[a-z]+/)) strength += 20;

                // Check for uppercase letters
                if (password.match(/[A-Z]+/)) strength += 20;

                // Check for numbers
                if (password.match(/[0-9]+/)) strength += 20;

                // Check for special characters
                if (password.match(/[!@#$%^&*(),.?":{}|<>]+/)) strength += 20;

                // Update strength indicator
                if (strength <= 40) {
                    passwordStrength.style.backgroundColor = '#ef4444'; // red
                } else if (strength <= 80) {
                    passwordStrength.style.backgroundColor = '#f59e0b'; // amber
                } else {
                    passwordStrength.style.backgroundColor = '#10b981'; // green
                }

                passwordStrength.style.width = strength + '%';

                // Check if passwords match
                checkPasswordMatch();
            });

            // Check if passwords match
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword.length === 0) {
                    passwordMatch.style.display = 'none';
                    passwordMatchSuccess.style.display = 'none';
                    return;
                }

                if (password === confirmPassword) {
                    passwordMatch.style.display = 'none';
                    passwordMatchSuccess.style.display = 'block';
                } else {
                    passwordMatch.style.display = 'block';
                    passwordMatchSuccess.style.display = 'none';
                }
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Validate passwords match
                if (password !== confirmPassword) {
                    passwordMatch.style.display = 'block';
                    return;
                }

                // Validate password strength
                if (password.length < 8) {
                    document.querySelector('.password-error').style.display = 'block';
                    return;
                }

                // If validation passes, submit the form
                alert('Password reset successfully!');
                form.reset();
                passwordStrength.style.width = '0%';
                passwordMatch.style.display = 'none';
                passwordMatchSuccess.style.display = 'none';
            });
        });
    </script>
</body>
</html>


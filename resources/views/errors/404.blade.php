<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | B'mine</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <meta name="description" content="Page not found">

    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bmine-orange': '#FF8A00',
                        'bmine-green': '#4CAF50',
                    }
                }
            }
        }
    </script>

    <!-- Custom styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%234CAF50' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .shadow-custom {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-white pattern min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-custom overflow-hidden relative">
        <!-- Colored Top Bar -->
        <div class="h-3 w-full bg-gradient-to-r from-bmine-green via-bmine-orange to-bmine-green"></div>

        <div class="grid md:grid-cols-2 gap-0">
            <!-- Left Column: Illustration -->
            <div class="bg-gradient-to-br from-bmine-orange/10 to-bmine-green/10 p-12 flex items-center justify-center">
                <div class="relative w-full max-w-xs">
                    <!-- Background Circle -->
                    <div class="absolute inset-0 bg-bmine-orange/20 rounded-full transform scale-90 animate-float"
                        style="animation-delay: 0.5s"></div>

                    <!-- 404 Text -->
                    <div class="relative">
                        <div class="text-center">
                            <div class="text-9xl font-extrabold"
                                style="background: linear-gradient(135deg, #4CAF50, #FF8A00); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                404</div>
                            <img src="{{ asset('adminlte/img/logo-bmine.png') }}" alt="B'mine Logo"
                                class="w-32 h-auto mx-auto mt-6 animate-float" style="animation-delay: 1s">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Content -->
            <div class="p-12 flex flex-col justify-center">
                <h1 class="text-4xl font-bold mb-4 text-gray-800">Page Not Found</h1>
                <p class="text-lg text-gray-600 mb-8">We can't seem to find the page you're looking for. It might have
                    been moved or doesn't exist.</p>

                <!-- Features -->
                <div class="space-y-3 mb-8">
                    <div class="flex items-start">
                        <div class="rounded-full p-2 bg-bmine-green/10 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-bmine-green" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Check the URL</h3>
                            <p class="text-sm text-gray-600">Verify that the URL you entered is correct.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="rounded-full p-2 bg-bmine-orange/10 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-bmine-orange" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Try Navigation</h3>
                            <p class="text-sm text-gray-600">Use the navigation menu to find what you need.</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ url('/') }}"
                        class="px-6 py-3 bg-bmine-green hover:bg-bmine-green/90 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg shadow-bmine-green/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Home Page
                    </a>
                    <button onclick="window.history.back()"
                        class="px-6 py-3 bg-white border-2 border-bmine-orange hover:bg-bmine-orange/5 text-bmine-orange font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Go Back
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-4 px-6 text-center bg-gray-50 text-gray-600 text-sm border-t border-gray-100">
            &copy; {{ date('Y') }} B'mine. All rights reserved.
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-0 right-0 w-64 h-64 bg-bmine-orange/5 rounded-bl-full -z-10"></div>
    <div class="fixed bottom-0 left-0 w-64 h-64 bg-bmine-green/5 rounded-tr-full -z-10"></div>
</body>

</html>

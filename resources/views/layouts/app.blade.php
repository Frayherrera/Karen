<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Curiosidades Rochy') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <!-- Playfair Display adds an elegant touch -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Icons and Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-a8f1WEm69cxQo3IRa+wewDr97UvpDN5Em/sWDnleLgKP97aqKByGQA41bIk/aBrA6FgOJr1TRftIA+U66bI2DQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #fdf2f8 0%, #fff 100%);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .page-title {
            font-family: 'Dancing Script', cursive;
        }
        
        .content-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(244, 114, 182, 0.2);
            transition: all 0.3s ease;
        }
        
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 114, 182, 0.15);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #fdf2f8;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #f472b6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ec4899;
        }

        /* Animated background */
        .animated-bg {
            background: linear-gradient(-45deg, #fdf2f8, #fce7f3, #fbcfe8, #f9a8d4);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen animated-bg">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white/80 shadow-sm backdrop-blur-sm border-b border-pink-100">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="page-title text-3xl text-pink-600 transition-all duration-300 hover:text-pink-700">
                        @yield('header')
                    </div>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="content-card rounded-2xl shadow-lg p-6 sm:p-8">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Optional Footer -->
        <footer class="bg-white/80 border-t border-pink-100 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-pink-600">
                <p class="text-sm">© {{ date('Y') }} Curiosidades Rochy. Con 💖 para ti.</p>
            </div>
        </footer>
    </div>

    <!-- SweetAlert2 Custom Styling -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#fdf2f8',
            color: '#db2777',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
</body>
</html>
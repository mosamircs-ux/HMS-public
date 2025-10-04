<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hospital Management System') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    {{-- 
    MIGRATION NOTE: CodeIgniter Views
    
    CodeIgniter (Original):
    <?php $this->load->view('layout/header'); ?>
    <div class="content">
        <?php echo $content; ?>
    </div>
    <?php $this->load->view('layout/footer'); ?>
    
    Laravel Blade (Converted):
    - Uses master layout with @yield and @section
    - Includes use @include directive
    - Variables printed with {{ }} (auto-escaped)
    - Raw HTML with {!! !!} (unescaped)
    --}}

    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Main Content -->
    <main class="py-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>

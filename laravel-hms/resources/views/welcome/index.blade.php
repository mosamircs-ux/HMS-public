@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
{{-- 
MIGRATION NOTE: CodeIgniter to Blade Template

CodeIgniter (Original):
<h1><?php echo $hospital_name; ?></h1>
<?php if ($page['description'] != ""): ?>
    <?php echo $page['description']; ?>
<?php endif; ?>

Laravel Blade (Converted):
- Uses @extends for layout inheritance
- @section defines content blocks
- {{ }} for escaped output
- @if, @foreach, @while for control structures
--}}

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $hospitalName }}</h1>
            <p class="lead">{{ $message }}</p>

            {{-- Blade Directives Examples --}}
            @if(isset($page) && $page->description)
                <div class="description">
                    {!! $page->description !!}
                </div>
            @endif

            {{-- Laravel's @auth directive (replaces CI session checks) --}}
            @auth
                <p>Welcome back, {{ auth()->user()->name }}!</p>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('appointment.form') }}" class="btn btn-success">Book Appointment</a>
            @endauth

            {{-- Example of looping (if you had data) --}}
            @if(isset($services))
                <h2>Our Services</h2>
                <ul>
                    @foreach($services as $service)
                        <li>{{ $service->name }} - {{ $service->description }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // CodeIgniter: Inline scripts or loaded separately
        // Laravel: Use @push to add scripts to specific sections
        console.log('Welcome page loaded');
    </script>
@endpush

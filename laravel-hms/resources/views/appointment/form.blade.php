@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Book an Appointment</h1>

            {{-- Display success message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 
            MIGRATION NOTE: CodeIgniter Form to Laravel Form
            
            CodeIgniter:
            <?php echo form_open('welcome/appointment'); ?>
            <?php echo form_error('doctor'); ?>
            <input type="text" name="doctor" value="<?php echo set_value('doctor'); ?>">
            <?php echo form_close(); ?>
            
            Laravel Blade:
            - @csrf for security
            - old() to preserve input
            - @error directive for validation errors
            - route() helper for action URL
            --}}

            <form action="{{ route('appointment.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="specialist">Specialist</label>
                    <select name="specialist" id="specialist" class="form-control @error('specialist') is-invalid @enderror">
                        <option value="">Select Specialist</option>
                        <option value="cardiology" {{ old('specialist') == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                        <option value="neurology" {{ old('specialist') == 'neurology' ? 'selected' : '' }}>Neurology</option>
                        <option value="pediatrics" {{ old('specialist') == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                    </select>
                    @error('specialist')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="doctor">Doctor</label>
                    <select name="doctor" id="doctor" class="form-control @error('doctor') is-invalid @enderror">
                        <option value="">Select Doctor</option>
                        <option value="1">Dr. John Smith</option>
                        <option value="2">Dr. Sarah Johnson</option>
                    </select>
                    @error('doctor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date">Appointment Date</label>
                    <input type="date" name="date" id="date" 
                           class="form-control @error('date') is-invalid @enderror" 
                           value="{{ old('date') }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="shift">Shift</label>
                    <select name="shift" id="shift" class="form-control @error('shift') is-invalid @enderror">
                        <option value="">Select Shift</option>
                        <option value="morning" {{ old('shift') == 'morning' ? 'selected' : '' }}>Morning</option>
                        <option value="afternoon" {{ old('shift') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                        <option value="evening" {{ old('shift') == 'evening' ? 'selected' : '' }}>Evening</option>
                    </select>
                    @error('shift')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slot">Time Slot</label>
                    <input type="text" name="slot" id="slot" 
                           class="form-control @error('slot') is-invalid @enderror" 
                           placeholder="e.g., 10:00 AM" 
                           value="{{ old('slot') }}">
                    @error('slot')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" rows="4" 
                              class="form-control @error('message') is-invalid @enderror" 
                              placeholder="Please describe your symptoms">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Book Appointment</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-group {
        margin-bottom: 1rem;
    }
</style>
@endpush

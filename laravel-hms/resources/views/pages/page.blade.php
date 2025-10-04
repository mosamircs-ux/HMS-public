@extends('layouts.app')

@section('title', 'Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Page: {{ $slug }}</h1>
            <p>This is a sample page view.</p>
            
            {{-- In actual implementation, you would display page content here --}}
            {{-- @if(isset($page))
                <h2>{{ $page->title }}</h2>
                <div class="content">
                    {!! $page->content !!}
                </div>
            @endif --}}
        </div>
    </div>
</div>
@endsection

<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

<div class="welcome-banner text-center" >
    <!-- Add banner content here -->
    <img src="/img/mp3shop-logo.png" alt="mp3 shop logo">

    <div>
        Brows from the most iconic songs of your time.
    </div>

</div>
<div class="text-center">
    <a href="{{ route('home') }}" class="btn btn-primary">Check Songs</a>
</div>
@endsection

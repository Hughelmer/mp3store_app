<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')
<div class="welcome-banner text-center" >
    <!-- Add banner content here -->
    <img src="/img/mp3shop-logo.png" alt="mp3 shop logo">

    <div>
        Brows from the most iconic songs of your time.
    </div>



</div>
<a href="{{ route('home') }}" class="btn btn-primary">Check Songs</a>
@endsection

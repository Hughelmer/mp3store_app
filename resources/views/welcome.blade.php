@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

<div class="welcome-banner text-center" >
    <img src="/img/mp3shop-logo.png" alt="mp3 shop logo">

    <div class="title m-b-md">
        Brows from the most iconic songs of your time.
    </div>

</div>
<div class="text-center">
    <a href="{{ route('home') }}" class="btn btn-primary">Check Albums</a>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="app">
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
    
    
@endsection
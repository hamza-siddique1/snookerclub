@extends('layouts.app')

@section('content')
<div id="app">
    <player-rankings-manager></player-rankings-manager>
</div>

<script src="{{ mix('js/app.js') }}?t={{ time() }}"></script>

@endsection

@extends('layouts.app')

@section('content')
<div id="app">
    <ranking></ranking>
</div>

<script src="{{ mix('js/app.js') }}?t={{ time() }}"></script>

@endsection

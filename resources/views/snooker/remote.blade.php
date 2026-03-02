@extends('layouts.app')

@section('content')

<div id="app">
    <snooker-remote :match="{{ json_encode($match) }}"></snooker-remote-control>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

@endsection

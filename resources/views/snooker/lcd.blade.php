@extends('layouts.app')

@section('content')

<div id="app">
    <snooker-lcd :match="{{ json_encode($match) }}"></snooker-lcd>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

@endsection

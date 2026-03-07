@extends('layouts.app')

@section('title', __('Matches'))

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#matches-table').DataTable({
                order: [[5, 'desc']],
            });
        });

        function copyLinkToClipboard(url) {
            navigator.clipboard.writeText(url).then(() => {
            }).catch(() => {
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
        }
    </script>
@endsection

@section('content')
    <h1 class="h3 mb-3">{{ __('All Matches') }}</h1>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="matches-table" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ 'ID' }}</th>
                            <th>{{ 'Player 1' }}</th>
                            <th>{{ 'Player 2' }}</th>
                            <th>{{ 'Remote Link' }}</th>
                            <th>{{ 'LCD Link' }}</th>
                            <th>{{ 'Created at' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matches as $match)
                            <tr>

                                <td>{{ $match->id }}</td>

                                <td>{{ $match->player_1_id ? get_player_name($match->player_1_id) : $match->player_1_name }} </td>

                                <td>{{ $match->player_2_id ? get_player_name($match->player_2_id) : $match->player_2_name }} </td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        onclick="copyLinkToClipboard('{{ route('snooker.remote', $match->slug) }}')"
                                        title="Click to copy remote control link"
                                    >
                                        <i class="fa fa-link"></i> Copy Remote
                                    </button>
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-info"
                                        onclick="copyLinkToClipboard('{{ route('snooker.lcd', $match->slug) }}')"
                                        title="Click to copy LCD display link"
                                    >
                                        <i class="fa fa-link"></i> Copy LCD
                                    </button>
                                </td>

                                <td data-sort="{{ strtotime($match->created_at) }}"
                                    title="{{ $match->created_at }}">{{ $match->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

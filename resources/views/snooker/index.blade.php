@extends('layouts.app')

@section('title', __('Matches'))

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#matches-table').DataTable({
                order: [[8, 'desc']],
            });
        });
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
                    <div class="dt-buttons btn-group flex-wrap">

                    </div>

                    @if(session('delete'))
                        <x-alert type="danger">{{ session('delete') }}</x-alert>
                    @elseif(session('password_update'))
                        <x-alert type="success">{{ session('password_update') }}</x-alert>
                    @elseif(session('account'))
                        <x-alert type="success">{{ session('account') }}</x-alert>
                    @endif


                    <table id="matches-table" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ 'ID' }}</th>
                            <th>{{ 'Tournament' }}</th>
                            <th>{{ 'Player 1' }}</th>
                            <th>{{ 'Player 2' }}</th>
                            <th>{{ 'Year' }}</th>
                            <th>{{ 'Rules' }}</th>
                            <th>{{ 'Round' }}</th>
                            <th>{{ 'Winner' }}</th>
                            <th>{{ 'Created at' }}</th>
                            <th>{{ 'Action' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matches as $match)
                            <tr>

                                <td>{{ $match->id }}</td>
                                <td>
                                    {{ $match->tournament }}
                                </td>
                                <td>{{ get_player_name($match->player_1) }} </td>

                                <td>{{ get_player_name($match->player_2) }}</td>

                                <td>{{ isset($match->year) ? $match->year->format('Y') : '-' }}</td>

                                <td>{{ $match->rules }}</td>

                                <td>{{ $match->round }}</td>

                                <td>{{ get_player_name($match->winner) }}</td>

                                <td data-sort="{{ strtotime($match->created_at) }}"
                                    title="{{ $match->created_at }}">{{ $match->created_at->diffForHumans() }}</td>
                                <td class="table-action">

                                    <a href="{{ route('matches.edit', $match->id) }}" class="btn"
                                       style="display: inline">
                                        <i class="fa fa-edit text-info"></i>
                                    </a>

                                    <form method="post" action="{{ route('matches.destroy', $match->id) }}"
                                          onsubmit="return confirmSubmission(this, 'Are you sure?' + '{{ "$match->name"  }}')"
                                          style="display: inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn text-danger"
                                                href="{{ route('matches.destroy', $match->id) }}">
                                            <i class="fa fa-trash"></i>

                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

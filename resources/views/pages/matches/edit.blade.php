@extends('layouts.app')

@section('title', 'Edit Match')

@php
    $player1 = $match->player1->name ?? 'TBD';
    $player2 = $match->player2->name ?? 'TBD';
    $year = $match->year ?? now();
@endphp

@section('scripts')
    <script>
        $(document).ready(function() {

            $(".daterange").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                startDate: '{!! $year !!}',
                locale: {
                    format: "Y-MM-DD HH:mm:ss"
                }
            });

        });
    </script>
@endsection


@section('content')

    <h1 class="h3 mb-3">Edit Match</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <x-alert type="success">{{ session('success') }}</x-alert>
                    @endif

                    @if (session('error'))
                        <x-alert type="danger">{{ session('error') }}</x-alert>
                    @endif


                    <form method="POST" action="{{ route('matches.update', $match->id) }}">
                        @csrf
                        @method('PUT')


                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Tournament</label>

                                    <input class="form-control form-control-lg" type="text"
                                        value="{{ $match->tournament->title }}" disabled />

                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">

                                    <label>Year</label>

                                    <input name="year" disabled class="form-control form-control-lg" type="text"
                                        value="{{ $match->tournament->year }}" />

                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-sm">
                                <div class="form-group">

                                    <label>Player 1</label>

                                    <input class="form-control form-control-lg" type="text" value="{{ $player1 }}"
                                        disabled />

                                </div>
                            </div>


                            <div class="col-sm">
                                <div class="form-group">

                                    <label>Player 2</label>

                                    <input class="form-control form-control-lg" type="text" value="{{ $player2 }}"
                                        disabled />

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Rules</label>

                                    <input class="form-control form-control-lg" type="text"
                                        value="{{ $match->tournament->rules }}" disabled />

                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">

                                    <label>Round</label>

                                    <input class="form-control form-control-lg" type="text" name="round"
                                        value="{{ $match->round }}" />

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Score Player 1</label>

                                    <input class="form-control form-control-lg" type="number" name="score_player_1"
                                        value="{{ $match->score_player_1 }}" />

                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">

                                    <label>Score Player 2</label>

                                    <input class="form-control form-control-lg" type="number" name="score_player_2"
                                        value="{{ $match->score_player_2 }}" />

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Break & Run Player 1</label>

                                    <input class="form-control form-control-lg" type="number" name="break_and_run_player_1"
                                        value="{{ $match->break_run_player_1 }}" />

                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">

                                    <label>Break & Run Player 2</label>

                                    <input class="form-control form-control-lg" type="number" name="break_and_run_player_2"
                                        value="{{ $match->break_run_player_2 }}" />

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Winner</label>

                                    <select name="winner_id" class="form-control select2">

                                        <option value="">Select Winner</option>

                                        @if ($match->player1)
                                            <option value="{{ $match->player1->id }}"
                                                @if ($match->winner_id == $match->player1->id) selected @endif>
                                                {{ $player1 }}
                                            </option>
                                        @endif

                                        @if ($match->player2)
                                            <option value="{{ $match->player2->id }}"
                                                @if ($match->winner_id == $match->player2->id) selected @endif>
                                                {{ $player2 }}
                                            </option>
                                        @endif

                                    </select>

                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">

                                    <label>Status</label>

                                    <select name="status" class="form-control select2">

                                        @foreach (App\Models\Tournament::ACTIONS as $key => $value)
                                            <option value="{{ $key }}"
                                                @if ($match->status == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">

                                    <label>Table #</label>

                                    <input class="form-control form-control-lg" type="number" name="table"
                                        value="{{ $match->table }}" />

                                </div>
                            </div>

                        </div>



                        <div class="form-group">

                            <button type="submit" class="btn btn-lg btn-primary">
                                Update Match
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

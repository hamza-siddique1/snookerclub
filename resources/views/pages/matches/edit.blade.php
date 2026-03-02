@extends('layouts.app')

@section('title', 'Add Match')

@php
$player1 = get_player_name($match->player_1 );
$player2 = get_player_name($match->player_2 );
$year = isset($match->year) ? $match->year : now();
@endphp
@section('scripts')
    <script>

        $(document).ready(function () {

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

    <h1 class="h3 mb-3">Edit Match </h1>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if(session('success'))
                        <x-alert type="success">{{ session('success') }}</x-alert>
                    @endif
                    @if(session('error'))
                        <x-alert type="danger">{{ session('error') }}</x-alert>
                    @endif
                    @if(session('warning'))
                        <x-alert type="warning">{{ session('warning') }}</x-alert>
                    @endif

                    <form method="post" action="{{ route('matches.update', $match->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tournament">Tournament</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        value="{{ $match->tournament }}"
                                        disabled
                                    />
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="year">Year</label>

                                    <input
                                        name="year"
                                        class="form-control form-control-lg daterange"
                                        type="text"
                                        value="{{ $match->year }}"
                                    />

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="form-label" for="players"> Player 1 </label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        value="{{ get_player_name($match->player_1 ) }}"
                                        disabled
                                    />
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="form-label" for="players"> Player 2 </label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        value="{{ get_player_name($match->player_2 ) }}"
                                        disabled
                                    />
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="rules">Rules</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        value="{{ $match->rules }}"
                                        disabled
                                    />
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="rounds">Rounds</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="round"
                                        placeholder="Enter round"
                                        value="{{ $match->round }}"
                                    />
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="result">Score player 1</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="score_player_1"
                                        value="{{ $match->score_player_1 }}"
                                        placeholder="Enter Score"
                                    />
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="result">Score player 2</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="score_player_2"
                                        value="{{ $match->score_player_2 }}"
                                        placeholder="Enter Score"
                                    />
                                </div>

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="result">Break & Run player 1</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="break_and_run_player_1"
                                        value="{{ $match->break_run_player_1 }}"
                                        placeholder="Enter Break & Run"
                                    />
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="result">Break & Run player 2</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="break_and_run_player_2"
                                        value="{{ $match->break_run_player_2 }}"
                                        placeholder="Enter Break & Run"
                                    />
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="winner">Winner</label>
                                    <select name="winner" id="winner"
                                            class="form-control form-select custom-select select2"
                                            data-toggle="select2">
                                        <option value="-100" selected> Select Winner</option>
                                        <option value="{{ $match->player_1 }}"
                                                @if($match->winner == $match->player_1) selected @endif> {{ $player1 }}</option>
                                        <option value="{{ $match->player_2 }}"
                                                @if($match->winner == $match->player_2) selected @endif> {{ $player2 }}</option>

                                    </select>
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status"
                                            class="form-control form-select custom-select select2"
                                            data-toggle="select2">
                                        <option value="-100"> Select Status</option>
                                        @foreach(App\Models\Tournament::ACTIONS as $key => $value)
                                            <option value="{{ $key }}" @if($match->status == $key) selected @endif> {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="result">Table #</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="table"
                                        value="{{ $match->table }}"
                                        placeholder="Table #"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="add" class="btn btn-lg btn-primary">
                                Update
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

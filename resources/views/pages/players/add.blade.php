@extends('layouts.app')

@section('title', 'Add Player')

@section('scripts')
    <script>
        $(document).ready(function () {

            $(".daterange").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: moment(),
                locale: {
                    format: "Y-MM-DD"
                }
            });

        });

    </script>

@endsection
@section('content')

    <h1 class="h3 mb-3">Add New Player </h1>

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

                    <form method="post" action="{{ route('admin.players.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">Name</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="name"
                                        placeholder="Enter player name"
                                    />
                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">DOB</label>

                                    <input
                                        class="form-control form-control-lg daterange"
                                        type="text"
                                        name="dob"
                                    />

                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">Birth Place</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="birth_place"
                                        placeholder="Enter birth place"
                                    />

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">Residence</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="residence"
                                        placeholder="Enter player residence"
                                    />
                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="plays_with">Plays with</label>
                                    <select name="plays_with" id="plays_with"
                                            class="form-control form-select">
                                        <option value="Right-handed" selected> Right handed</option>
                                        <option value="Left-handed"> Left handed</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">Professional since</label>

                                    <input
                                        class="form-control form-control-lg daterange"
                                        type="text"
                                        name="professional_since"
                                    />

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="titles">Titles</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="titles"
                                        placeholder="Enter Titles"
                                    />
                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="earnings">Total Earnings($)</label>

                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="earnings"
                                        placeholder="7800"
                                    />

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="cue">Cue</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="cue"
                                        placeholder="Cue"
                                    />
                                </div>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="earnings">Cue Link</label>

                                    <input
                                        class="form-control form-control-lg"
                                        type="url"
                                        name="cue_link"
                                        placeholder="Cue Link"
                                    />

                                </div>

                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="image">Profile photo</label>
                                    <input
                                        type="file"
                                        name="image1"
                                    />
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="image">Passport size photo</label>
                                    <input
                                        type="file"
                                        name="image2"
                                    />
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="add" class="btn btn-lg btn-primary">Add New
                                Player
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>





@endsection

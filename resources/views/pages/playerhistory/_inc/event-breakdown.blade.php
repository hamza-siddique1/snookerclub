<div class="row">
    <div class="col-sm-12">
        <h1 class="h3 mb-3">Event Breakdown</h1>
        <div class="card">
            <div class="card-body">
                <div class="dt-buttons btn-group flex-wrap">
                    <table id="users-table" class="table table-striped table-responsive-sm" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ 'Year' }}</th>
                            <th>{{ 'Event' }}</th>
                            <th>{{ 'Type' }}</th>
                            <th>{{ 'Round' }}</th>
                            <th>{{ 'Winner' }}</th>
                            <th>{{ 'Score' }}</th>
                            <th>{{ 'Status' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($matches) > 0)
                            @foreach($matches as $match)
                                <tr>
                                    <td>{{ $match->tournament->year }}</td>
                                    <td>{{ $match->tournament->title }}</td>
                                    <td>{{ $match->tournament->type }}</td>
                                    <td>
                                        @if($match->round == 1)
                                            Quarter-finals
                                        @elseif($match->round == 2)
                                            Semi-finals
                                        @elseif($match->round == 3)
                                            Final
                                        @endif
                                    </td>
                                    <td>
                                        @if($match->winner_id)
                                            <span class="badge badge-{{ $match->winner_id == $player2->id ? 'primary' : 'warning' }}">
                                                {{ $match->winner->name ?? 'N/A' }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $match->score_player_1 ?? 0 }} - {{ $match->score_player_2 ?? 0 }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $match->status == 'completed' ? 'success' : ($match->status == 'running' ? 'info' : 'warning') }}">
                                            {{ ucfirst($match->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No matches found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

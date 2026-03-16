
@if($allMatches->count() > 0)
    <div class="overflow-x-auto px-4">
        <table class="w-full text-[16px] border-separate border-spacing-y-1">
            <thead class="">
                <tr class="text-[12px] uppercase tracking-wider text-zinc-500">
                    <th class="py-3 pr-2 text-center font-medium whitespace-nowrap">No.</th>
                    <th class="py-3 px-2 text-left font-medium whitespace-nowrap">Date</th>
                    <th class="py-3 px-2 text-center font-medium whitespace-nowrap">Venue</th>
                    <th class="py-3 px-2 text-left font-medium text-right whitespace-nowrap">For</th>
                    <th class="py-3 px-2 text-center font-medium whitespace-nowrap">Result</th>
                    <th class="py-3 px-2 text-left font-medium whitespace-nowrap">Against</th>
                    <th class="py-3 px-2 text-center font-medium whitespace-nowrap">Break & Run</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allMatches->sortByDesc('created_at') as $index => $match)
                    @php
                        $isPlayer1 = $match->player1_id == $player->id;
                        $playerScore = $isPlayer1 ? $match->score_player_1 : $match->score_player_2;
                        $opponentScore = $isPlayer1 ? $match->score_player_2 : $match->score_player_1;
                        $opponent = $isPlayer1 ? $match->player2 : $match->player1;
                        $breakAndRun = $isPlayer1 ? $match->break_run_player_1 : $match->break_run_player_2;
                        $isWin = $match->winner_id == $player->id;
                        $venue = $match->table ?? '1';
                    @endphp
                    <tr class="border-b border-zinc-800/30 transition-colors rounded-lg mb-2 bg-white/10 hover:bg-white/20">
                        <!-- Match Number -->
                        <td class="py-3 pr-2 text-amber-400 font-bold text-center border-l-2 {{ $isWin ? 'border-emerald-500' : 'border-red-500' }} whitespace-nowrap">
                            {{ $index + 1 }}
                        </td>

                        <!-- Date -->
                        <td class="py-3 px-2 text-zinc-400 whitespace-nowrap text-[14px]">
                            {{ $match->created_at->format('M d, Y') }}
                        </td>

                        <!-- Venue/Table -->
                        <td class="py-3 px-2 text-center text-zinc-400 text-[14px] whitespace-nowrap">
                            {{ $venue }}
                        </td>

                        <!-- Player Name (For) -->
                        <td class="py-3 px-2 pr-0 text-right whitespace-nowrap">
                            <div class="flex items-center gap-2 justify-end">
                                <span class="text-zinc-200 font-medium text-[14px]">{{ $player->name }}</span>
                                @if($player->image1)
                                    <img alt="{{ $player->name }}" class="w-5 h-5 shrink-0 object-contain rounded-full" src="{{ asset('players/' . $player->image1) }}">
                                @else
                                    <div class="w-5 h-5 shrink-0 bg-zinc-600 rounded-full"></div>
                                @endif
                            </div>
                        </td>

                        <!-- Score Result -->
                        <td class="py-3 px-2 text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <span class="text-zinc-100 font-semibold text-[14px] {{ $isWin ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $playerScore ?? '-' }} : {{ $opponentScore ?? '-' }}
                                </span>
                            </div>
                        </td>

                        <!-- Opponent Name (Against) -->
                        <td class="py-3 px-2 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($opponent && $opponent->image1)
                                    <img alt="{{ $opponent->name }}" class="w-5 h-5 shrink-0 object-contain rounded-full" src="{{ asset('players/' . $opponent->image1) }}">
                                @else
                                    <div class="w-5 h-5 shrink-0 bg-zinc-600 rounded-full"></div>
                                @endif
                                <span class="text-zinc-300 text-[14px]">{{ $opponent->name ?? 'Unknown' }}</span>
                            </div>
                        </td>

                        <!-- Break and Run -->
                        <td class="py-3 px-2 text-center text-zinc-200 text-[14px] whitespace-nowrap">
                            {{ $breakAndRun ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-8">
        <p class="text-zinc-400">No matches found</p>
    </div>
@endif


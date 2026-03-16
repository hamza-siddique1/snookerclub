<!-- Basic Info -->
<div class="space-y-2 sm:space-y-3 max-w-md mb-6 sm:mb-8">

    <!-- Birth Place -->
    <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
        <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">BIRTH PLACE</span>
        <span class="text-[16px] text-zinc-200">{{ $player->birth_place ?? 'N/A' }}</span>
    </div>

    <!-- Date of Birth -->
    <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
        <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">BIRTHDATE</span>
        <span class="text-[16px] text-zinc-200">{{ $player->dob->format('M d, Y') }}</span>
    </div>

    <!-- Residence -->
    @if($player->residence)
        <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
            <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">RESIDENCE</span>
            <span class="text-[16px] text-zinc-200">{{ $player->residence }}</span>
        </div>
    @endif

    <!-- Plays With -->
    @if($player->plays_with)
        <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
            <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">PLAYS WITH</span>
            <span class="text-[16px] text-zinc-200">{{ $player->plays_with }}</span>
        </div>
    @endif

    <!-- Professional Since -->
    @if($player->professional_since)
        <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
            <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">PROFESSIONAL SINCE</span>
            <span class="text-[16px] text-zinc-200">{{ $player->professional_since }}</span>
        </div>
    @endif

    <!-- Highest Break -->
    <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
        <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">HIGHEST BREAK</span>
        <span class="text-[16px] text-zinc-200">{{ $highestBreak ?? $player->highest_break ?? 'N/A' }}</span>
    </div>

    <!-- Win/Loss Record -->
    <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
        <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">RECORD</span>
        <span class="text-[16px] text-zinc-200">{{ $wins }} Wins / {{ $losses }} Losses</span>
    </div>

    <!-- Win Percentage -->
    <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
        <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">WIN %</span>
        <span class="text-[16px] text-zinc-200">{{ number_format($winPercentage, 2) }}%</span>
    </div>

    <!-- Titles -->
    @if($player->titles)
        <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
            <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">TITLES</span>
            <span class="text-[16px] text-zinc-200">{{ $player->titles }}</span>
        </div>
    @endif

    <!-- Cue -->
    @if($player->cue)
        <div class="flex flex-col sm:flex-row sm:items-baseline gap-0.5 sm:gap-4">
            <span class="text-[14px] tracking-widest text-zinc-500 uppercase sm:w-36 shrink-0">CUE</span>
            <span class="text-[16px] text-zinc-200">
                @if($player->cue_link)
                    <a href="{{ $player->cue_link }}" target="_blank" class="text-blue-400 hover:underline">{{ $player->cue }}</a>
                @else
                    {{ $player->cue }}
                @endif
            </span>
        </div>
    @endif

</div>

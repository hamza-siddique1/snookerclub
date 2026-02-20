<section class="section4">
    <table class="table1">
        <tr>
            <td class="darkerwhite"> {{ date('Y') - $player1->dob->format('Y') }} ( {{ $player1->dob->format('Y-m-d') }}) </td>
            <td class="darkred">AGE</td>
            <td class="darkerwhite">  {{ date('Y') - $player2->dob->format('Y') }} ( {{ $player2->dob->format('Y-m-d') }})
            </td>
        </tr>
        <tr>
            <td class="darkwhite"> {{ $player1->birth_place }} </td>
            <td class="darkerred">BIRTHPLACE</td>
            <td class="darkwhite"> {{ $player2->birth_place }} </td>
        </tr>
        <tr>
            <td class="darkerwhite"> {{ $player1->residence }} </td>
            <td class="darkred">RESIDENCE</td>
            <td class="darkerwhite"> {{ $player2->residence }} </td>
        </tr>
        <tr>
            <td class="darkwhite"> {{ $player1->plays_with }} </td>
            <td class="darkerred">PLAYS</td>
            <td class="darkwhite"> {{ $player2->plays_with }} </td>
        </tr>
        <tr>
            <td class="darkerwhite"> {{ $player1->professional_since }} </td>
            <td class="darkred">PROFFESIONAL SINCE</td>
            <td class="darkerwhite"> {{ $player2->professional_since }} </td>
        </tr>

        @if( isset(request()->type) && request()->type == 'snooker')
            <tr>
                <td class="darkwhite"> {{ $player1->highest_break }} </td>
                <td class="darkerred">HIGHEST BREAK</td>
                <td class="darkwhite"> {{ $player2->highest_break }} </td>
            </tr>
        @else
            <tr>
                <td class="darkwhite"> {{ $player1_break_and_run }} </td>
                <td class="darkerred">BREAK and RUN</td>
                <td class="darkwhite"> {{ $player2_break_and_run }} </td>
            </tr>
        @endif

        <tr>
            <td class="darkerwhite">{{ $player1_win_loss_ratio }}</td>
            <td class="darkred">WON/LOST</td>
            <td class="darkerwhite"> {{ $player2_win_loss_ratio }}</td>
        </tr>

        <tr>
            <td class="darkwhite"> {{ $player1->earnings }} MAD </td>
            <td class="darkerred">TOTAL EARNINGS</td>
            <td class="darkwhite"> {{ $player2->earnings }} MAD</td>
        </tr>
        <tr>
            <td class="darkerwhite"> {{ $player1->titles }} </td>
            <td class="darkred">TITLES</td>
            <td class="darkerwhite"> {{ $player2->titles }} </td>
        </tr>
        <tr>
            <td class="darkerwhite">
                <a href="{{ $player1->cue_link }}" target="_blank">
                    {{ $player1->cue }}
                </a>
            </td>

            <td class="darkred">Cue</td>

            <td class="darkerwhite">
                <a href="{{ $player2->cue_link }}" target="_blank">
                    {{ $player2->cue }}
                </a>
            </td>
        </tr>
    </table>
</section>

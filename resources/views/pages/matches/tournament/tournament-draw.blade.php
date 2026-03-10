<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <title>SnookernPool</title>
    <meta name="viewport" content="https://width=device-width, initial-scale=1, minimal-ui">


    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity_core.631e6bb.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity_themes.24b5e8e.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity_header.1733c06.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity_draw.1efa927.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity_tournament_table.6ead18d.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/draw/identity-final-style.css') }}" media="all">
</head>



<body id="top" class="responsive tennis detailbody detailTableDraw flat pid_2 _fs theme--dark"
    data-new-gr-c-s-check-loaded="14.1080.0" data-gr-ext-installed="" cz-shortcut-listen="true"
    style="font-family: Arial,sans-serif;">


    <div id="detail" class="sport-tennis">
        <div class="header__brand">
            <a class="header__logo logo--mobile snookernpool-com-white" href="#" target="_blank">
                <img src="https://snookernpool.com/assets/front/images/logo.png" alt="Snookernpool"
                    style="padding:8px;">
            </a>
        </div>
        <div id="sportstats">
            <div class="inner">
                <div id="season_url" style="display: none">2022</div>
                <link type="text/css" rel="stylesheet"
                    href="{{ asset('assets/front/css/draw/identity_dropdown.3215335.css') }}" media="all">

                <div id="tournament-table" class="tournament-table-draw">
                    <div class="tournamentHeader tournamentHeaderDescription">
                        <div class="tournamentHeader__sportContent "><span class="tournamentHeader__flagIcon"><span
                                    class=" flag fl_3473162" title=""></span><i
                                    class="fa-solid fa-user"></i></span><span
                                class="tournamentHeader__country">{{ $tournament_title ?? '-' }}</span>
                        </div>
                        <div class="dropDown dropDown--tableDraw">
                            <div class="dropDown__selectedValue " tabindex="0">
                                {{ $first_tournament?->year->format('Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div>
                        <div id="box-over-content-standings" class="boxOverContent--standings">
                            <style>
                                #box_over_content_11568 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11570 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11571 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11572 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11574 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11575 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11579 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11580 {
                                    --color-boxOverContent-1: #0C304C;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #00E4F3;
                                    --color-boxOverContent-4: #0C304C;
                                    --color-boxOverContent-5: #FFFFFF;
                                    --width-boxOverContent-logo: 74px;
                                }
                            </style>

                            <style>
                                #box_over_content_11582 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11584 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11585 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11587 {
                                    --color-boxOverContent-1: #0D7C43;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #47DE41;
                                    --color-boxOverContent-4: #0D7C43;
                                    --color-boxOverContent-5: #FFFFFF;
                                    --width-boxOverContent-logo: 83px;
                                }
                            </style>

                            <style>
                                #box_over_content_11588 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11589 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11590 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11592 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11594 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_11645 {
                                    --color-boxOverContent-1: #008357;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFE01B;
                                    --color-boxOverContent-4: #008357;
                                    --color-boxOverContent-5: #FFE01B;
                                    --width-boxOverContent-logo: 81px;
                                }
                            </style>

                            <style>
                                #box_over_content_12510 {
                                    --color-boxOverContent-1: #009BE5;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #FFCC00;
                                    --color-boxOverContent-4: #009BE5;
                                    --color-boxOverContent-5: #FFFFFF;
                                    --width-boxOverContent-logo: 104px;
                                }
                            </style>

                            <style>
                                #box_over_content_12518 {
                                    --color-boxOverContent-1: #0D7C43;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #47DE41;
                                    --color-boxOverContent-4: #0D7C43;
                                    --color-boxOverContent-5: #FFFFFF;
                                    --width-boxOverContent-logo: 83px;
                                }
                            </style>

                            <style>
                                #box_over_content_12522 {
                                    --color-boxOverContent-1: #0D7C43;
                                    --color-boxOverContent-2: #FFFFFF;
                                    --color-boxOverContent-3: #47DE41;
                                    --color-boxOverContent-4: #0D7C43;
                                    --color-boxOverContent-5: #FFFFFF;
                                    --width-boxOverContent-logo: 83px;
                                }
                            </style>

                            <style>
                                #box_over_content_12613 {
                                    --color-boxOverContent-1: #FFFFFF;
                                    --color-boxOverContent-2: #000000;
                                    --color-boxOverContent-3: #00CC2C;
                                    --color-boxOverContent-4: #FFFFFF;
                                    --color-boxOverContent-5: #000000;
                                    --width-boxOverContent-logo: 75px;
                                }
                            </style>

                        </div>
                    </div>
                    <div class="tournamentStages"><a href="#"
                            class="tournamentStage tournamentStage--selected">Draw</a>


                    </div>
                    <div id="tournament-table-tabs-and-content">


                        <div class="subTabs subTabs--mobileResolver"></div>
                        <div class="draw__cover">
                            <div class="draw__container">
                                {{-- <div class="shifter undefined">
                                    <div id="prvStage" class="shifter__stage shifter__stage--previous">
                                        Previous stage</div>
                                    <div id="nextstage" class="shifter__stage shifter__stage--next">Next Stage</div>
                                </div> --}}
                                <div class="draw__wrapper" id="drawWrapper">
                                    <div class="draw__shadowHeader"></div>
                                    <div class="draw__clearHeader"></div>
                                    <div id="draw" class="draw" style="--i:0;">
                                        @include('pages.matches.tournament.rounds.round1')

                                        @include('pages.matches.tournament.rounds.round2')

                                        @if (count($third_round) > 0)
                                            @include('pages.matches.tournament.rounds.round3')
                                        @endif
                                        @if (count($fourth_round) > 0)
                                            @include('pages.matches.tournament.rounds.round4')
                                        @endif
                                        @if (count($fifth_round) > 0)
                                            @include('pages.matches.tournament.rounds.round5')
                                        @endif






                                        {{--                                    <div id="5" class="draw__round "> --}}
                                        {{--                                        <div class="draw__header"> --}}
                                        {{--                                            <div class="draw__arrow draw__arrow--previous"></div> --}}
                                        {{--                                            <div class="draw__label">Quarter-finals</div> --}}
                                        {{--                                            <div class="draw__arrow draw__arrow--next"></div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                        <div class="draw__brackets "> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--odd" style="--zIndex:0;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                        <span class="bracket__name ">Kyrgios N.</span><span --}}
                                        {{--                                                            class="bracket__info">(23)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">2</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                            <span --}}
                                        {{--                                                                class="bracket__name bracket__name--advancing">Khachanov --}}
                                        {{--                                                                K.</span><span class="bracket__info">(27)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--even" style="--zIndex:-1;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                        <span class="bracket__name ">Berrettini M.</span><span --}}
                                        {{--                                                            class="bracket__info">(13)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">0</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                            <span class="bracket__name bracket__name--advancing">Ruud --}}
                                        {{--                                                                C.</span><span class="bracket__info">(5)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--odd" style="--zIndex:-2;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                        <span class="bracket__name ">Sinner J.</span><span --}}
                                        {{--                                                            class="bracket__info">(11)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">2</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                            <span class="bracket__name bracket__name--advancing">Alcaraz --}}
                                        {{--                                                                C.</span><span class="bracket__info">(3)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--even" style="--zIndex:-3;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                        <span class="bracket__name ">Rublev A.</span><span --}}
                                        {{--                                                            class="bracket__info">(9)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">0</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                            <span class="bracket__name bracket__name--advancing">Tiafoe --}}
                                        {{--                                                                F.</span><span class="bracket__info">(22)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                    </div> --}}
                                        {{--                                    <div id="6" class="draw__round "> --}}
                                        {{--                                        <div class="draw__header"> --}}
                                        {{--                                            <div class="draw__arrow draw__arrow--previous"></div> --}}
                                        {{--                                            <div class="draw__label">Semi-finals</div> --}}
                                        {{--                                            <div class="draw__arrow draw__arrow--next"></div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                        <div class="draw__brackets "> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--odd" style="--zIndex:0;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                        <span class="bracket__name ">Khachanov K.</span><span --}}
                                        {{--                                                            class="bracket__info">(27)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">1</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                            <span class="bracket__name bracket__name--advancing">Ruud --}}
                                        {{--                                                                C.</span><span class="bracket__info">(5)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                            <div class="draw__bracket draw__bracket--even" style="--zIndex:-1;"> --}}
                                        {{--                                                <div class="bracket    " title="Click to view a list of matches"> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                            <span class="bracket__name bracket__name--advancing">Alcaraz --}}
                                        {{--                                                                C.</span><span class="bracket__info">(3)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                        <div class="result ">3</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                        <span class="bracket__name ">Tiafoe F.</span><span --}}
                                        {{--                                                            class="bracket__info">(22)</span> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                    <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                        <div class="result ">2</div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                    </div> --}}
                                        {{--                                    <div id="7" class="draw__round draw__round--last"> --}}
                                        {{--                                        <div class="draw__header"> --}}
                                        {{--                                            <div class="draw__arrow draw__arrow--previous"></div> --}}
                                        {{--                                            <div class="draw__label">Final</div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                        <div class="draw__brackets "> --}}
                                        {{--                                            <div class="draw__brackets--final" style="--zIndex:0;"> --}}
                                        {{--                                                <div class="draw__bracket draw__bracket--odd" style="--zIndex:0;"> --}}
                                        {{--                                                    <div class="bracket    " --}}
                                        {{--                                                         title="Click to view a list of matches"> --}}
                                        {{--                                                        <div --}}
                                        {{--                                                            class="bracket__participant bracket__participant--home"> --}}
                                        {{--                                                            <span class="bracket__name ">Ruud C.</span><span --}}
                                        {{--                                                                class="bracket__info">(5)</span> --}}
                                        {{--                                                        </div> --}}
                                        {{--                                                        <div class="bracket__result bracket__result--home"> --}}
                                        {{--                                                            <div class="result ">1</div> --}}
                                        {{--                                                        </div> --}}
                                        {{--                                                        <div --}}
                                        {{--                                                            class="bracket__participant bracket__participant--away"> --}}
                                        {{--                                                                <span --}}
                                        {{--                                                                    class="bracket__name bracket__name--advancing">Alcaraz --}}
                                        {{--                                                                    C.</span><span class="bracket__info">(3)</span> --}}
                                        {{--                                                        </div> --}}
                                        {{--                                                        <div class="bracket__result bracket__result--away"> --}}
                                        {{--                                                            <div class="result ">3</div> --}}
                                        {{--                                                        </div> --}}
                                        {{--                                                    </div> --}}
                                        {{--                                                </div> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}
                                        {{--                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="js/snp-main-fl.js"></script>

</body>



</html>

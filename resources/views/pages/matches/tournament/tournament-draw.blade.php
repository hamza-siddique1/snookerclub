<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <title>SnookernPool</title>
    <meta name="viewport" content="https://width=device-width, initial-scale=1, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">


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

    <div  class="sport-tennis">
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
                    </div>
                    <div class="tournamentStages"><a href="#"
                            class="tournamentStage tournamentStage--selected">Draw</a>
                    </div>
                    <div id="tournament-table-tabs-and-content">
                        <div class="subTabs subTabs--mobileResolver"></div>
                        <div class="draw__cover">
                            <div class="draw__container">

                                <div class="draw__wrapper" id="drawWrapper">
                                    <div class="draw__shadowHeader"></div>
                                    <div class="draw__clearHeader"></div>
                                    <div id="app" class="draw" style="--i:0;">
                                        <bracket
                                            :tournament='@json($tournament_title)'
                                            :level='@json("1")'>
                                        </bracket>

                                        <bracket
                                            :tournament='@json($tournament_title)'
                                            :level='@json("2")'>
                                        </bracket>

                                        <bracket
                                            :tournament='@json($tournament_title)'
                                            :level='@json("3")'>
                                        </bracket>
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}?time={{time()}}"></script>
</body>



</html>

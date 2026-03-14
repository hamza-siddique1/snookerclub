<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/front/css/home/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>SnookernPool</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front') }}/images/logo.jpeg" />
    <style>
        .navbar-brand img {
            width: 75%;
        }

        @media only screen and (max-width: 768px) {

            /* For mobile phones: */
            .navbar-brand img {
                width: 40%;
            }
        }
    </style>
</head>

<body>

    @include('includes.navbar')
    <section class="section1">
        <div class="sec-1-div1">
            <h1 class="sec-1-h1 text-white">NATIONAL MOROCCAN CLUBS CHAMPIONSHIP</h1>
            <a href="https://live.snookernpool.com/calender/" class="sec-1-button text-white">VIEW CALENDER</a>
        </div>
    </section>

    @include('pages.playerhistory-front._inc.filters')

    @include('pages.playerhistory-front._inc.cards_photo')

    @include('pages.playerhistory-front._inc.comparison')



    <section class="section5">
        @if (isset($_REQUEST['type']))
            @include('pages.playerhistory-front._inc.event-breakdown')
        @endif
        @include('pages.playerhistory-front._inc.sponsored')
    </section>

    @include('includes.footer-front')

    <script>
        var gameType = "8-pool";
        // let p1 =  parseInt(document.getElementsByClassName("player1Score")[0].innerText);
        // let p2 =  parseInt(document.getElementsByClassName("player2Score")[0].innerText);
        // let progress = document.getElementById("progress");
        //
        // progress.style.setProperty('--percent', ((p2 / (p1+p2))*100));
        //
        // let p1name = "", p2name = "", gameType = "snooker", url = "";
        function checkRadio(name) {
            gameType = name;
        }
        // function changeState(){
        // url = `${window.location.origin+window.location.pathname}?type=${gameType}&player1=${p1name}&player2=${p2name}`;
        // window.history.pushState({ path: url }, '', url);
        //}

        function changeState_head2head() {
            let p1_name = $('input[name="player1"]').val();
            let p2_name = $('input[name="player2"]').val();

            console.log(p1_name, p2_name, gameType);
            url =
                `${window.location.origin+window.location.pathname}?type=${gameType}&player1=${p1_name}&player2=${p2_name}`;
            window.history.pushState({
                path: url
            }, '', url);
            window.location.reload();
        }

        function setName(name) {
            // let x = document.getElementsByClassName(name)[0].value;
            // if(name === "player1"){
            //     p1name = x;
            // }else{
            //     p2name = x;
            // }
        }
    </script>
    <script src="{{ asset('assets/front/js/home/jquery.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>

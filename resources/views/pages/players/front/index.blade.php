<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,900&amp;display=swap">
    <title>About Us | SnookernPool</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front') }}/images/logo.jpeg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/front/css/about/style.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/front/css/player/style.css') }}" >
</head>


<body data-new-gr-c-s-check-loaded="14.1070.0" data-gr-ext-installed="" cz-shortcut-listen="true">


@include('includes.navbar')

<div class="container">
   <!-- Hero Section -->
        <div class="hero">
            <div class="player-avatar-wrapper">
                <div class="player-avatar">
                    <img src="https://via.placeholder.com/640x480.png/003377?text=eos" alt="Boyd Gislason I">
                </div>
            </div>
            <div class="hero-info">
                <h1>{{ $player->name }}</h1>
                <div class="hero-subtitle">Professional Player</div>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">6</div>
                        <div class="hero-stat-label">Wins</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">1</div>
                        <div class="hero-stat-label">Loss</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">86%</div>
                        <div class="hero-stat-label">Win Rate</div>
                    </div>
                </div>

                <div class="hero-info-grid">
                    <div class="info-item">
                        <div class="info-label">Born</div>
                        <div class="info-value">Aug 25, 1996</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Birth Place</div>
                        <div class="info-value">Cuba</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Residence</div>
                        <div class="info-value">Faroe Islands</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Playing Style</div>
                        <div class="info-value">Right-handed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Stats -->
        <div class="section">
            <div class="section-header">
                <span class="section-icon">📊</span>
                <h2 class="section-title">Performance</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-box-icon">🎯</div>
                    <div class="stat-box-value">7</div>
                    <div class="stat-box-label">Highest Break</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-icon">💰</div>
                    <div class="stat-box-value">$8,634</div>
                    <div class="stat-box-label">Total Earnings</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-icon">🏆</div>
                    <div class="stat-box-value">86%</div>
                    <div class="stat-box-label">Win Rate</div>
                </div>
            </div>
        </div>

        <!-- Career Info -->
        <div class="section">
            <div class="section-header">
                <span class="section-icon">💼</span>
                <h2 class="section-title">Career Information</h2>
            </div>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-label">Professional Since</div>
                    <div class="info-card-value">1990</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Highest Break</div>
                    <div class="info-card-value">7</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Total Wins</div>
                    <div class="info-card-value">6</div>
                </div>
                <div class="info-card">
                    <div class="info-card-label">Total Losses</div>
                    <div class="info-card-value">1</div>
                </div>
            </div>
        </div>
 </div>
@include('includes.footer-front')


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>


</html>


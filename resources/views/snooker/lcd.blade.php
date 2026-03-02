@extends('layouts.app')

@section('content')
<div id="lcd-app">
    <div class="lcd-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🎱 ELITE<br>BILLIARD SCORER</div>
            <div class="table-name">{{ $match->table_number }}</div>
            <div class="crest">👑</div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Player 1 -->
            <div class="player-panel">
                <div class="player-name">{{ strtoupper($match->player_1_name) }}</div>

                <div class="score-section">
                    <div class="score-item">
                        <div class="score-label">FRAMES</div>
                        <div class="score-value frame-value" id="p1-frames">{{ $match->player_1_frames }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">BREAK</div>
                        <div class="score-value break-value" id="p1-break">{{ $match->player_1_break }}</div>
                    </div>
                </div>

                <div class="score-item">
                    <div class="score-label">POINTS</div>
                    <div class="score-value points-value" id="p1-points">{{ $match->player_1_points }}</div>
                </div>
            </div>

            <!-- Center Info -->
            <div class="center-panel">
                <div class="time-display" id="time-display">00:00:00</div>

                <div class="match-info">
                    <div class="info-label">PARTIES</div>
                    <div class="info-value">{{ $match->format }}</div>
                </div>
            </div>

            <!-- Player 2 -->
            <div class="player-panel">
                <div class="player-name">{{ strtoupper($match->player_2_name) }}</div>

                <div class="score-section">
                    <div class="score-item">
                        <div class="score-label">FRAMES</div>
                        <div class="score-value frame-value" id="p2-frames">{{ $match->player_2_frames }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">BREAK</div>
                        <div class="score-value break-value" id="p2-break">{{ $match->player_2_break }}</div>
                    </div>
                </div>

                <div class="score-item">
                    <div class="score-label">POINTS</div>
                    <div class="score-value points-value" id="p2-points">{{ $match->player_2_points }}</div>
                </div>
            </div>
        </div>

        <!-- Bottom Info Bar -->
        <div class="bottom-bar">
            <div class="info-item">
                <div class="info-item-label">P1 SCORE</div>
                <div class="info-item-value" id="p1-score">{{ $match->player_1_points }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">P2 SCORE</div>
                <div class="info-item-value" id="p2-score">{{ $match->player_2_points }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">STATUS</div>
                <div class="info-item-value" id="status">{{ ucfirst($match->status) }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">FRAME</div>
                <div class="info-item-value" id="current-frame">{{ $match->current_frame }}/{{ $match->total_frames }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --bg-dark: #0a0e14;
        --border-color: #4a7c59;
        --text-primary: #ffffff;
        --text-secondary: #cccccc;
        --accent-gold: #d4af37;
        --accent-red: #ff4444;
    }

    html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to bottom, #1a1a2e, #0f1419);
        color: var(--text-primary);
    }

    #lcd-app {
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lcd-container {
        width: 100%;
        max-width: 1600px;
        aspect-ratio: 16/9;
        background: #000000;
        border: 3px solid var(--border-color);
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        padding: 40px;
        box-shadow: 0 0 60px rgba(0, 0, 0, 0.8);
        position: relative;
        overflow: hidden;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--border-color);
    }

    .logo {
        font-size: 18px;
        font-weight: bold;
        color: var(--accent-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.3;
    }

    .table-name {
        font-size: 36px;
        font-weight: bold;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .crest {
        width: 60px;
        height: 60px;
        border: 2px solid var(--accent-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .main-content {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 40px;
        flex: 1;
        align-items: center;
    }

    .player-panel {
        border: 3px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
        background: rgba(10, 14, 20, 0.8);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 400px;
    }

    .player-name {
        font-size: 28px;
        font-weight: bold;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .score-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .score-item {
        text-align: center;
    }

    .score-label {
        font-size: 14px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .score-value {
        font-size: 56px;
        font-weight: 900;
        font-family: 'Courier New', monospace;
        color: var(--text-primary);
        line-height: 1;
    }

    .score-value.points-value {
        color: var(--text-primary);
        font-size: 64px;
    }

    .score-value.break-value {
        color: var(--accent-red);
        font-size: 56px;
    }

    .score-value.frame-value {
        color: var(--accent-gold);
        font-size: 72px;
    }

    .center-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        padding: 30px;
        text-align: center;
    }

    .time-display {
        font-size: 48px;
        font-family: 'Courier New', monospace;
        color: var(--accent-gold);
        margin-bottom: 20px;
        font-weight: bold;
        letter-spacing: 3px;
    }

    .match-info {
        margin-top: auto;
    }

    .info-label {
        font-size: 14px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .info-value {
        font-size: 32px;
        font-weight: bold;
        color: var(--accent-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .bottom-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding-top: 20px;
        border-top: 2px solid var(--border-color);
        margin-top: 30px;
    }

    .info-item {
        text-align: center;
    }

    .info-item-label {
        font-size: 12px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .info-item-value {
        font-size: 28px;
        font-weight: bold;
        color: var(--accent-gold);
        font-family: 'Courier New', monospace;
    }

    @media (max-width: 1366px) {
        .lcd-container {
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .main-content {
            gap: 25px;
        }

        .player-panel {
            padding: 20px;
            min-height: 350px;
        }

        .player-name {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .score-value {
            font-size: 36px;
        }

        .score-value.points-value {
            font-size: 44px;
        }

        .score-value.frame-value {
            font-size: 48px;
        }

        .time-display {
            font-size: 32px;
        }

        .info-value {
            font-size: 22px;
        }

        .info-item-value {
            font-size: 22px;
        }
    }
</style>

<script>
    const matchSlug = "{{ $match->slug }}";
    const matchDataUrl = "{{ route('snooker.api.data', $match->slug) }}";

    // Start polling for match data
    let pollInterval = setInterval(async () => {
        try {
            const response = await fetch(matchDataUrl);
            const data = await response.json();

            // Update all values with proper IDs
            document.getElementById('p1-points').textContent = data.player_1.points;
            document.getElementById('p1-break').textContent = data.player_1.break;
            document.getElementById('p1-frames').textContent = data.player_1.frames;
            document.getElementById('p1-score').textContent = data.player_1.points;

            document.getElementById('p2-points').textContent = data.player_2.points;
            document.getElementById('p2-break').textContent = data.player_2.break;
            document.getElementById('p2-frames').textContent = data.player_2.frames;
            document.getElementById('p2-score').textContent = data.player_2.points;

            document.getElementById('status').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            document.getElementById('current-frame').textContent = data.current_frame + '/' + data.total_frames || 9;

        } catch (error) {
            console.error('Polling error:', error);
        }
    }, 1000); // Poll every second

    // Update time
    setInterval(() => {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('time-display').textContent = `${hours}:${minutes}:${seconds}`;
    }, 1000);

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        clearInterval(pollInterval);
    });
</script>
@endsection

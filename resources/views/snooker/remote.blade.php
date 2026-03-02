@extends('layouts.app')

@section('content')
<div id="remote-app">
    <div class="remote-container">
        <!-- Header -->
        <div class="header">
            <h1>🎱 REMOTE CONTROL</h1>
            <p>Elite Billiard Scorer</p>
        </div>

        <!-- Status Bar -->
        <div class="status-bar">
            <div class="status-item">
                <div class="status-label">P1 Score</div>
                <div class="status-value" id="p1-score">{{ $match->player_1_points }}</div>
            </div>
            <div class="status-item">
                <div class="status-label">P2 Score</div>
                <div class="status-value" id="p2-score">{{ $match->player_2_points }}</div>
            </div>
        </div>

        <!-- Player Selector -->
        <div class="player-selector">
            <button class="player-btn active" onclick="selectPlayer(1)">👤 {{ $match->player_1_name }}</button>
            <button class="player-btn" onclick="selectPlayer(2)">👤 {{ $match->player_2_name }}</button>
        </div>

        <!-- Control Buttons -->
        <div class="button-grid">
            <button class="control-btn" onclick="playAction()" title="Play">▶</button>
            <button class="control-btn" onclick="pauseAction()" title="Pause">⏸</button>
            <button class="control-btn" onclick="stopAction()" title="Stop">⏹</button>
            <button class="control-btn red-btn" onclick="resetActionButton()" title="Reset">↺</button>
        </div>

        <!-- Action Buttons -->
        <div class="button-grid">
            <button class="action-btn" onclick="endBreak()">END<br>BREAK</button>
            <button class="action-btn" onclick="missAction()">MISS</button>
            <button class="action-btn" onclick="freeBall()">FREE<br>BALL</button>
            <button class="action-btn" onclick="winFrameAction()">WIN<br>FRAME</button>
        </div>

        <!-- Score Ball Buttons -->
        <div class="score-balls">
            <button class="ball-btn ball-4" onclick="addPointsAction(4)">4</button>
            <button class="ball-btn ball-5" onclick="addPointsAction(5)">5</button>
            <button class="ball-btn ball-6" onclick="addPointsAction(6)">6</button>
            <button class="ball-btn ball-7" onclick="addPointsAction(7)">7</button>
        </div>

        <!-- Red, Yellow, Green Balls -->
        <div class="score-balls">
            <button class="ball-btn ball-1" onclick="addPointsAction(1)">1</button>
            <button class="ball-btn ball-2" onclick="addPointsAction(2)">2</button>
            <button class="ball-btn ball-3" onclick="addPointsAction(3)">3</button>
            <button class="ball-btn exchange-btn" onclick="switchPlayerAction()" title="Exchange Player">⇌</button>
        </div>

        <!-- Undo Button -->
        <div class="undo-section">
            <button class="undo-btn" onclick="undoAction()" title="Undo">↶</button>
        </div>

        <!-- Match Info -->
        <div class="match-info">
            <small>
                <strong>Current Player:</strong> <span id="current-player">{{ $match->player_1_name }}</span> |
                <strong>Frames:</strong> <span id="frames">{{ $match->player_1_frames }}-{{ $match->player_2_frames }}</span> |
                <strong>Frame:</strong> <span id="current-frame">{{ $match->current_frame }}/{{ $match->total_frames }}</span>
            </small>
        </div>
    </div>
</div>

<style>
    :root {
        --bg-dark: #1a1a2e;
        --bg-darker: #0f1419;
        --text-primary: #ffffff;
        --text-secondary: #cccccc;
        --border-color: #4a7c59;
        --accent-gold: #d4af37;
    }

    html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to bottom, var(--bg-dark), var(--bg-darker));
        color: var(--text-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 30px;
    }

    #remote-app {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .remote-container {
        max-width: 600px;
        width: 100%;
        background: linear-gradient(135deg, #1a1a2e 0%, #0f1419 100%);
        border-radius: 25px;
        padding: 40px 30px;
        box-shadow: 0 0 80px rgba(0, 0, 0, 0.8), inset 0 0 40px rgba(0, 0, 0, 0.4);
    }

    .header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header h1 {
        font-size: 24px;
        font-weight: bold;
        color: var(--accent-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }

    .header p {
        font-size: 13px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-bar {
        background: rgba(74, 124, 89, 0.2);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .status-item {
        text-align: center;
    }

    .status-label {
        font-size: 11px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .status-value {
        font-size: 32px;
        font-weight: bold;
        color: var(--accent-gold);
        font-family: 'Courier New', monospace;
    }

    .player-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 30px;
    }

    .player-btn {
        padding: 15px;
        background: rgba(74, 124, 89, 0.2);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .player-btn:hover {
        border-color: var(--accent-gold);
        background: rgba(212, 175, 55, 0.1);
    }

    .player-btn.active {
        background: rgba(74, 124, 89, 0.4);
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    .button-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }

    .control-btn {
        width: 100%;
        aspect-ratio: 1;
        border: 3px solid rgba(100, 100, 100, 0.6);
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, rgba(120, 120, 120, 0.3), rgba(50, 50, 50, 0.8));
        color: var(--text-primary);
        font-size: 24px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .control-btn:hover {
        background: radial-gradient(circle at 30% 30%, rgba(150, 150, 150, 0.4), rgba(70, 70, 70, 0.9));
        transform: scale(1.05);
    }

    .control-btn:active {
        transform: scale(0.95);
    }

    .control-btn.red-btn:hover {
        border-color: #ff4444;
        background: radial-gradient(circle at 30% 30%, rgba(255, 100, 100, 0.3), rgba(150, 20, 20, 0.8));
    }

    .action-btn {
        width: 100%;
        aspect-ratio: 1;
        border: 3px solid rgba(100, 100, 100, 0.6);
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, rgba(120, 120, 120, 0.3), rgba(50, 50, 50, 0.8));
        color: var(--accent-gold);
        font-size: 11px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px;
        line-height: 1.1;
    }

    .action-btn:hover {
        border-color: var(--accent-gold);
        background: radial-gradient(circle at 30% 30%, rgba(212, 175, 55, 0.3), rgba(100, 80, 20, 0.8));
    }

    .action-btn:active {
        transform: scale(0.95);
    }

    .score-balls {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }

    .ball-btn {
        width: 100%;
        aspect-ratio: 1;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 24px;
        color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        position: relative;
        overflow: hidden;
    }

    .ball-btn::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4), transparent);
        pointer-events: none;
    }

    .ball-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
    }

    .ball-btn:active {
        transform: scale(0.95);
    }

    .ball-btn.ball-4 {
        background: linear-gradient(135deg, #ff9944, #ff6600);
    }

    .ball-btn.ball-5 {
        background: linear-gradient(135deg, #3399ff, #0066ff);
    }

    .ball-btn.ball-6 {
        background: linear-gradient(135deg, #ff3388, #ff00ff);
    }

    .ball-btn.ball-7 {
        background: linear-gradient(135deg, #333333, #000000);
        border: 2px solid #666666;
    }

    .ball-btn.ball-1 {
        background: linear-gradient(135deg, #ff6666, #ff0000);
    }

    .ball-btn.ball-2 {
        background: linear-gradient(135deg, #ffff44, #ffdd00);
        color: black;
    }

    .ball-btn.ball-3 {
        background: linear-gradient(135deg, #44ff44, #00dd00);
    }

    .exchange-btn {
        background: radial-gradient(circle at 30% 30%, rgba(120, 120, 120, 0.3), rgba(50, 50, 50, 0.8));
        border: 3px solid rgba(100, 100, 100, 0.6);
    }

    .exchange-btn:hover {
        border-color: var(--accent-gold);
    }

    .undo-section {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .undo-btn {
        width: 100px;
        aspect-ratio: 1;
        border: 3px solid rgba(100, 100, 100, 0.6);
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, rgba(120, 120, 120, 0.3), rgba(50, 50, 50, 0.8));
        color: var(--accent-gold);
        font-size: 28px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .undo-btn:hover {
        border-color: var(--accent-gold);
        background: radial-gradient(circle at 30% 30%, rgba(212, 175, 55, 0.3), rgba(100, 80, 20, 0.8));
    }

    .undo-btn:active {
        transform: scale(0.95);
    }

    .match-info {
        text-align: center;
        padding: 15px;
        background: rgba(74, 124, 89, 0.1);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .match-info small {
        font-size: 12px;
    }

    .match-info strong {
        color: var(--accent-gold);
    }
</style>

<script>
    const matchSlug = "{{ $match->slug }}";
    const apiBaseUrl = "/snooker/api/" + matchSlug;
    let currentPlayer = 1;

    // Polling for match data
    //let pollInterval = setInterval(fetchMatchData, 500);

    function fetchMatchData() {
        fetch(apiBaseUrl + "/data")
            .then(response => response.json())
            .then(data => {
                // Update scores
                document.getElementById('p1-score').textContent = data.player_1.points;
                document.getElementById('p2-score').textContent = data.player_2.points;

                // Update other info
                document.getElementById('current-player').textContent = data.current_player_name;
                document.getElementById('frames').textContent = data.player_1.frames + '-' + data.player_2.frames;
                document.getElementById('current-frame').textContent = data.current_frame + '/' + data.total_frames;
            })
            .catch(error => console.error('Polling error:', error));
    }

    function selectPlayer(player) {
        currentPlayer = player;
        document.querySelectorAll('.player-btn').forEach((btn, idx) => {
            btn.classList.toggle('active', idx === player - 1);
        });
    }

    function addPointsAction(points) {
        const player = currentPlayer === 1 ? 'player_1' : 'player_2';

        fetch(apiBaseUrl + "/add-points", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ player, points })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchMatchData();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function endBreak() {
        const player = currentPlayer === 1 ? 'player_1' : 'player_2';

        fetch(apiBaseUrl + "/reset-break", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ player })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchMatchData();
                // Switch to other player
                selectPlayer(currentPlayer === 1 ? 2 : 1);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function switchPlayerAction() {
        fetch(apiBaseUrl + "/switch-player", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchMatchData();
                selectPlayer(currentPlayer === 1 ? 2 : 1);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function winFrameAction() {
        const winner = currentPlayer === 1 ? 'player_1' : 'player_2';
        const playerName = currentPlayer === 1 ? '{{ $match->player_1_name }}' : '{{ $match->player_2_name }}';

        if (confirm('Confirm ' + playerName + ' wins this frame?')) {
            fetch(apiBaseUrl + "/end-frame", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ winner })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMatchData();
                    selectPlayer(1);
                    if (data.match_completed) {
                        alert('Match completed! ' + playerName + ' wins the match!');
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    function undoAction() {
        fetch(apiBaseUrl + "/undo", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchMatchData();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function resetActionButton() {
        if (confirm('Reset entire match?')) {
            fetch(apiBaseUrl + "/reset", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMatchData();
                    selectPlayer(1);
                    alert('Match reset successfully');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    function playAction() {
        console.log('Play action');
    }

    function pauseAction() {
        console.log('Pause action');
    }

    function stopAction() {
        console.log('Stop action');
    }

    function missAction() {
        endBreak();
    }

    function freeBall() {
        alert('Free Ball declared - no points awarded');
    }

    // Cleanup on page unload
    // window.addEventListener('beforeunload', () => {
    //     clearInterval(pollInterval);
    // });

    // Initial fetch
    fetchMatchData();
</script>
@endsection

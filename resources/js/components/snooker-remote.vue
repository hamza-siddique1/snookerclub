<template>
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
                    <div class="status-value">{{ matchData.player_1.points }}</div>
                </div>
                <div class="status-item">
                    <div class="status-label">P2 Score</div>
                    <div class="status-value">{{ matchData.player_2.points }}</div>
                </div>
            </div>

            <!-- Player Selector -->
            <div class="player-selector">
                <button
                    v-for="(player, index) in [1, 2]"
                    :key="index"
                    class="player-btn"
                    :class="{ active: currentPlayer === player }"
                    @click="selectPlayer(player)"
                >
                    👤 {{ player === 1 ? matchData.player_1.name : matchData.player_2.name }}
                </button>
            </div>

            <!-- Control Buttons -->
            <div class="button-grid">
                <button class="control-btn" @click="playAction()" title="Play">▶</button>
                <button class="control-btn" @click="pauseAction()" title="Pause">⏸</button>
                <button class="control-btn" @click="stopAction()" title="Stop">⏹</button>
                <button class="control-btn red-btn" @click="resetActionButton()" title="Reset">↺</button>
            </div>

            <!-- Action Buttons -->
            <div class="button-grid">
                <button class="action-btn" @click="endBreak()">END<br>BREAK</button>
                <button class="action-btn" @click="missAction()">MISS</button>
                <button class="action-btn" @click="freeBall()">FREE<br>BALL</button>
                <button class="action-btn" @click="winFrameAction()">WIN<br>FRAME</button>
            </div>

            <!-- Score Ball Buttons -->
            <div class="score-balls">
                <button
                    v-for="points in [4, 5, 6, 7]"
                    :key="points"
                    :class="['ball-btn', `ball-${points}`]"
                    @click="addPointsAction(points)"
                >
                    {{ points }}
                </button>
            </div>

            <!-- Red, Yellow, Green Balls -->
            <div class="score-balls">
                <button
                    v-for="points in [1, 2, 3]"
                    :key="points"
                    :class="['ball-btn', `ball-${points}`]"
                    @click="addPointsAction(points)"
                >
                    {{ points }}
                </button>
                <button class="ball-btn exchange-btn" @click="switchPlayerAction()" title="Exchange Player">⇌</button>
            </div>

            <!-- Undo Button -->
            <div class="undo-section">
                <button class="undo-btn" @click="undoAction()" title="Undo">↶</button>
            </div>

            <!-- Match Info -->
            <div class="match-info">
                <small>
                    <strong>Current Player:</strong> <span>{{ matchData.current_player_name }}</span> |
                    <strong>Frames:</strong> <span>{{ matchData.player_1.frames }}-{{ matchData.player_2.frames }}</span> |
                    <strong>Frame:</strong> <span>{{ matchData.current_frame }}/{{ matchData.total_frames }}</span>
                </small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        match: {
            type: Object,
            required: true
        }
    },

    data: function () {
        return {
            currentPlayer: 1,
            matchData: {
                player_1: {
                    name: this.match.player_1_name,
                    points: this.match.player_1_points,
                    frames: this.match.player_1_frames,
                    break: this.match.player_1_break
                },
                player_2: {
                    name: this.match.player_2_name,
                    points: this.match.player_2_points,
                    frames: this.match.player_2_frames,
                    break: this.match.player_2_break
                },
                current_player: this.match.current_player,
                current_player_name: this.match.player_1_name,
                current_frame: this.match.current_frame,
                total_frames: this.match.total_frames,
                status: this.match.status
            }
        };
    },

    mounted() {
        this.fetch_data();
    },

    watch: {
        currentPlayer(newPlayer, oldPlayer) {
        // Skip initial setup
        if (oldPlayer === undefined || oldPlayer === null) {
            return;
        }

        console.log(`🔄 Player switched: ${oldPlayer} → ${newPlayer}`);

        this.endBreak(oldPlayer);
    }
    },

    methods: {
        fetch_data() {
            var URL = `/snooker/api/${this.match.slug}/data`;
            axios.get(URL)
                .then((response) => {
                    this.matchData = response.data;
                })
                .catch((error) => {
                    console.error('Polling error:', error);
                });
        },

        selectPlayer(player) {
            this.currentPlayer = player;
        },

        addPointsAction(points) {
            console.log(points);
            const player = this.currentPlayer === 1 ? 'player_1' : 'player_2';
            const URL = `/snooker/api/${this.match.slug}/add-points`;

            axios.post(URL, { player, points }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.data.success) {
                    this.fetch_data();
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        },

        endBreak(player_id) {
            const player = player_id === 1 ? 'player_1' : 'player_2';
            const URL = `/snooker/api/${this.match.slug}/reset-break`;

            axios.post(URL, { player }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.data.success) {
                    this.fetch_data();
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        },

        switchPlayerAction() {
            const URL = `/snooker/api/${this.match.slug}/switch-player`;

            axios.post(URL, {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.data.success) {
                    this.fetch_data();
                    this.selectPlayer(this.currentPlayer === 1 ? 2 : 1);
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        },

        winFrameAction() {
            const winner = this.currentPlayer === 1 ? 'player_1' : 'player_2';
            const playerName = this.currentPlayer === 1
                ? this.matchData.player_1.name
                : this.matchData.player_2.name;

            if (confirm(`Confirm ${playerName} wins this frame?`)) {
                const URL = `/snooker/api/${this.match.slug}/end-frame`;

                axios.post(URL, { winner }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.fetch_data();
                        this.selectPlayer(1);
                        if (response.data.match_completed) {
                            alert(`Match completed! ${playerName} wins the match!`);
                        }
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        },

        undoAction() {
            const URL = `/snooker/api/${this.match.slug}/undo`;

            axios.post(URL, {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.data.success) {
                    this.fetch_data();
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        },

        resetActionButton() {
            if (confirm('Reset entire match?')) {
                const URL = `/snooker/api/${this.match.slug}/reset`;

                axios.post(URL, {}, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.fetch_data();
                        this.selectPlayer(1);
                        alert('Match reset successfully');
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        },

        playAction() {
            console.log('Play action');
        },

        pauseAction() {
            console.log('Pause action');
        },

        stopAction() {
            console.log('Stop action');
        },

        missAction() {
            this.endBreak();
        },

        freeBall() {
            alert('Free Ball declared - no points awarded');
        }
    }
};
</script>

<style scoped>
    :root {
        --bg-dark: #1a1a2e;
        --bg-darker: #0f1419;
        --text-primary: #ffffff;
        --text-secondary: #cccccc;
        --border-color: #4a7c59;
        --accent-gold: #d4af37;
    }

    #remote-app {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to bottom, var(--bg-dark), var(--bg-darker));
        min-height: 100vh;
        padding: 30px;
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

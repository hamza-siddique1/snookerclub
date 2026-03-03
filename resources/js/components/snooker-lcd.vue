<!--
resources/js/components/SnookerLcdDisplay.vue
FIXED VERSION - Proper API response handling
-->

<template>
    <div id="lcd-app">
        <div class="lcd-container">
            <!-- Header -->
            <div class="header">
                <div class="logo">🎱 ELITE<br>BILLIARD SCORER</div>
                <div class="table-name">{{ match.table_number }}</div>
                <div class="crest">👑</div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Player 1 -->
                <div class="player-panel">
                    <div class="player-name">{{ match.player_1_name.toUpperCase() }}</div>

                    <div class="score-section">
                        <div class="score-item">
                            <div class="score-label">FRAMES</div>
                            <div class="score-value frame-value">{{ matchData.player_1_frames }}</div>
                        </div>
                        <div class="score-item">
                            <div class="score-label">BREAK</div>
                            <div class="score-value break-value">{{ matchData.player_1_break }}</div>
                        </div>
                    </div>

                    <div class="score-item">
                        <div class="score-label">POINTS</div>
                        <div class="score-value points-value">{{ matchData.player_1_points }}</div>
                    </div>
                </div>

                <!-- Center Info -->
                <div class="center-panel">
                    <div class="time-display">{{ currentTime }}</div>

                    <div class="match-info">
                        <div class="info-label">PARTIES</div>
                        <div class="info-value">{{ match.format }}</div>
                    </div>
                </div>

                <!-- Player 2 -->
                <div class="player-panel">
                    <div class="player-name">{{ match.player_2_name.toUpperCase() }}</div>

                    <div class="score-section">
                        <div class="score-item">
                            <div class="score-label">FRAMES</div>
                            <div class="score-value frame-value">{{ matchData.player_2_frames }}</div>
                        </div>
                        <div class="score-item">
                            <div class="score-label">BREAK</div>
                            <div class="score-value break-value">{{ matchData.player_2_break }}</div>
                        </div>
                    </div>

                    <div class="score-item">
                        <div class="score-label">POINTS</div>
                        <div class="score-value points-value">{{ matchData.player_2_points }}</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Info Bar -->
            <div class="bottom-bar">
                <div class="info-item">
                    <div class="info-item-label">P1 SCORE</div>
                    <div class="info-item-value">{{ matchData.player_1_points }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">P2 SCORE</div>
                    <div class="info-item-value">{{ matchData.player_2_points }}</div>
                </div>

                <div class="info-item">
                    <div class="info-item-label">FRAME</div>
                    <div class="info-item-value">{{ matchData.current_frame }}/{{ match.total_frames }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SnookerLcdDisplay',
    props: {
        match: {
            type: Object,
            required: true,
            description: 'Match data from toMatchData() method'
        }
    },
    data() {
        return {
            // Local reactive state - copy of match data
            // Updated from API polling
            matchData: {
                id: this.match.id,
                slug: this.match.slug,
                player_1_name: this.match.player_1_name,
                player_2_name: this.match.player_2_name,
                format: this.match.format,
                total_frames: this.match.total_frames,
                // FLAT STRUCTURE - matching the model properties
                player_1_points: this.match.player_1_points,
                player_1_break: this.match.player_1_break,
                player_1_frames: this.match.player_1_frames,
                player_2_points: this.match.player_2_points,
                player_2_break: this.match.player_2_break,
                player_2_frames: this.match.player_2_frames,
                status: this.match.status,
                current_frame: this.match.current_frame,
                table_number: this.match.table_number
            },
            currentTime: this.getFormattedTime(),
            pollInterval: null,
            timeInterval: null
        }
    },
    mounted() {
        console.log('Component mounted - Match data:', this.match);

        // Start polling for match data updates
        this.pollInterval = setInterval(() => {
            this.fetchMatchData();
        }, 1000);

        // Update time every second
        this.timeInterval = setInterval(() => {
            this.currentTime = this.getFormattedTime();
        }, 1000);
    },
    beforeUnmount() {
        // Clear intervals on component unmount
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
        }
        if (this.timeInterval) {
            clearInterval(this.timeInterval);
        }
    },
    methods: {
        /**
         * Fetch match data from API
         * API returns data from toMatchData() method
         */
        async fetchMatchData() {
            try {
                const response = await window.axios.get(`/snooker/api/${this.match.slug}/data`);
                const data = response.data;

                // Log for debugging
                console.log('API Response:', data);

                // Update matchData - handle both nested and flat API responses
                this.matchData = {
                    id: data.id || this.matchData.id,
                    slug: data.slug || this.matchData.slug,
                    player_1_name: data.player_1_name || this.matchData.player_1_name,
                    player_2_name: data.player_2_name || this.matchData.player_2_name,
                    format: data.format || this.matchData.format,
                    total_frames: data.total_frames || this.matchData.total_frames,

                    // Handle both nested structure: data.player_1.points
                    // and flat structure: data.player_1_points
                    player_1_points: data.player_1?.points !== undefined ? data.player_1.points : (data.player_1_points !== undefined ? data.player_1_points : this.matchData.player_1_points),
                    player_1_break: data.player_1?.break !== undefined ? data.player_1.break : (data.player_1_break !== undefined ? data.player_1_break : this.matchData.player_1_break),
                    player_1_frames: data.player_1?.frames !== undefined ? data.player_1.frames : (data.player_1_frames !== undefined ? data.player_1_frames : this.matchData.player_1_frames),

                    player_2_points: data.player_2?.points !== undefined ? data.player_2.points : (data.player_2_points !== undefined ? data.player_2_points : this.matchData.player_2_points),
                    player_2_break: data.player_2?.break !== undefined ? data.player_2.break : (data.player_2_break !== undefined ? data.player_2_break : this.matchData.player_2_break),
                    player_2_frames: data.player_2?.frames !== undefined ? data.player_2.frames : (data.player_2_frames !== undefined ? data.player_2_frames : this.matchData.player_2_frames),

                    status: data.status || this.matchData.status,
                    current_frame: data.current_frame || this.matchData.current_frame,
                    table_number: data.table_number || this.matchData.table_number
                };

                console.log('Updated matchData:', this.matchData);
            } catch (error) {
                console.error('Error fetching match data:', error);
            }
        },

        /**
         * Get formatted time HH:MM:SS
         */
        getFormattedTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        },

        async endBreak() {
        try {
            const player = this.currentPlayer === 1 ? 'player_1' : 'player_2';

            const response = await window.axios.post(
                `/snooker/api/${this.match.slug}/reset-break`,
                { player }
            );

            if (response.data.success) {
                this.matchData = response.data.match;

                // Switch to other player
                this.currentPlayer = this.currentPlayer === 1 ? 2 : 1;

                console.log(`Player ${this.currentPlayer} now playing. Other player's break is reset to 0`);
            } else {
                alert('Error: ' + response.data.message);
            }
        } catch (error) {
            console.error('Error ending break:', error);
            alert('Error ending break');
        }
    },

    /**
     * Miss action - resets break and switches player
     */
    async missAction() {
        if (confirm('Player missed. Switch to other player?')) {
            await this.endBreak();
        }
    },

    /**
     * When adding points, track if this is still the same player
     */
    async addPoints(points) {
        try {
            const player = this.currentPlayer === 1 ? 'player_1' : 'player_2';

            const response = await window.axios.post(
                `/snooker/api/${this.match.slug}/add-points`,
                { player, points }
            );

            if (response.data.success) {
                this.matchData = response.data.match;
                // Break automatically increases as points are added
                // No reset needed here - same player is still playing
            } else {
                alert('Error: ' + response.data.message);
            }
        } catch (error) {
            console.error('Error adding points:', error);
        }
    }
    }
}
</script>

<style scoped>
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

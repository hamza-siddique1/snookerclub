<template>
<div class="relative rounded-2xl overflow-hidden border border-white/10 bg-[linear-gradient(160deg,#111811_0%,#0a0e0a_50%,#080c08_100%)] shadow-[0_0_60px_rgba(0,0,0,0.8),inset_0_1px_0_rgba(255,255,255,0.06)]">
                  <div class="grid grid-cols-3 items-center border-b border-white/5">
                    <div class="flex leading-none p-4 justify-center">
                      <img alt="Logo" class="h-12 w-auto" src="/assets/front/images/logo.png">
                    </div>
                    <div class="flex flex-col items-center">
                      <span class="text-xs tracking-[0.2em] text-white/40 font-semibold mb-0.5">TABLE</span>
                      <span class="text-3xl font-bold text-white/90">{{ match.table_number }}</span>
                    </div>
                    <div class="flex justify-center">
                      <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center bg-white/[0.04]">
                        <span class="text-xl">🎱</span>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-stretch">
                    <div class="flex-1 flex flex-col items-center justify-center py-8 px-6 border-r border-white/5 transition-all duration-300" :class="this.current_player === 'player_1' ? 'bg-emerald-500/10' : 'bg-transparent'">
                      <div v-if="this.current_player === 'player_1'" class="w-2 h-2 rounded-full mb-3 pulse pulse-dot bg-emerald-400"></div>
                      <div class="text-center font-bold text-white leading-tight mb-6 whitespace-pre-line tracking-wider text-[clamp(22px,4vw,32px)] [text-shadow:0_0_20px_rgba(74,222,128,0.3)]">{{ match.player_1_name.toUpperCase() }}</div>
                      <div class="flex items-center gap-3 mb-4">
                        <span class=" font-bold text-[52px] text-amber-400 min-w-[60px] text-center">{{ matchData.player_1_frames }}</span>
                      </div>
                      <div class="flex items-center gap-3 mb-4">
                        <span class="font-bold text-[44px] text-red-500 min-w-[60px] text-center">{{ matchData.player_1_break }}</span>
                      </div>
                      <div class="flex items-center gap-3">
                        <span class="font-bold text-[62px] text-white min-w-[60px] text-center">{{ matchData.player_1_points }}</span>
                      </div>
                    </div>
                    <div class="flex flex-col items-center justify-between py-8 px-6 min-w-[180px]">
                      <div class="flex flex-col items-center gap-1 mb-2">
                        <div class="flex items-center gap-1">
                          <span class="font-bold tabular-nums text-3xl tracking-wider text-white">{{ currentTime }}</span>
                        </div>
                        <div class="flex gap-3 text-[9px] tracking-[0.18em] text-white/30 font-semibold">
                          <span>HEURES</span>
                          <span>MIN</span>
                          <span>SEC</span>
                        </div>

                      </div>
                      <div class="w-full h-px bg-white/5 my-1"></div>
                      <div class="flex flex-col items-center my-3">
                        <span class="text-xs font-bold tracking-[0.15em] text-white/50 mb-0.5">PARTIES</span>
                        <span class="text-sm font-semibold text-white/30"></span>
                      </div>
                      <div class="w-full h-px bg-white/5 my-1"></div>
                      <div class="flex flex-col items-center my-3">
                        <span class="text-sm font-bold tracking-[0.2em] text-red-500 [text-shadow:0_0_10px_rgba(239,68,68,0.5)]">BREAK</span>
                      </div>
                      <div class="w-full h-px bg-white/5 my-1"></div>
                      <div class="flex flex-col items-center mt-3">
                        <span class="text-xs font-bold tracking-[0.15em] text-white/50 mb-0.5">POINTS</span>
                        <span class="text-sm font-semibold text-white/30"></span>
                      </div>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center py-8 px-6 border-l border-white/5 transition-all duration-300" :class="this.current_player === 'player_2' ? 'bg-emerald-500/10' : 'bg-transparent'">
                      <div v-if="this.current_player === 'player_2'" class="w-2 h-2 rounded-full mb-3 pulse pulse-dot bg-emerald-400"></div>
                        <div class="w-2 h-2 rounded-full mb-3"></div>
                      <div class="text-center font-bold text-white leading-tight mb-6 whitespace-pre-line tracking-wider text-[clamp(22px,4vw,32px)] ">{{ match.player_2_name.toUpperCase() }}</div>
                      <div class="flex items-center gap-3 mb-4">
                        <span class="font-bold text-[52px] text-amber-400 min-w-[60px] text-center">{{ matchData.player_2_frames }}</span>
                      </div>
                      <div class="flex items-center gap-3 mb-4">
                        <span class="font-bold text-[44px] text-red-500 min-w-[60px] text-center">{{ matchData.player_2_break }}</span>
                      </div>
                      <div class="flex items-center gap-3">
                        <span class="font-bold text-[62px] text-white min-w-[60px] text-center">{{ matchData.player_2_points }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-center justify-center gap-2 py-4 border-t border-white/5">
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-red"></div>
                    <div class="rounded-full transition-all duration-200 ball-violet"></div>
                    <div class="rounded-full transition-all duration-200 ball-violet"></div>
                    <div class="rounded-full transition-all duration-200 ball-violet"></div>
                    <div class="rounded-full transition-all duration-200 ball-violet"></div>
                    <div class="rounded-full transition-all duration-200 ball-violet"></div>
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
            current_player: 1,
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

                this.current_player = data.current_player;

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


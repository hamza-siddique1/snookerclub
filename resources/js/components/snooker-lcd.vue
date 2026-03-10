<template>
  <table class="w-full border-collapse table-fixed">
    <colgroup>
      <col style="width: 40%;">
      <col style="width: 20%;">
      <col style="width: 40%;">
    </colgroup>
    <thead class="text-center">
      <tr class="bg-[#111811] border-b border-white/5 [&amp;&gt;th]:text-center">
        <th class="align-middle text-center p-4 py-3">
          <div class="flex items-center justify-center">
            <img alt="Logo" class="h-12 w-auto" src="/assets/front/images/logo.png">
          </div>
        </th>
        <th class="align-middle text-center p-4 py-3">
          <span class="text-[16px] tracking-[0.2em] text-white/50 uppercase font-semibold block">TABLE</span>
          <span class="text-2xl font-bold text-white">{{ match.table_number }}</span>
        </th>
        <th class="align-middle text-center p-4 py-3">
          <div class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto">
            <span class="text-lg">🎱</span>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-white/5">
        <td class="align-middle text-center p-4 py-6" :class="getPlayerClass('player_1')">
          <div v-if="this.current_player === 'player_1'" class="w-2 h-2 rounded-full mb-2 bg-emerald-400 animate-pulse mx-auto"></div>
          <span class="font-bold text-white text-lg sm:text-xl tracking-wider leading-tight whitespace-pre-line">{{ match.player_1_name.toUpperCase() }}</span>
        </td>
        <td class="align-middle text-center p-4 py-6 bg-black/50">
          <span class="font-bold tabular-nums text-2xl sm:text-3xl tracking-wider block text-white">{{ currentTime }}</span>
          <span class="text-[9px] tracking-[0.15em] text-white/40 uppercase mt-0.5 inline-block">HEURES MIN SEC</span>
        </td>
        <td class="align-middle text-center p-4 py-6" :class="getPlayerClass('player_2')">
          <div v-if="this.current_player === 'player_2'" class="w-2 h-2 rounded-full mb-2 bg-emerald-400 animate-pulse mx-auto"></div>
          <span class="font-bold text-white text-lg sm:text-xl tracking-wider leading-tight whitespace-pre-line">{{ match.player_2_name.toUpperCase() }}</span>
        </td>
      </tr>
      <tr class="border-b border-white/5">
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_1')">
          <span class="font-bold text-4xl sm:text-5xl text-amber-400">{{ matchData.player_1_frames }}</span>
        </td>
        <td class="align-middle text-center p-4 py-4 bg-black/50">
          <span class="text-xs font-bold tracking-[0.15em] text-white/50 uppercase block">PARTIES</span>
        </td>
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_2')">
          <span class="font-bold text-4xl sm:text-5xl text-amber-400">{{ matchData.player_2_frames }}</span>
        </td>
      </tr>
      <tr class="border-b border-white/5">
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_1')">
          <span v-if="this.current_player == 'player_1'" class="font-bold text-3xl sm:text-4xl text-red-500">{{ matchData.player_1_break }}</span>
        </td>
        <td class="align-middle text-center p-4 py-4 bg-black/50">
          <span class="text-sm font-bold tracking-[0.2em] text-red-500 uppercase">BREAK</span>
        </td>
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_2')">
          <span v-if="this.current_player == 'player_2'" class="font-bold text-3xl sm:text-4xl text-red-500">{{ matchData.player_2_break }}</span>
        </td>
      </tr>
      <tr class="border-b border-white/5">
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_1')">
          <span :class="blinkingFields.player_1_points ? 'animate-blink' : ''" class="font-bold text-4xl sm:text-5xl text-white">{{ matchData.player_1_points }}</span>
        </td>
        <td class="align-middle text-center p-4 py-4 bg-black/50">
          <span class="text-xs font-bold tracking-[0.15em] text-white/50 uppercase block">POINTS</span>
        </td>
        <td class="align-middle text-center p-4 py-4" :class="getPlayerClass('player_2')">
          <span :class="blinkingFields.player_2_points ? 'animate-blink' : ''" class="font-bold text-4xl sm:text-5xl text-white">{{ matchData.player_2_points }}</span>
        </td>
      </tr>
      <tr>
        <td colspan="3" class="py-4 px-4 bg-[#0a0e0a] text-center">
          <div class="flex items-center justify-center gap-2">
            <div
              v-for="(color, index) in pottedBalls"
              :key="index"
              class="rounded-full ball-red"
              :class="color"
            >
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
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
            current_player: this.match.current_player,
            currentTime: this.getFormattedTime(),
            pollInterval: null,
            timeInterval: null,
            blinkingFields: {
              player_1_points: false,
              player_1_break: false,
              player_1_frames: false,
              player_2_points: false,
              player_2_break: false,
              player_2_frames: false

            },
            pottedBalls: [],
            ballColorMap: {
                1: 'red',
                2: 'yellow',
                3: 'green',
                4: 'orange',
                5: 'blue',
                6: 'purple',
                7: 'grey'
            }
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

                const ballNumbers = data.potted_balls || [];
                this.pottedBalls = ballNumbers.map(num => this.ballColorMap[num]);

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

    getPlayerClass(player) {
      return this.current_player === player ? 'bg-emerald-500/20' : 'bg-black/30';
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
    },

    triggerBlink(field) {
        this.blinkingFields[field] = true;
        setTimeout(() => {
            this.blinkingFields[field] = false;
        }, 3000); // 2 seconds
    },
    },
    computed: {
      player1ActiveClass() {
        return this.current_player === 'player_1' ? 'bg-emerald-500/10' : 'bg-transparent';
      },
      player2ActiveClass() {
        return this.current_player === 'player_2' ? 'bg-emerald-500/10' : 'bg-transparent';
      }
    },
watch: {
    'matchData.player_1_points': function(newVal, oldVal) {
        if (oldVal !== undefined && newVal !== oldVal) {
            this.triggerBlink('player_1_points');
        }
    },
    'matchData.player_2_points': function(newVal, oldVal) {
        if (oldVal !== undefined && newVal !== oldVal) {
            this.triggerBlink('player_2_points');
        }
    }

  }
}
</script>

<style scoped>
@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.3; }
}

.animate-blink {
  animation: blink 0.5s ease-in-out 3 !important;
}

.red {
  background-color: #C00000;
}

.yellow {
  background-color: #FFD700;
}

.green {
  background-color: #008000;
}

.orange {
  background-color: #8B4513;
}

.blue {
  background-color: #0057B7;
}

.purple {
  background-color: #FF69B4;
}

.grey {
  background-color: #383636;
}
</style>

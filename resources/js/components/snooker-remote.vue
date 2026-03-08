<template>
  <div class="w-full max-w-[480px] rounded-[28px] border border-white/25 p-5 flex flex-col gap-4 bg-[linear-gradient(180deg,#141424_0%,#0f0f1e_100%)] shadow-[0_30px_80px_rgba(0,0,0,0.7),0_0_0_1px_rgba(255,255,255,0.05)]">
    <div class="grid grid-cols-2 gap-2.5">
      <button
        v-for="player in ['player_1', 'player_2']"
        :key="player"
        type="button"
        class="player-btn flex items-center gap-2 py-2 px-3 rounded-xl cursor-pointer transition-all duration-200 border-2 font-bold text-[11px] tracking-wider whitespace-nowrap overflow-hidden text-ellipsis font-['Rajdhani',sans-serif]"
        :class="matchData.current_player === player ? 'border-amber-400 text-amber-400 bg-amber-400/10' : 'border-white/10 text-white/35 bg-white/[0.03]'"
        @click="selectPlayer(player)"
      >
        <span class="text-xl">👤</span>
        <span class="overflow-hidden text-ellipsis text-[14px]">{{ player === 'player_1' ? matchData.player_1.name : matchData.player_2.name }}</span>
      </button>
    </div>
    <div class="grid grid-cols-4 gap-2.5">
      <button type="button" class="btn-circle btn-dark text-lg text-white/75">▶</button>
      <button type="button" class="btn-circle btn-dark text-lg text-white/75">⏸</button>
      <button type="button" class="btn-circle btn-dark text-lg text-white/75">⏹</button>
      <button @click="winFrameAction()" type="button" class="btn-circle btn-dark text-[9px] font-bold text-amber-400 tracking-[0.08em] leading-snug whitespace-pre-line text-center py-1.5 px-1.5">WIN FRAME</button>
    </div>
    <div class="grid grid-cols-4 gap-2.5">
      <button
        v-for="points in [4, 5, 6, 7]"
        :key="points"
        type="button"
        class="btn-circle btn-dark text-[9px] font-bold text-amber-400 tracking-[0.08em] leading-snug whitespace-pre-line text-center py-1.5 px-1.5"
        @click="foulPointsAction(points)"
      >
        {{ points }}<br>Points<br>Foul
      </button>
    </div>
    <div class="grid grid-cols-4 gap-2.5">
      <button
        v-for="points in [4, 5, 6, 7]"
        :key="points"
        type="button"
        class="btn-circle ball-btn text-white text-[22px] font-bold [text-shadow:0_1px_3px_rgba(0,0,0,0.4)] transition-transform"
        :class="`ball-${points}`"
        @click="addPointsAction(points)"
      >
        {{ points }}
      </button>
    </div>
    <div class="grid grid-cols-4 gap-2.5">
      <button
        v-for="points in [1, 2, 3]"
        :key="points"
        type="button"
        class="btn-circle ball-btn text-white text-[22px] font-bold [text-shadow:0_1px_3px_rgba(0,0,0,0.4)] transition-transform"
        :class="`ball-${points}`"
        @click="addPointsAction(points)"
      >
        {{ points }}
      </button>
      <button
        type="button"
        class="btn-circle btn-dark text-xl text-white/60"
        @click="switchPlayerAction()"
        title="Exchange Player"
      >
        ⇄
      </button>
    </div>
    <div class="flex justify-center">
      <button type="button" @click="undoAction" class="btn-circle btn-dark w-[84px] h-[84px] text-xl text-amber-400 opacity-80">↩</button>
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
        'matchData.current_player': function(newPlayer, oldPlayer) {
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
                    console.log(this.matchData);
                })
                .catch((error) => {
                    console.error('Polling error:', error);
                });
        },

        selectPlayer(player) {
            console.log(player);
            this.matchData.current_player = player;
            // this.switchPlayerAction();
        },

        addPointsAction(points, is_foul = 0) {
            console.log(points);
            const player = this.matchData.current_player === 'player_1' ? 'player_1' : 'player_2';
            const URL = `/snooker/api/${this.match.slug}/add-points`;

            axios.post(URL, { player, points, is_foul: is_foul }, {
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

        addFoulPointsAction(points) {
            console.log(points);
            const player = this.matchData.current_player === 'player_1' ? 'player_1' : 'player_2';
            const URL = `/snooker/api/${this.match.slug}/add-foul-points`;

            axios.post(URL, { player, points, type: 'foul' }, {
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
            const player = player_id === 'player_1' ? 'player_1' : 'player_2';
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
                    this.selectPlayer(this.matchData.current_player === 'player_1' ? 'player_1' : 'player_2');
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        },

        winFrameAction() {
            const winner = this.matchData.current_player === 'player_1' ? 'player_1' : 'player_2';
            const playerName = this.matchData.current_player === 1
                ? this.matchData.player_1.name
                : this.matchData.player_2.name;

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

        foulPointsAction(points) {
            const opponentPlayer = this.matchData.current_player === 'player_1' ? 'player_2' : 'player_1';
            const previousPlayer = this.matchData.current_player;

            this.matchData.current_player = opponentPlayer;

            this.addPointsAction(points, 1);

            this.matchData.current_player = previousPlayer;
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

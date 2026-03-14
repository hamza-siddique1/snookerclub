<template>
  <div id="5" class="draw__round ">
    <div class="draw__header">
      <div class="draw__arrow draw__arrow--previous"></div>
      <div class="draw__label">{{ roundLabel }}</div>
      <div class="draw__arrow draw__arrow--next"></div>
    </div>
    <div class="draw__brackets">

  <div
    v-for="(match, index) in matches"
    :key="match.id"
    class="draw__bracket"
    :class="index % 2 === 0 ? 'draw__bracket--odd' : 'draw__bracket--even'"
    :style="{ '--zIndex': -index }"
  >

    <div class="bracket" title="Click to view a list of matches">

      <!-- PLAYER 1 -->
      <div class="bracket__participant bracket__participant--home">
        <span
          class="bracket__name"
          :class="{ 'bracket__name--advancing': match.winner == match.player1 }"
        >
          {{ match.player1 }}
        </span>

        <span class="bracket__info"></span>
      </div>

      <div class="bracket__result bracket__result--home">
        <div class="result">
          {{ match.player1_score }}
        </div>
      </div>

      <!-- PLAYER 2 -->
      <div class="bracket__participant bracket__participant--away">
        <span
          class="bracket__name"
          :class="{ 'bracket__name--advancing': match.winner == match.player2 }"
        >
          {{ match.player2 }}
        </span>

        <span class="bracket__info"></span>
      </div>

      <div class="bracket__result bracket__result--away">
        <div class="result">
          {{ match.player2_score }}
        </div>
      </div>

    </div>

  </div>

</div>
  </div>
</template>

<script>
export default {
    props: {
        tournament: {
            type: String,
            required: true
        },
        round: {
            type: String,
            required: true
        },

    },
    data: function () {
        return {
            matches: [],
            roundMap: {
                1: 'Quarter-finals',
                2: 'Semi-finals',
                3: 'Final'
            }
        }
    },

    computed: {
        roundLabel() {
            return this.roundMap[this.round] || '--';
        }
    },

    mounted() {

        this.fetch_data();

        window.setInterval(() => {
            this.fetch_data()
        }, 3 * 1000);
    },

    methods: {
        fetch_data() {
            axios.get('/get-bracket-data', {
        params: {
            tournament_title: this.tournament,
            round: this.round
        }
    }).then(res => {
        this.matches = res.data;
        console.log(res.data)
    })
    }
}
}
</script>


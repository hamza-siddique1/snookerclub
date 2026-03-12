<template>
  <div id="5" class="draw__round ">
    <div class="draw__header">
      <div class="draw__arrow draw__arrow--previous"></div>
      <div class="draw__label">Quarter-finals</div>
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
          :class="{ 'bracket__name--advancing': match.winner == match.player_1_id }"
        >
          {{ match.player_1_name }}
        </span>

        <span class="bracket__info"></span>
      </div>

      <div class="bracket__result bracket__result--home">
        <div class="result">
          {{ match.score_player_1 }}
        </div>
      </div>

      <!-- PLAYER 2 -->
      <div class="bracket__participant bracket__participant--away">
        <span
          class="bracket__name"
          :class="{ 'bracket__name--advancing': match.winner == match.player_2_id }"
        >
          {{ match.player_2_name }}
        </span>

        <span class="bracket__info"></span>
      </div>

      <div class="bracket__result bracket__result--away">
        <div class="result">
          {{ match.score_player_2 }}
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
        level: {
            type: String,
            required: true
        },

    },
    data: function () {
        return {
            matches: []
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
            level: this.level
        }
    }).then(res => {
        this.matches = res.data;
        console.log(res.data)
    })
    }
}
}
</script>


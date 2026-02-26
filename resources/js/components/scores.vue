<template>
    <div>

        <div v-for="(match,index) in matches">
            <div v-for="(match2, index2) in match">
                <div class="tour-nam">

                    <div class="tounamnam"><h3 class="tour-h3">{{ index }} - {{ index2 }} </h3></div>


                    <div class="rightt">
                        <p style="padding-top: 1em; padding-left: 0.8em; margin: 0px;" class="text-right">

                            <a class="drawbutton" style="color: white;" :href="'draw/' + match2[0].draw_url ">
                                Draw
                            </a>

                        </p>
                    </div>

                </div>

                <div class="tablediv">
                    <table class="table table-responsive data matches-round" id="round1">
                        <colgroup>
                            <col class="col-1">
                            <col class="col-2">
                            <col class="col-3">
                            <col class="col-4">
                            <col class="col-5">
                            <col class="col-6">
                            <col class="col-7">
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="text-uppercase"><span class="tbl-hd-label"><abbr title="Number">#</abbr></span>
                            </th>
                            <th class="text-uppercase"><span class="tbl-hd-label">Player 1</span></th>
                            <th class="text-uppercase"></th>
                            <th class="text-uppercase"><span class="tbl-hd-label">Player 2</span></th>
                            <th class="text-uppercase"></th>
                            <th class="text-uppercase"><span class="tbl-hd-label">Time</span></th>
                            <th class="text-uppercase"></th>
                            <th class="text-uppercase"><span class="tbl-hd-label">Table</span></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="odd" v-for="(item, index) in match2" @click="open_detail_page(item.id)">
                            <td rowspan="1"> {{ item.match_number }}</td>
                            <td class="text-right" :class="getClassName(item.winner === item.player_1_id)"> {{ item.player_1 }}</td>
                            <td>
                                <div class="row odds-parent">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right">
                                        <span class="score "> {{ item.score_player_1 }}  </span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                        <abbr class="versus normal-score" title="Versus">
                                            v
                                        </abbr>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
                                        <span class="score "> {{ item.score_player_2 }} </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left" :class="getClassName(item.winner === item.player_2_id)"> {{ item.player_2 }}</td>
                            <td class="text-left"> {{ item.year }}</td>
                            <td class="text-left"> {{ item.table_number }}</td>

                        </tr>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <div class="tablediv" v-if="matches.length === 0">
            <table class="table table-responsive data matches-round" id="round1">
                <colgroup>
                    <col class="col-1">
                </colgroup>
                <thead>
                <tr>
                    <th><span class="tbl-hd-label">No matches planned for this date</span></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
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
            var URL = '/api/scores?' + window.location.search.substring(1);
            axios.get(URL)
                .then((response) => {
                    this.matches = response.data;
                });

        },

        open_detail_page(id) {
            console.log(id);
            window.open('/scores/' + id, '_blank');
        },
    },
    computed: {

        getClassName() {
            return i => {
                if(i > 0) return 'bold_weight_700';
            }
        }
    },
}
</script>

<style scoped>
.bold_weight_700 {
    font-weight: 700;
}
</style>


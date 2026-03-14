<template>
    <div class="w-100 p-3 d-flex justify-content-center align-items-center">
        <div class="d-flex justify-content-start align-items-start flex-column scores">
            <div class="col-12 d-flex justify-content-start align-items-start scoreHistory" v-for="frame in frames">

                <template
                    v-if="frame.break_run_player_1 === frame.break_run_player_2 && frame.increment_in_score === 1">
                    <div class="col-4"></div>
                    <div class=" red "> {{ frame.score_player_1}} </div>
                    <div>-</div>
                    <div class=""> {{ frame.score_player_2 }} </div>
                </template>


                <template
                    v-if="frame.break_run_player_1 === frame.break_run_player_2 && frame.increment_in_score === 2">
                    <div class="col-4"></div>
                    <div class=""> {{ frame.score_player_1 }} </div>
                    <div>-</div>
                    <div class=" red "> {{ frame.score_player_2 }} </div>
                </template>


                <template v-if="frame.break_run_player_1 > frame.break_run_player_2">
                    <div class="green">+1</div>
                    <div class="brkrun left">(Break and Run)</div>
                    <div class=" red "> {{ frame.score_player_1 }} </div>
                    <div>-</div>
                    <div class=""> {{ frame.score_player_2 }} </div>
                </template>


                <template v-if="frame.break_run_player_1 < frame.break_run_player_2">
                    <div class="col-4"></div>
                    <div class=""> {{ frame.score_player_1 }} </div>
                    <div>-</div>
                    <div class=" red "> {{ frame.score_player_2 }} </div>
                    <div class="green">+1</div>
                    <div class="brkrun">(Break and Run)</div>
                </template>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            frames: []
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
            var URL = '/api' + window.location.pathname;
            axios.get(URL)
                .then((response) => {
                    this.frames = response.data.frames;
                    document.getElementsByClassName('scores')[0] .innerHTML = response.data.score;
                    document.getElementsByClassName('status')[0] .innerHTML = response.data.status;
                });
        },
    }
}
</script>


<template>
    <div class="h-screen flex flex-col items-center justify-center">
        <div v-if="loading" class="flex items-center">
            <font-awesome-icon :icon="['fas', 'cog']"
                               spin
                               size="2x"
                               class="mr-2"
            />
            <span v-text="$t('messages.loading')"></span>
        </div>

        <p v-if="!loading && turn === 'player'"
           v-text="$t('messages.your_turn')"
           class="text-lg mb-4">
        </p>

        <board v-if="!loading && game"  :game="game" />

        <div class="flex">
            <button v-if="turn === 'player'" @click="resetGame"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center mt-8 mr-4">
                <span class="mr-2">{{ $t('messages.reset_game') }}</span>
                <font-awesome-icon :icon="['fas', 'sync']" size="lg"/>
            </button>

            <button v-if="gameIsCompleted" @click="startNewGame"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center mt-8">
                <span class="mr-2">{{ $t('messages.new_game') }}</span>
                <font-awesome-icon :icon="['fas', 'gamepad']" size="lg"/>
            </button>
        </div>


        <div v-if="turn === 'ai'" class="flex mt-8 justify-center items-center">
            <div class="mr-3">
                <font-awesome-icon :icon="['fas', 'robot']" size="2x"/>
            </div>
            <span class="text-medium" v-text="$t('messages.thinking')"></span>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import Board from './../components/Board.vue';
    import {fetchGame, reset, newGame} from './../api/games';

    export default {
        components: {Board},

        data() {
            return {
                title: this.$t('messages.gameplay'),
                loading: false,
            }
        },

        head: {
            title() {
                return {
                    inner: this.title
                }
            },
        },

        computed: {
            ...mapState(['turn']),

            game: {
                set(game) {
                    this.$store.commit('SET_CURRENT_GAME', {game});
                },
                get() {
                    return this.$store.state.game;
                }
            },

            gameIsCompleted() {
                return this.game && this.game.completed_at !== null;
            }
        },

        methods: {
            /**
             * Fetch game data.
             *
             * @return {Promise}
             */
            async fetchGame() {
                try {
                    this.loading = true;

                    let {data: {data}} = await fetchGame(this.$route.params.game);
                    this.game = data;

                } catch (error) {
                    this.$toasted.show(error.response.data.message, {
                        type: 'error',
                        position: 'bottom-right',
                        duration: 5000
                    });
                }

                this.loading = false;
            },

            /**
             * Start a new game.
             */
            async startNewGame() {
                try {
                    this.loading = true;

                    let {data: {data}} = await newGame();
                    this.game = data;

                    this.$router.push({name: 'app.game.play', params: {game: data.id}});

                } catch (error) {
                    this.$toasted.show(error.response.data.message, {
                        type: 'error',
                        position: 'bottom-right',
                        duration: 5000
                    });
                }

                this.loading = false;
            },

            /**
             * Reset the game data.
             *
             * @return {Promise}
             */
            async resetGame() {
                try {
                    this.loading = true;

                    let {data: {data}} = await reset(this.$route.params.game);
                    this.game = data;

                } catch (error) {
                    this.$toasted.show(error.response.data.message, {
                        type: 'error',
                        position: 'bottom-right',
                        duration: 5000
                    });
                }

                this.loading = false;
            }
        },

        mounted() {
            if (this.game === null) {
                this.fetchGame();
            }
        }
    }
</script>

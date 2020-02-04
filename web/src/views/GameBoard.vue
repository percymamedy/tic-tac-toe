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

        <p v-if="!loading && !gameIsCompleted"
           v-text=" turn === 'player' ? $t('messages.your_turn') : $t('messages.robot_turn')"
           class="text-lg mb-4">
        </p>

        <p v-if="!loading && gameIsCompleted"
           v-text="results"
           class="text-lg mb-4">
        </p>

        <board v-if="!loading && game"
               :game="game"
               :winning-locations="winningLocations"/>

        <div class="flex">
            <button @click="resetGame"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center mt-8 mr-4"
                    :disabled="turn !== 'player'">
                <span class="mr-2">{{ $t('messages.reset_game') }}</span>
                <font-awesome-icon :icon="['fas', 'sync']" size="lg"/>
            </button>

            <button v-if="gameIsCompleted" @click="startNewGame"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center mt-8">
                <span class="mr-2">{{ $t('messages.new_game') }}</span>
                <font-awesome-icon :icon="['fas', 'gamepad']" size="lg"/>
            </button>
        </div>


        <div class="flex mt-8 justify-center items-center">
            <div class="mr-3">
                <font-awesome-icon :icon="['fas', 'robot']" size="2x"/>
            </div>
            <span v-if="!gameIsCompleted" class="text-medium" v-text="turn === 'ai' ? $t('messages.thinking') : $t('messages.waiting')"></span>
            <span v-if="gameIsCompleted" class="text-medium" v-text="$t('messages.game_over')"></span>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import Board from './../components/Board.vue';
    import {filter, isEmpty, map, first} from 'lodash';
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
            },

            winningCombination() {
                let winningCombinations = [
                    ['A1', 'A2', 'A3'],
                    ['B1', 'B2', 'B3'],
                    ['C1', 'C2', 'C3'],
                    ['A1', 'B1', 'C1'],
                    ['A2', 'B2', 'C2'],
                    ['A3', 'B3', 'C3'],
                    ['A1', 'B2', 'C3'],
                    ['A3', 'B2', 'C1'],
                ]

                for (let i = 0; i < winningCombinations.length; i++) {
                    let combinationCells = filter(this.game.cells, cell => winningCombinations[i].includes(cell.location));

                    // All cells are filled.
                    if ((filter(combinationCells, cell => cell.value !== null).length === combinationCells.length)) {
                        let value = combinationCells[0].value;
                        let equalityCheck = true;

                        for (let j = 0; j < combinationCells.length; j++) {
                            if (combinationCells[j].value !== value) {
                                equalityCheck = false;
                                break;
                            }
                        }

                        if (equalityCheck) {
                            return combinationCells;
                        }
                    }
                }

                return [];
            },

            winningLocations() {
                if (isEmpty(this.winningCombination)) {
                    return [];
                }

                return map(this.winningCombination, 'location');
            },

            results() {
                if (this.gameIsCompleted && isEmpty(this.winningCombination)) {
                    return this.$t('messages.game_draw');
                }

                if (this.gameIsCompleted && first(this.winningCombination).value === 'O') {
                    return this.$t('messages.you_won');
                }

                if (this.gameIsCompleted) {
                    return this.$t('messages.you_lose');
                }

                return '';
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
                    if (error.response.status === 404) {
                        this.$router.push({name: 'app.errors.404', params: {'0': this.$route.params.game}});
                    } else {
                        this.$toasted.show(error.response.data.message, {
                            type: 'error',
                            position: 'bottom-right',
                            duration: 5000
                        });
                    }
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

<template>
    <div class="rounded shadow-lg overflow-hidden w-2/3 lg:w-1/4 h-64">
        <table class="border-solid border-black border-2 table-fixed w-full h-full">
            <tbody>
            <tr v-for="(row, index) in rows" :key="index">
                <td v-for="cell in row"
                    :key="cell.id"
                    class="cursor-pointer border-solid border-black border-2 p-0 text-center"

                    @click="play(cell)">
                    <font-awesome-icon v-if="cell.value && cell.value === 'O'"
                                       :icon="['fas', 'circle']"
                                       :class="[gameIsCompleted && winningLocations.includes(cell.location) ? 'text-green-500' : '' ]"
                                       size="lg"/>

                    <font-awesome-icon v-if="cell.value && cell.value === 'X'"
                                       :icon="['fas', 'times']"
                                       :class="[gameIsCompleted && winningLocations.includes(cell.location) ? 'text-green-500' : '' ]"
                                       size="lg"/>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {chunk} from 'lodash';
    import {play} from './../api/games';
    import Echo from './../plugins/echo';

    export default {
        props: {
            game: {
                type: Object,
                required: true
            },
            winningLocations: {
                type: Array,
                required: false,
                default() {
                    return [];
                }
            }
        },

        data() {
            return {
                player: 'O',
                ai: 'X',
            }
        },

        computed: {
            gameIsCompleted() {
                return this.game && this.game.completed_at !== null;
            },

            rows() {
                return chunk(this.game.cells, 3);
            },

            turn: {
                set(turn) {
                    this.$store.commit('CHANGE_TURN', {turn});
                },
                get() {
                    return this.$store.state.turn;
                }
            }
        },

        methods: {
            /**
             * Player plays a move.
             *
             * @param cell
             *
             * @return {Promise}
             */
            async play(cell) {
                if (this.gameIsCompleted || this.turn !== 'player' || cell.value !== null) {
                    return;
                }

                try {
                    this.$store.commit('UPDATE_CELL_VALUE', {id: cell.id, value: this.player});

                    let {data: {data}} = await play({
                        game: this.game.id,
                        cell: cell.id,
                        value: this.player,
                        opponent: this.ai
                    });

                    this.$store.commit('UPDATE_CELL', {cell: data});
                    this.turn = 'ai';

                } catch (error) {
                    this.$toasted.show(error.response.data.message, {
                        type: 'error',
                        position: 'bottom-right',
                        duration: 5000
                    });
                }
            },

            /**
             * The Ai has moved a piece.
             *
             * @param event
             */
            movePiece({id, value}) {
                setTimeout(() => {
                    this.$store.commit('UPDATE_CELL_VALUE', {id, value});
                    this.turn = 'player';
                }, 100);
            },

            /**
             * Complete the game.
             *
             * @param game
             */
            completeGame(game) {
                setTimeout(() => {
                    this.$store.commit('COMPLETE_THE_GAME', game);
                    this.turn = 'player';
                }, 100);
            }
        },

        mounted() {
            Echo
                .channel(`games.${this.$route.params.game}`)
                .listen('.game.move_played', (e) => this.movePiece(e))
                .listen('.game.draw', (e) => this.completeGame(e))
                .listen('.game.won_by_player', (e) => this.completeGame(e))
                .listen('.game.won_by_robot', (e) => this.completeGame(e));
        }
    }
</script>

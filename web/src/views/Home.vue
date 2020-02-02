<template>
    <div class="h-screen flex items-center justify-center">
        <div class="flex flex-col items-center justify-center">
            <img alt="logo" class="lg:w-1/4 w-2/3 mb-8" src="./../assets/images/logo.gif">

            <button @click="startNewGame"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <span class="mr-2">{{ $t('messages.new_game') }}</span>
                <font-awesome-icon :icon="['fas', 'gamepad']" size="lg"/>
            </button>
        </div>
    </div>
</template>

<script>
    import {newGame} from './../api/games';

    export default {
        data() {
            return {
                title: 'Welcome'
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
            game: {
                set(game) {
                    this.$store.commit('SET_CURRENT_GAME', {game});
                },
                get() {
                    return this.$store.state.game;
                }
            }
        },

        methods: {
            /**
             * Start a new game.
             */
            async startNewGame() {
                try {
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
            }
        }
    }
</script>

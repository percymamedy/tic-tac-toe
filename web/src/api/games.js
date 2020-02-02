import axios from './../http/axios';

/**
 * Create a new game.
 *
 * @return {Promise}
 */
export const newGame = () => axios.post('/games/store', {grid: 3});

export default {
    newGame
}

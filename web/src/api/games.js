import axios from './../http/axios';

/**
 * Create a new game.
 *
 * @return {Promise}
 */
export const newGame = () => axios.post('/games/store', {grid: 3});

/**
 * Fetch game data.
 *
 * @param game
 *
 * @return {Promise}
 */
export const fetchGame = (game) => axios.get(`/games/${game}`);

/**
 * Player plays a move.
 *
 * @param game
 * @param cell
 * @param value
 * @param opponent
 *
 * @return {Promise}
 */
export const play = ({game, cell, value, opponent}) => axios.put(`/games/${game}/cells/${cell}`, {value, opponent});

/**
 * Reset a game.
 *
 * @param game
 *
 * @return {Promise}
 */
export const reset = (game) => axios.put(`/games/${game}/reset`)

export default {
    newGame,
    fetchGame,
    play,
    reset
}

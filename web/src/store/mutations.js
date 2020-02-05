import {findIndex, set} from 'lodash';

export default {
    SET_CURRENT_GAME: (state, {game}) => state.game = game,

    CHANGE_TURN: (state, {turn}) => state.turn = turn,

    COMPLETE_THE_GAME: (state, {completed_at}) => state.game.completed_at = completed_at,

    UPDATE_CELL: (state, {cell}) => {
        let index = findIndex(state.game.cells, {id: cell.id});

        if (index >= 0) {
            state.game.cells[index] = cell;
        }
    },

    UPDATE_CELL_VALUE: (state, {id, value}) => {
        let index = findIndex(state.game.cells, {id});

        if (index >= 0) {
            set(state.game.cells, [index, 'value'], value);
        }
    }
}

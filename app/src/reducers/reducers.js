import { SET_TASKS } from './actions';
function tasksReducer(state = {}, action) {
	switch (action.type) {
		case SET_TASKS:
			state = JSON.parse(JSON.stringify(action.payload));
			return state;
		default:
			return state
	}
}
export { tasksReducer };
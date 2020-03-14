import { SET_TASKS } from './actions';
const setTasks = (tasks) => {
	return {
		type: SET_TASKS,
		payload: tasks
	}
};
export { setTasks };
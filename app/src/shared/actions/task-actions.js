import { httpConfig } from '../utils/http-config'
import {getStepByStepTaskId} from "./step-actions";
import _ from "lodash";
import {getKidByKidUsername} from "./kid-account-actions";

export const getTaskByTaskId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/task-api/?taskId=${id}`);
	dispatch({ type: 'GET_TASK_BY_TASK_ID', payload: data })
};

export const getTaskByTaskAdultId = (taskAdultId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/task-api/?taskAdultId=${taskAdultId}`);
	dispatch({ type: 'GET_TASK_BY_TASK_ADULT_ID', payload: data })
};

export const getTaskByTaskKidId = (taskKidId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/task-api/?taskKidId=${taskKidId}`);
	dispatch({ type: 'GET_TASK_BY_TASK_KID_ID', payload: data })
};

export const getTaskByTaskContent = (taskContent) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/task-api/?taskContent=${taskContent}`);
	dispatch({ type: 'GET_TASK_BY_TASK_TASK_CONTENT', payload: data })
};

export const getTasksAndSteps = (taskKidId) => async (dispatch, getState) => {

	await dispatch(getTaskByTaskKidId(taskKidId));
	//commented out lines below are equivalent to the _ chain method

	const taskIds = _.uniq(_.map(getState().tasks, "taskId"));

	taskIds.forEach(id => dispatch(getStepByStepTaskId(id)));
};

export const getTaskAndStepsByKidUsername = (kidUsername) => async (dispatch, getState) => {
	await dispatch(getKidByKidUsername(kidUsername));

	const kid = getState().kids.find(kid => kid.kidUsername===kidUsername);

	if (kid !== undefined) {
		await dispatch(getTasksAndSteps(kid.kidId));
	}
};
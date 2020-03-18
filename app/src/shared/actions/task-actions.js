import { httpConfig } from '../utils/http-config'

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


import { httpConfig } from '../utils/http-config'

export const getTaskByTaskId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?taskId=${Id}');
	dispatch({ type: 'GET_TASK_BY_TASK_ID', payload: data })
};

export const getTaskByTaskAdultId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?taskAdultId=${taskAdultId}');
	dispatch({ type: 'GET_TASK_BY_TASK_ADULT_ID', payload: data })
};

export const getTaskByTaskKidId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?taskKidId=${taskKidId}');
	dispatch({ type: 'GET_TASK_BY_TASK_KID_ID', payload: data })
};

export const getTaskByTaskContent = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?taskContent=${taskContent}');
	dispatch({ type: 'GET_TASK_BY_TASK_TASK_CONTENT', payload: data })
};


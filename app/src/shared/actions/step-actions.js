import { httpConfig } from '../utils/http-config'

export const getStepByStepId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?stepId=${Id}');
	dispatch({ type: 'GET_STEP_BY_STEP_ID', payload: data })
};

export const getStepByStepTaskId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?stepTaskId=${stepTaskId}');
	dispatch({ type: 'GET_STEP_BY_STEP_TASK_ID', payload: data })
};
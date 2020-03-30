import { httpConfig } from '../utils/http-config'

export const getStepByStepId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/step/?stepId=${id}`);
	dispatch({ type: 'GET_STEP_BY_STEP_ID', payload: data })
};

export const getStepByStepTaskId = (stepTaskId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/step/?stepTaskId=${stepTaskId}`);
	dispatch({ type: 'GET_STEP_BY_STEP_TASK_ID', payload: data })
};
import { httpConfig } from '../utils/http-config'

export const getKidByKidId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/kid-account/?kidId=${id}`);
	dispatch({ type: 'GET_KID_BY_KID_ID', payload: data })
};

export const getKidByKidAdultId = (kidAdultId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/kid-account/?kidAdultId=${kidAdultId}`);
	dispatch({ type: 'GET_KID_BY_KID_ADULT_ID', payload: data })
};

export const getKidByKidUsername = (kidUsername) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/kid-account/?kidUsername=${kidUsername}`);
	dispatch({ type: 'GET_KID_BY_KID_USERNAME', payload: data })
};
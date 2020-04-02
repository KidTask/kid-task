import { httpConfig } from '../utils/http-config'

export const getKidByKidId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/kid-account/?kidId=${id}`);
	dispatch({ type: 'GET_KID_BY_KID_ID', payload: data })
};

export const getKidByKidAdultId = (kidAdultId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/kid-account/?kidAdultId=${kidAdultId}`);
	dispatch({ type: 'GET_KID_BY_KID_ADULT_ID', payload: data })
};
export const getKidName = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/kid-account/?kidUsername=${kidName}');
	dispatch({ type: 'GET_KID_USERNAME', payload: data })
};
import { httpConfig } from '../utils/http-config'

export const getKidByKidId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidId=${Id}');
	dispatch({ type: 'GET_KID_BY_KID_ID', payload: data })
};

export const getKidByKidAdultId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidAdultId=${kidAdultId}');
	dispatch({ type: 'GET_KID_BY_KID_ADULT_ID', payload: data })
};

export const getKidUsername = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidUsername=${kidUsername}');
	dispatch({ type: 'GET_KID_USERNAME', payload: data })
};

export const getKidAvatarUrl = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidAvatarUrl=${kidAvatarUrl}');
	dispatch({ type: 'GET_KID_AVATAR_URL', payload: data })
};

export const getKidName = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidName=${kidName}');
	dispatch({ type: 'GET_KID_NAME', payload: data })
};

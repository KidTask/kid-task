import { httpConfig } from '../utils/http-config'

export const getAdultByAdultUsername = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?adultUsername=${adultUsername}')
	dispatch({ type: 'GET_ADULT_BY_ADULT_USERNAME', payload: data })
};

export const getAdultByAdultId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?${adultId}')
	dispatch({ type: 'GET_ADULT_BY_ADULT_ID', payload: data })
};

export const getKidByKidUsername = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?kidUsername=${kidUsername}')
	dispatch({ type: 'GET_KID_BY_KID_USERNAME', payload: data })
};

export const getKidByKidId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/${kidId}')
	dispatch({ type: 'GET_KID_BY_KID_ID', payload: data })
};
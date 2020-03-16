import { httpConfig } from '../utils/http-config'

export const getAdultByAdultId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?adultId=${adultId}')
	dispatch({ type: 'GET_ADULT_BY_ADULT_ID', payload: data })
};

export const getAdultUsername = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?adultUsername=${adultUsername}')
	dispatch({ type: 'GET_ADULT_USERNAME', payload: data })
};

export const getAdultAvatarUrl = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?adultAvatarUrl=${adultAvatarUrl}')
	dispatch({ type: 'GET_ADULT_AVATAR_URL', payload: data })
};

export const getAdultName = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/sign-in/?adultName=${adultName}')
	dispatch({ type: 'GET_ADULT_NAME', payload: data })
};

import { adultConstants } from '../_constants';

let adult = JSON.parse(localStorage.getItem('adult'));
const initialState = adult ? { loggedIn: true, adult } : {};

export function authentication(state = initialState, action) {
    switch (action.type) {
        case adultConstants.LOGIN_REQUEST:
            return {
                loggingIn: true,
                adult: action.adult
            };
        case adultConstants.LOGIN_SUCCESS:
            return {
                loggedIn: true,
                adult: action.adul
            };
        case adultConstants.LOGIN_FAILURE:
            return {};
        case adultConstants.LOGOUT:
            return {};
        default:
            return state
    }
}
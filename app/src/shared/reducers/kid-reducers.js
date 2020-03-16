export default (state = [], action) => {
    switch(action.type) {
        case "GET_KID_BY_KID_ID":
            return [...state, action.payload];
        case "GET_KID_BY_KID_ADULT_ID":
            return [...state, action.payload];
        case "GET_KID_USERNAME":
            return action.payload;
        case "GET_KID_AVATAR_URL":
            return action.payload;
        case "GET_KID_NAME":
            return action.payload;
        default:
            return state;
    }
}
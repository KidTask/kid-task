export default (state = [], action) => {
    switch(action.type) {
        case "GET_ADULT_BY_ADULT_ID":
            return [...state, action.payload];
        case "GET_ADULT_USERNAME":
            return action.payload;
        case "GET_ADULT_AVATAR_URL":
            return action.payload;
        case "GET_ADULT_NAME":
            return action.payload;
        default:
            return state;
    }
}
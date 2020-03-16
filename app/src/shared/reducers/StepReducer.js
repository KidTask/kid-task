export default (state = [], action) => {
    switch(action.type) {
        case "GET_ALL_STEPS":
            return action.payload;
        default:
            return state;
    }
}
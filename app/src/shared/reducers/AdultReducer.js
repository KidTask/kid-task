export default (state = [], action) => {
    switch(action.type) {
        case "GET_ALL_ADULTS":
            return action.payload;
        default:
            return state;
    }
}
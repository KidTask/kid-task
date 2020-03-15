export default (state = [], action) => {
    switch(action.type) {
        case "GET_ALL_KIDS":
            return action.payload;
        default:
            return state;
    }
}
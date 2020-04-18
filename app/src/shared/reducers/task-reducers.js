export default (state = [], action) => {
    switch(action.type) {
        case "UPDATE_TASK_IS_COMPLETE":
            return action.payload;
        case "GET_TASK_BY_TASK_ID":
            return [...state, action.payload];
        case "GET_TASK_BY_TASK_ADULT_ID":
            return [action.payload];
        case "GET_TASK_BY_TASK_KID_ID":
            return action.payload;
        case "GET_TASK_BY_TASK_CONTENT":
            return action.payload;
        default:
            return state;
    }
}
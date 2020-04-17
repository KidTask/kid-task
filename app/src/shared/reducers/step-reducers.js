export default (state = [], action) => {
    switch(action.type) {
        case "GET_STEP_BY_STEP_ID":
            return [...state, action.payload];
        case "GET_STEP_BY_STEP_TASK_ID":
            return [...action.payload, ...state];
        default:
            return state;
    }
}
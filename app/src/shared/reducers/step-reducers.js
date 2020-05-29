export default (state = [], action) => {
    console.log(state)
    switch(action.type) {
        case "GET_STEP_BY_STEP_ID":
            return [...state, action.payload];
        case "GET_STEP_BY_STEP_TASK_ID":
            return [...action.payload, ...state];
        case "CLEAR_STEPS":
            return [];
        default:
            return state;
    }
}
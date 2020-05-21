import {combineReducers} from "redux"
import AdultReducer from "./adult-reducers";
import KidReducer from "./kid-reducers";
import TaskReducer from "./task-reducers";
import StepReducer from "./step-reducers";

export default combineReducers({
    adult: AdultReducer,
    kids: KidReducer,
    tasks: TaskReducer,
    steps: StepReducer,
});
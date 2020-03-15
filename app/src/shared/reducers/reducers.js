import {combineReducers} from "redux"
import KidReducer from "./KidReducer";
import UserPostsReducer from "./user-posts-reducer"

export const reducers = combineReducers({
    kids: KidReducer,
    userPosts: UserPostsReducer,
});
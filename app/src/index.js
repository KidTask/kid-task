import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {TaskForm} from "./pages/TaskForm";
import {KidSignUp} from "./pages/KidSignUp";
import {SignUp} from "./pages/SignUp";
import {Kid} from "./pages/Kid";
import './index.css';
import App from './App';
import * as serviceWorker from './serviceWorker';
import { tasksReducer } from '../src/reducers/reducers';
import { Provider } from 'react-redux'
import { createStore, combineReducers } from 'redux'


const taskskApp = combineReducers({
	tasks: tasksReducer,
})
const store = createStore(taskskApp);
ReactDOM.render(
	<Provider store={store}>
		<App />
	</Provider>
	, document.getElementById('root'));

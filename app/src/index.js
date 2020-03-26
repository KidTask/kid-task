import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {KidSignUp} from "./pages/KidSignUp";
import {SignUp} from "./pages/SignUp";
import {Kid} from "./pages/KidDashboard";
import {AdultDashboard} from "./pages/AdultDashboard";
import {CreateTask} from "./pages/CreateTask";
import {Home} from "./pages/Home";
import axios from "axios";
import {applyMiddleware, createStore} from "redux";
import {reducers} from "./shared/reducers/reducers";
import thunk from "redux-thunk";
import {Provider} from "react-redux";

axios.get("/apis/earl-grey/");


const store = createStore(reducers, applyMiddleware(thunk));

const Routing = () => (

	<>
		<Provider store={store}>

			<BrowserRouter>
				<Switch>
					<Route exact path="/create-task/:kidUsername" component={CreateTask} kidUsername=":kidUsername"/>
					<Route exact path="/adult-dashboard" component={AdultDashboard}/>
					<Route exact path="/kid-dashboard" component={Kid}/>
					<Route exact path="/kid-sign-up/:adultUsername" component={KidSignUp} adultUsername=":adultUsername"/>
					<Route exact path="/adult-sign-up" component={SignUp}/>

					<Route exact path="/" component={Home}/>

					<Route component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));

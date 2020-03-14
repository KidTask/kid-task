import React from 'react';
import { Router, Route, Link } from "react-router-dom";
import TaskForm from '/app/src/pages/TaskForm';
import { createBrowserHistory as createHistory } from 'history'
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import './App.css';
const history = createHistory();

function App() {
	return (
		<div className="App">
			<Router history={history}>
				<Navbar bg="primary" expand="lg" variant="dark" >
					<Navbar.Brand href="#home">Drag and Drop App</Navbar.Brand>
					<Navbar.Toggle aria-controls="basic-navbar-nav" />
					<Navbar.Collapse id="basic-navbar-nav">
						<Nav className="mr-auto">
							<Nav.Link href="/">Home</Nav.Link>
						</Nav>
					</Navbar.Collapse>
				</Navbar>
				<Route path="/" exact component={TaskForm} />
			</Router>
		</div>
	);
}
export default App;
import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";


//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const Home = () => {
	return (
		<>
			<div className="container">
				<div className="row">
					<Header/>
				</div>
				<div className="row">
					<Tasks/>
				</div>
				<div className="row">
					<Footer/>
				</div>
			</div>
		</>
	)
};
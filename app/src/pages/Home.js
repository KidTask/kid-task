import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {LoginFormContent} from "../shared/components/login/LoginFormContent";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const Home = () => {
	return (
		<>
			<Header/>
			<div className="container">
				<div className="row">
					<div className="col-lg-5  mx-auto mt-5">
						<div className="card w-lg-50">
							<div className="card-body">
								<h5 className="card-title">Sign in!</h5>
								<LoginFormContent/>
							</div>
						</div>
					</div>
				</div>
				<div className="row">
					<div className="col-lg-5  mx-auto mt-5">
						<div className="card w-lg-50">
							<div className="card-body">
								<h5 className="card-title">Not yet part of the Club?</h5>
								<p><a>Sign up for Kid Task</a></p>
							</div>
						</div>
					</div>
				</div>


				<div className="row">
					<Footer/>
				</div>
			</div>
		</>
	)
};
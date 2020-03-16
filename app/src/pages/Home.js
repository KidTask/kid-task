import React from "react"


import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {LoginForm} from "../shared/components/login/LoginForm";
import {SignUp} from "./SignUp";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from "axios"

export const Home = () => {
	axios.get("/apis/earl-grey/");
	return (
		<>
			<Header/>
			<div className="container">
				<div className="row">
					<div className="col-lg-5  mx-auto mt-5">
						<div className="card w-lg-50">
							<div className="card-body">
								<h5 className="card-title">Sign in!</h5>
								<LoginForm/>
							</div>
						</div>
					</div>
				</div>
				<div className="row sign-in-margin">
					<div className="col-lg-5  mx-auto mt-5">
						<div className="card w-lg-50">
							<div className="card-body">
								<h5 className="card-title">Not yet part of the Club?</h5>
								<p><a href="/adult-sign-up">Register your family or team for Kid Task.</a></p>
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
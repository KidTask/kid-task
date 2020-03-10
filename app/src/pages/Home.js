import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {LoginFormContent} from "../shared/components/login/LoginFormContent";

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
					<div className="col-lg-6">
						<div className="card" style={{ width: "18rem" }}>
							<div className="card-body">
								<h5 className="card-title">Kid Task</h5>

								<LoginFormContent/>

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
}
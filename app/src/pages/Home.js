import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";


export const Home = () => {
	return (
		<>
			<div className="container">
				<div className="row">
					<Header/>
				</div>
				<div className="row">
					<div className="col-lg-8">
						<h1>Home</h1>
					</div>
				</div>
				<div className="row">
					<Footer/>
				</div>
			</div>
		</>
	)
}
import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {Col} from "react-bootstrap";
import {Image} from "react-bootstrap";
import {TaskPreview} from "../shared/components/task/TaskPreview";


export const Kid = () => {
	return (
		<>
			<Header/>
			<div className="container">
				<div className="row">
					<div className="mx-auto my-5">
						<h5><span>Kid</span>'s Dashboard</h5>
					</div>
				</div>

				<div className="row mb-6 pb-5" >

					<TaskPreview/>
					<TaskPreview/>
					<TaskPreview/>

				</div>


				<div className="row">
					<Footer/>
				</div>
			</div>
			</>
			)
			};
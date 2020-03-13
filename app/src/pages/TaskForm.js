import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";

import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Container from "react-bootstrap/Container";
import Button from "react-bootstrap/Button";


import 'bootstrap/dist/css/bootstrap.min.css';

export const TaskForm = () => {
	return (
		<>
			<div className="mb-5">
				<Header />
			</div>

			<Container>
				<InputGroup className="mx-auto mb-3">
					<InputGroup.Prepend>
						<InputGroup.Text id="inputGroup-sizing-default">Task</InputGroup.Text>
					</InputGroup.Prepend>
					<FormControl
						aria-label="Default"
						aria-describedby="inputGroup-sizing-default"
					/>
					<Button
						as={InputGroup.Append}
						variant="outline-secondary"
						title="Add Steps"
						id="add-step-button"
					>+ Add Step
					</Button>
				</InputGroup>



			</Container>
			<div className="row mt-3">
				<Footer/>
			</div>
		</>
			)
};

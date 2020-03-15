import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import {FormDebugger} from "../FormDebugger";


export const LoginFormContent =
	(props) => {
		const {
			submitStatus,
			values,
			errors,
			touched,
			dirty,
			isSubmitting,
			handleChange,
			handleBlur,
			handleSubmit,
			handleReset
		} = props;

	return (
		<>
			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
				<Form.Group controlId="adultUsername">
					<Form.Label>Username</Form.Label>
					<input
						className="form-control"
						type="username"
						id="username"
						placeholder="Enter Username"
						value={values.adultUsername}
						onChange={handleChange}
						onBlur={handleBlur}
					/>
				</Form.Group>


				{/*controlId must match what is defined by the initialValues object*/}


				<Form.Group controlId="password">
					<Form.Label>Password</Form.Label>
					<Form.Control type="text" size="sm" placeholder="Enter Password"/>
				</Form.Group>
				<div className="row mt-4">
					<div className="col-6">
						<Form.Group controlId="formBasicCheckbox">
							<Form.Check type="checkbox" size="sm" label="Keep me logged in"/>
						</Form.Group>
					</div>
					<div className="col-6">
						<Button variant="outline-primary" size="sm" type="submit">Submit</Button>
					</div>
				</div>

				<FormDebugger {...props} />
			</form>
		</>
	)
};
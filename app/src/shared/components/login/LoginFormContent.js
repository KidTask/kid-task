import React from "react";
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import {FormDebugger} from "../FormDebugger";


export const LoginFormContent = (props) => {
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
				<div className="form-group">
					<label htmlFor="adultUsername">Username</label>
					<div className="input-group">
						<input
							className="form-control"
							type="text"
							id="adultUsername"
							placeholder="Username"
							value={values.adultUsername}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.adultUsername && touched.adultUsername && (
							<div className="alert alert-danger">
								{errors.adultUsername}
							</div>
						)
					}
				</div>


				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="adultPassword">Password</label>
					<div className="input-group" >

						<input
							id="adultPassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.adultPassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.adultPassword && touched.adultPassword && (
						<div className="alert alert-danger">{errors.adultPassword}</div>
					)}
				</div>


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
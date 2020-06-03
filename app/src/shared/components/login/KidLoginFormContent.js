import React from "react";
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import {FormDebugger} from "../FormDebugger";


export const KidLoginFormContent = (props) => {
	const {
		submitStatus,
		status,
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
					<label htmlFor="kidUsername">Username</label>
					<div className="input-group">
						<input
							className="form-control"
							type="text"
							id="kidUsername"
							placeholder="Username"
							value={values.kidUsername}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.kidUsername && touched.kidUsername && (
							<div className="alert alert-danger">
								{errors.kidUsername}
							</div>
						)
					}
				</div>

				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="kidPassword">Password</label>
					<div className="input-group" >

						<input
							id="kidPassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.kidPassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.kidPassword && touched.kidPassword && (
						<div className="alert alert-danger">{errors.kidPassword}</div>
					)}
				</div>


				<div className="row py-2 mt-4 mx-3">
					<Button variant="primary" size="sm" type="submit">Sign In</Button>
				</div>
				{/*<FormDebugger {...props} />*/}
			</form>
			{status && <div className={status.type}>{status.message}</div>}
		</>
	)
};
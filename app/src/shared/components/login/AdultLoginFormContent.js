import React from "react";
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import {FormDebugger} from "../FormDebugger";


export const AdultLoginFormContent = (props) => {
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
					<label htmlFor="adultUsername">Username</label>
					<div className="input-group">
						<input
							className="form-control"
							type="text"
							id="adultUsername"
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
							value={values.adultPassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.adultPassword && touched.adultPassword && (
						<div className="alert alert-danger">{errors.adultPassword}</div>
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
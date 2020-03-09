import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../FormDebugger";
import React from "react";


export const LoginFormContent = (props) => {
    const {
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
                    <label htmlFor="adultEmail">Email Address</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="envelope"/>
                            </div>
                        </div>

                        <input
                            className="form-control"
                            id="adultEmail"
                            type="email"
                            value={values.adultEmail}
                            placeholder="Enter email"
                            onChange={handleChange}
                            onBlur={handleBlur}

                        />
                    </div>
                    {
                        errors.adultEmail && touched.adultEmail && (
                            <div className="alert alert-danger">
                                {errors.adultEmail}
                            </div>
                        )
                    }
                </div>

                {/*controlId must match what is defined by the initialValues object*/}
                <div className="form-group">
                    <label htmlFor="adultPassword">Password</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="key"/>
                            </div>
                        </div>
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

                <div className="form-group">
                    <button className="btn btn-primary mb-2" type="submit">Submit</button>
                    <button
                        className="btn btn-danger mb-2"
                        onClick={handleReset}
                        disabled={!dirty || isSubmitting}
                    >Reset
                    </button>
                </div>

                <FormDebugger {...props} />
            </form>
            {status && (<div className={status.type}>{status.message}</div>)}
        </>
    )
};
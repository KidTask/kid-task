import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";
import React from "react";
import { Route } from 'react-router-dom'
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {library} from "@fortawesome/fontawesome-svg-core";
import {faLock, faUser, faCheck} from "@fortawesome/free-solid-svg-icons";

library.add(faEnvelope, faUser, faLock, faCheck);

export const SignUpFormContent = (props) => {
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
        handleReset,
       status
    } = props;
    return (
        <>
            <form onSubmit={handleSubmit}>
                {/*controlId must match what is passed to the initialValues prop*/}
                <div className="form-group">
                    <label htmlFor="adultEmail">Email Address</label>
                    <label className="required">*</label>
                    <div className="input-group">
                        <input
                            className="form-control"
                            id="adultEmail"
                            type="email"
                            value={values.adultEmail}
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

                <div className="form-group">
                    <label htmlFor="adultUsername">Username</label>
                    <label className="required">*</label>
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
                    <label className="required">*</label>
                    <div className="input-group">
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
                <div className="form-group">
                    <label htmlFor="adultPasswordConfirm">Confirm Your Password</label>
                    <label className="required">*</label>
                    <div className="input-group">
                        <input

                            className="form-control"
                            type="password"
                            id="adultPasswordConfirm"
                            value={values.adultPasswordConfirm}
                            onChange={handleChange}
                            onBlur={handleBlur}
                        />
                    </div>
                    {errors.adultPasswordConfirm && touched.adultPasswordConfirm && (
                        <div className="alert alert-danger">{errors.adultPasswordConfirm}</div>
                    )}
                </div>


                <div className="form-group my-5">
                        <button className="btn btn-primary mb-2" type='submit'>Submit</button>
                </div>

                {/*<FormDebugger {...props} />*/}
            </form>
            {console.log(
                submitStatus
            )}
            {
                status && (<div className={status.type}>{status.message}</div>)
            }
        </>


    )
};
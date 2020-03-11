import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";
import React from "react";

export const KidSignUpFormContent = (props) => {
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
                    <label htmlFor="kidUsername">Kid Username</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="envelope"/>
                            </div>
                        </div>
                        <input
                            className="form-control"
                            id="kidUsername"
                            type="username"
                            value={values.kidUsername}
                            placeholder="Enter username"
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
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="key"/>
                            </div>
                        </div>
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
                <div className="form-group">
                    <label htmlFor="kidPasswordConfirm">Confirm Your Password</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="key"/>
                            </div>
                        </div>
                        <input

                            className="form-control"
                            type="password"
                            id="kidPasswordConfirm"
                            placeholder="Password Confirm"
                            value={values.kidPasswordConfirm}
                            onChange={handleChange}
                            onBlur={handleBlur}
                        />
                    </div>
                    {errors.kidPasswordConfirm && touched.kidPasswordConfirm && (
                        <div className="alert alert-danger">{errors.kidPasswordConfirm}</div>
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
            {console.log(
                submitStatus
            )}
            {
                submitStatus && (<div className={submitStatus.type}>{submitStatus.message}</div>)
            }
        </>


    )
};
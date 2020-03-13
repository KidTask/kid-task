import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";
import React from "react";
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {library} from "@fortawesome/fontawesome-svg-core";
import {faChild, faUser, faLock, faCheck} from "@fortawesome/free-solid-svg-icons";

library.add(faChild, faEnvelope, faUser, faLock, faCheck);

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
                    <label htmlFor="kidName">Kid Name</label>
                    <label className="required">*</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <i><FontAwesomeIcon icon={faChild} size="sm"/></i>
                            </div>
                        </div>
                        <input
                            className="form-control"
                            id="kidName"
                            type="name"
                            value={values.kidName}
                            placeholder="Enter name"
                            onChange={handleChange}
                            onBlur={handleBlur}

                        />
                    </div>
                    {
                        errors.kidName && touched.kidName && (
                            <div className="alert alert-danger">
                                {errors.kidName}
                            </div>
                        )

                    }
                </div>


                <div className="form-group">
                    <label htmlFor="kidUsername">Kid Login Username</label>
                    <label className="required">*</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <i><FontAwesomeIcon icon={faUser} size="sm"/></i>
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
                    <label className="required">*</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <i><FontAwesomeIcon icon={faLock} size="sm"/></i>
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
                    <label htmlFor="kidPasswordConfirm">Confirm Password</label>
                    <label className="required">*</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <i><FontAwesomeIcon icon={faCheck} size="sm"/></i>
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
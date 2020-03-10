import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";


export const LoginFormContent = () => {
    return (
        <>
            <form>
                {/*controlId must match what is passed to the initialValues prop*/}
                <div className="form-group">
                    <label htmlFor="adultUsername">Username</label>
                    <div className="input-group">
                        <div className="input-group-prepend">
                            <div className="input-group-text">
                                <FontAwesomeIcon icon="envelope"/>
                            </div>
                        </div>

                        <input
                            className="form-control"
                            id="adultUsername"
                            type="text"
                        />
                    </div>

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
                        />
                    </div>
                </div>

                <div className="form-group">
                    <button className="btn btn-primary mb-2" type="submit">Submit</button>

                </div>

            </form>
        </>
    )
};
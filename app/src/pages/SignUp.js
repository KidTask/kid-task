import React from "react"
import {Header} from "../shared/components/header/Header";
import {SignUpForm} from "../shared/components/header/sign-up/SignUpForm";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const SignUp = () => {
    return (
        <>
            <Header/>
            <div className="container">
                <div content="Spacing">
                    <div className="container">
                                <div className="row my-4">
                                    <div className="card-body py-3">
                                    <h5 className="card-title py-3">Register For An Account</h5>
                                    <SignUpForm/>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </>
    )
};

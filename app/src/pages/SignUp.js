import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {SignUpForm} from "../../src/shared/components/header/sign-up/SignUpForm";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const SignUp = () => {
    return (
        <>
            <Header/>
            <div content="Spacing">
                <div className="container">
                    <div className="col-lg-5  mx-auto mt-5">
                        <div className="card w-lg-50">
                            <div className="row my-4">
                                <div className="card-body">
                                <h5 className="card-title">Register For An Account</h5>
                                <SignUpForm/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer/>
        </>
    )
};

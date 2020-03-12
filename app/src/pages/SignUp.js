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
            <div className="container">
                <div className="row">
                    <h5 className="card-title">Kid Task</h5>
                    <SignUpForm/>
                </div>
            </div>
            <Footer/>
        </>
    )
};

import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {SignUpFormContent} from "../shared/components/header/sign-up/SignUpFormContent";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const SignUp = () => {
    return (
        <>
            <Header/>
            <div className="container">
                <div className="row">
                    <h5 className="card-title">Kid Task</h5>
                    <SignUpFormContent/>
                </div>
            </div>
            <Footer/>
        </>
    )
};

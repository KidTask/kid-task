import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {KidSignUpForm} from "../../src/shared/components/header/sign-up/KidSignUpForm";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const KidSignUp = () => {
    return (
        <>
            <Header/>
            <div className="container">
                <div className="row">
                    <h5 className="card-title">Kid Sign Up Page</h5>
                </div>
                <KidSignUpForm/>
            </div>
            <Footer/>
        </>
    )
};

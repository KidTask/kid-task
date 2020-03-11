import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {KidSignUpFormContent} from "../../src/shared/components/header/sign-up/KidSignUpFormContent";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const KidSignUp = () => {
    return (
        <>
            <Header/>
            <div className="container">
                <div className="row">
                    <h5 className="card-title">Kid Task</h5>
                    <KidSignUpFormContent/>
                </div>
            </div>
            <Footer/>
        </>
    )
};

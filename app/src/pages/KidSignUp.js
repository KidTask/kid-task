import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {KidSignUpForm} from "../shared/components/header/sign-up/KidSignUpForm";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const KidSignUp = ({match}) => {
    return (
        <>
            <Header/>
            <div className="container">
                <div content="Spacing">
                    <div className="container">
                                <div className="row my-4">
                                    <div className="card-body py-3">
                                        <h5 className="card-title py-3">Register For An Account</h5>
                                        <KidSignUpForm match={match}/>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </>
    )
};

import React from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {KidSignUpForm} from "../../src/shared/components/header/sign-up/KidSignUpForm";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

export const KidSignUp = ({match}) => {
    return (
        <>
            <Header/>
            <div className="container">
                <div content="Spacing">
                    <div className="container">
                        <div className="col-lg-5  mx-auto mt-5">
                            <div className="card w-lg-50">
                                <div className="row my-4">
                                    <div className="card-body">
                                        <h5 className="card-title">Register For An Account</h5>
                                        <KidSignUpForm match={match}/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row sign-in-margin">
                </div>
                <div className="row">
                    <Footer/>
                </div>
            </div>
        </>
    )
};

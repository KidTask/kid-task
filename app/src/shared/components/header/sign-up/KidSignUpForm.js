import React, {useState} from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";
import {KidSignUpFormContent} from "./KidSignUpFormContent";
import {useHistory} from "react-router";


export const KidSignUpForm = ({match}) => {
    const signUp = {
        kidName: "",
        kidUsername: "",
        kidPassword: "",
        kidPasswordConfirm: "",
    };

    const history = useHistory();

    const validator = Yup.object().shape({
        kidName: Yup.string()
            .required("Name is required")
            .min(3, "Name must be at least three characters long."),
        kidUsername: Yup.string()
            .required("Username is required")
            .min(3, "Username must be at least four characters"),
        kidPassword: Yup.string()
            .required("Password is required")
            .min(4, "Password is too short"),
        kidPasswordConfirm: Yup.string()
            .required("Password Confirm is required")
            .min(4, "Password is too short"),
    });

    const submitSignUp = (values, {resetForm, setStatus}) => {
        const request = {...values, adultUsername:match.params.adultUsername};
        httpConfig.post("/apis/kid-sign-up/", request)
            .then(reply => {
                    let {message, type} = reply;
                    if(reply.status === 200) {
                        resetForm();
                        setTimeout(() => history.push("/adult-dashboard"), 3000);
                    }
                   setStatus({message, type})
               }
            );
    };


    return (

        <Formik
            initialValues={signUp}
            onSubmit={submitSignUp}
            validationSchema={validator}
        >
            {KidSignUpFormContent}
        </Formik>

    )
};
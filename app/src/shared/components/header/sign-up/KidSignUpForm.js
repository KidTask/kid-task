import React, {useState} from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";
import {KidSignUpFormContent} from "./KidSignUpFormContent";


export const KidSignUpForm = () => {
    const signUp = {
        kidUsername: "",
        kidPassword: "",
        kidPasswordConfirm: "",
    };

    const [status, setStatus] = useState(null);
    const validator = Yup.object().shape({
        kidUsername: Yup.string()
            .required("Username is required")
            .min(4, "Username must be at least four characters"),
        kidPassword: Yup.string()
            .required("Password is required")
            .min(8, "Password must be at least eight characters"),
        kidPasswordConfirm: Yup.string()
            .required("Password Confirm is required")
            .min(8, "Password must be at least eight characters"),
    });

    const submitSignUp = (values, {resetForm}) => {
        httpConfig.post("/apis/sign-up/", values)
            .then(reply => {
                    let {message, type} = reply;
                    setStatus({message, type});
                    if(reply.status === 200) {
                        resetForm();
                    }
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
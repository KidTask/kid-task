import React from 'react';
import {httpConfig} from "../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {LoginFormContent} from "./LoginFormContent";

export const LoginForm = () => {
   const validator = Yup.object().shape({
      adultUsername: Yup.string()
         .required("username is required"),
      adultPassword: Yup.string()
         .required("Password is required")
   });


    //the initial values object defines what the request payload is.
    const login = {
        adultUsername: "",
        adultPassword: ""
    };

    const submitLogin = (values, {resetForm, setStatus}) => {
        httpConfig.post("/apis/adult-sign-in/", values)
            .then(reply => {
                let {message, type} = reply;
                setStatus({message, type});
                if(reply.status === 200 && reply.headers["x-jwt-token"]) {
                    window.localStorage.removeItem("jwt-token");
                    window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
                    resetForm();
                }
            });
    };

    return (
        <>
            <Formik
                initialValues={login}
                onSubmit={submitLogin}
                validationSchema={validator}
            >
                {LoginFormContent}
            </Formik>
        </>
    )
};
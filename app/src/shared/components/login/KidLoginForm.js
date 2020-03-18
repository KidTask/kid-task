import React from 'react';
import {httpConfig} from "../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {KidLoginFormContent} from "./KidLoginFormContent";
import {useHistory} from "react-router";

export const KidLoginForm = () => {
	const validator = Yup.object().shape({
		kidUsername: Yup.string()
			.required("username is required"),
		kidPassword: Yup.string()
			.required("Password is required")
	});

	const history = useHistory();
	console.log(history);


	//the initial values object defines what the request payload is.
	const login = {
		kidUsername: "",
		kidPassword: ""
	};

	const submitLogin = (values, {resetForm, setStatus}) => {
		httpConfig.post("/apis/kid-sign-in/", values)
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
					resetForm();
					history.push("/kid-dashboard");
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
				{KidLoginFormContent}
			</Formik>
		</>
	)
};
import React, {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

/*
* Custom hooks to grab the jwt and decode jwt data for logged in users.
*
* Author: rlewis37@cnm.edu
* */

export const useJwt = () => {
	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	}, [jwt]);

	return jwt;
};

export const useJwtAdultId = () => {
	const [adultId, setAdultId] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setAdultId(decodedJwt.auth.adultId);
		}
	}, [adultId]);

	return adultId;
};


export const useJwtKidId = () => {
	const [kidId, setKidId] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setKidId(decodedJwt.auth.kidId);
		}
	}, [kidId]);

	return kidId;
};

export const useJwtKidUsername = () => {
	const [kidUsername, setKidUsername] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setKidUsername(decodedJwt.auth.kidUsername);
		}
	}, [kidUsername]);

	return kidUsername;
};
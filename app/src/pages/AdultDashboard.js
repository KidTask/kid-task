import React, {useEffect} from "react"
import {Header} from "../shared/components/header/Header";
import {KidCard} from "../shared/components/kidCard/kid-card";
import {AddKidCard} from "../shared/components/kidCard/add-kid-card";
import {Footer} from "../shared/components/footer/Footer";
import CardDeck from "react-bootstrap/CardDeck";
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import "../styles/adult-dashboard.css";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

//Redux
import {useDispatch, useSelector} from "react-redux";

//Actions
import {getAdultUsername} from "../shared/actions/adult-account-action";
import {useJwtAdultId} from "../shared/utils/JwtHelpers";
import {getKidByKidAdultId} from "../shared/actions/kid-account-actions";




export const AdultDashboard = () => {

const adultId  = useJwtAdultId();
console.log(adultId);

const dispatch = useDispatch();

const sideEffects = () => {
	dispatch(getKidByKidAdultId(adultId))
};

const sideEffectsInput = [adultId];

useEffect(sideEffects, sideEffectsInput);

const kids = useSelector(state => {
	return state.kids ? state.kids : []
});


	return (
		<>
		<Header/>
		<br/>

		<div className="container parent-cards">
				<CardDeck>

					{kids.map(kid => <KidCard kid={kid} key={kid.kidId}/>)}

					<AddKidCard/>

				</CardDeck>
		</div>
		</>
		)
};
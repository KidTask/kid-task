import React from "react"
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






export const AdultDashboard = () => {




	return (
		<>
		<Header/>
		<br/>

		<div className="container parent-cards">
				<CardDeck>

					<KidCard/>

					<AddKidCard/>

				</CardDeck>

			<div className="row mt-3">
				<Footer/>
			</div>
		</div>
		</>
		)
};
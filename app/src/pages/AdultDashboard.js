import React from "react"
import {Header} from "../shared/components/header/Header";
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

	// const {match} = props;
	// const adult = useSelector(state => (state.adult));
	//
	// const dispatch = useDispatch();
	// const effects = () => {
	// 	dispatch(getAdultUsername(match.params.adultUsername));
	// };

	let variable = "primary";
	return (
		<>
		<Header/>
		<br/>

		<div className="container parent-cards">
				<CardDeck>
					<Card border={variable} text="primary">
						<Card.Img variant="top" src="http://www.fillmurray.com/284/196" />
						<Card.Body className="text-center">
							<Card.Title>Kid 1</Card.Title>
							<Button variant="outline-primary">+ Add Task</Button>
						</Card.Body>
					</Card>

					<Card border="warning" text="warning">
						<Card.Img variant="top" src="http://www.fillmurray.com/284/196" />
						<Card.Body className="text-center">
							<Card.Title>Kid 2</Card.Title>
							<Button variant="outline-warning">+ Add Task</Button>
						</Card.Body>
					</Card>

					<Card border="secondary" text="secondary">
						<Card.Img variant="top" src="http://placeholder.pics/svg/284x196" />
						<Card.Body className="text-center">
							<Card.Title>New Kid</Card.Title>
							<Button variant="outline-secondary">+ Add Kid</Button>
						</Card.Body>
					</Card>
				</CardDeck>

			<div className="row mt-3">
				<Footer/>
			</div>
		</div>
		</>
		)
};
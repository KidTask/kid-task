import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import React from "react";
import {useHistory} from "react-router";


export const AddKidCard = (props) => {
	const {adult} = props;
	const history = useHistory();
	console.log(adult);
	return (
		<>
			<Card border="secondary" text="secondary">
				<Card.Img variant="top" src="http://placeholder.pics/svg/284x196" />
				<Card.Body className="text-center">
					<Card.Title>New Kid</Card.Title>
					<Button variant="outline-secondary" onClick={() => {history.push(`/kid-sign-up/${adult.adultUsername}`)}}>+ Add Kid</Button>
				</Card.Body>
			</Card>
		</>
	)
};
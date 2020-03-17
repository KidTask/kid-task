import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import React from "react";

export const AddKidCard = () => {
	return (
		<>
			<Card border="secondary" text="secondary">
				<Card.Img variant="top" src="http://placeholder.pics/svg/284x196" />
				<Card.Body className="text-center">
					<Card.Title>New Kid</Card.Title>
					<Button variant="outline-secondary">+ Add Kid</Button>
				</Card.Body>
			</Card>
		</>
	)
};
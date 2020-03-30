import React from "react";
import ListGroup from "react-bootstrap/ListGroup";
import Card from "react-bootstrap/Card";
import {KidCard} from "../kidCard/kid-card";


export const StepPreview = (props) => {
	 const {step} = props;
	// console.log(step);


	return (
		<>

					<ListGroup variant="flush">

						<ListGroup.Item>{step.stepContent}</ListGroup.Item>

					</ListGroup>





		</>
	)
};
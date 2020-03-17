import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import React, {useEffect} from "react";

import {getKidByKidAdultId} from "../../actions/kid-account-actions";
import {useDispatch} from "react-redux";

let variable = "primary";
export const KidCard = (props) => {


	// const {kid} = props;
	//
	// const dispatch = useDispatch();
	// const effects = () => {
	// 	dispatch(getKidByKidAdultId(kid.params.adultId));
	// };
	// const inputs = [kid.params.adultId];
	// useEffect(effects, inputs);

	return (
		<>
			<Card border={variable} text="primary">
				<Card.Img variant="top" src="http://www.fillmurray.com/284/196" />
				<Card.Body className="text-center">
					<Card.Title>Kid Name</Card.Title>
					<Button variant="outline-primary">+ Add Task</Button>
				</Card.Body>
			</Card>
		</>
	)
};
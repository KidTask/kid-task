import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import React, {useEffect} from "react";
import {getKidByKidAdultId} from "../../actions/kid-account-actions";
import {useDispatch} from "react-redux";
import {useHistory} from "react-router";

let variable = "primary";
export const KidCard = (props) => {
const {kid} = props;
console.log(kid);

const history = useHistory();


	return (
		<>
			<Card border={variable} text="primary">
				<Card.Img variant="top" src="http://www.fillmurray.com/284/196" />
				<Card.Body className="text-center">
					<Card.Title>{kid.kidName}</Card.Title>
					<Button className="mb-3" variant="outline-primary" onClick={() => {history.push(`/create-task/${kid.kidUsername}`)}}>+ Add Task</Button>
					<Button variant="outline-primary" onClick={() => {history.push(`/assigned-tasks/${kid.kidUsername}`)}}>View Tasks</Button>
				</Card.Body>
			</Card>
		</>
	)
};
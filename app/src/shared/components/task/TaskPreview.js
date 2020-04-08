import React from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import ProgressBar from "react-bootstrap/ProgressBar";
import {StepPreview} from "../step/StepPreview";
import {TaskProgressBar} from "./TaskProgressBar";
import {useSelector} from "react-redux";
import {KidCard} from "../kidCard/kid-card";
import {useTaskIsComplete} from "../../utils/useTaskIsComplete";


export const TaskPreview = (props) => {
	const {task} = props;
	const steps = useSelector(state =>
	{
		return state.steps ? state.steps.filter(step =>{
		return step.stepTaskId === task.taskId}): [] }
	);

const {status, temp} = useTaskIsComplete();


	return (
		<>
			<div className="col-md-5 col-lg-4 mx-auto mb-5">
				<Card border="info">
					<Card.Header>
						<h3 className="title">Due soon</h3>
						{task.taskIsComplete && <TaskProgressBar
							taskIsComplete = {2}
						/>}
					</Card.Header>


					<Card.Img variant="top" src="https://images.unsplash.com/photo-1524420533980-5fe0aecc5fe6"/>
					<Card.Body >
						<h3 className="title">Task</h3>
						<Card.Title className="kidCardTitle">{task.taskContent}</Card.Title>
					</Card.Body>
					<Card.Body>
						<h3 className="title">Steps</h3>

						{/*Similar to Adult Dashboard*/}

						{steps.map(step => <StepPreview step={step} key={step.stepId}/>)}

					</Card.Body>
					{task.taskIsComplete === 0 && <ListGroup variant="flush" className="beginTask">
						<ListGroup.Item><Button variant="outline-info" onClick={() => temp(task, 1)}>Begin task</Button></ListGroup.Item>
						</ListGroup>}
					{task.taskIsComplete !== 0 && <ListGroup variant="flush" className="taskOpen">
						<ListGroup.Item><Button variant="outline-info" onClick={() => temp(task, 2)}>I'm done with my task!</Button></ListGroup.Item>
					</ListGroup>}

				</Card>
			</div>
			<br/>
		</>
	)
};
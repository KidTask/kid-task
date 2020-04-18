import React from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import ProgressBar from "react-bootstrap/ProgressBar";
import {StepPreview} from "../step/StepPreview";
import {TaskProgressBar} from "./TaskProgressBar";
import {useDispatch, useSelector} from "react-redux";
import {KidCard} from "../kidCard/kid-card";
import {useTaskIsComplete} from "../../utils/useTaskIsComplete";
import {Formik} from "formik";
import {httpConfig} from "../../utils/http-config";
import {UpdateTaskIsComplete} from "./UpdateTaskIsComplete";


export const TaskPreview = () => {
	const {task} = props;
	const steps = useSelector(state => {
			return state.steps ? state.steps.filter(step => {
				return step.stepTaskId === task.taskId
			}) : []
		}
	);

	return (
		<>
			<div className="col-md-5 col-lg-4 mx-auto mb-5">
				<Card border="info">
					<Card.Header>
						<h3 className="title">Task</h3>
						<Card.Title className="kidCardTitle">{task.taskContent}</Card.Title>
						<TaskProgressBar taskIsComplete={task.taskIsComplete}/>
					</Card.Header>
					<Card.Img variant="top" src="https://images.unsplash.com/photo-1524420533980-5fe0aecc5fe6"/>
					<Card.Body>
						<h3 className="title">Steps</h3>
						{steps.map(step => <StepPreview step={step} key={step.stepId}/>)}
					</Card.Body>
					{task.taskIsComplete === 0 && <ListGroup variant="flush" className="beginTask">
						<ListGroup.Item>
							<UpdateTaskIsComplete
								newTaskIsComplete="1"
								buttonText="Begin Task"
							/>
						</ListGroup.Item>
					</ListGroup>}
					{task.taskIsComplete > 0 && task.taskIsComplete < 2 && <ListGroup variant="flush" className="taskOpen">
						<ListGroup.Item>
							<UpdateTaskIsComplete
								newTaskIsComplete="2"
								buttonText="I'm Done!"
							/>
						</ListGroup.Item>
					</ListGroup>}
				</Card>
			</div>
			<br/>
		</>
	)
};
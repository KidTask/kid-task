import React from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import ProgressBar from "react-bootstrap/ProgressBar";
import {StepPreview} from "../step/StepPreview";
import {TaskProgressBar} from "./TaskProgressBar";
import {useSelector} from "react-redux";
import {httpConfig} from "../../utils/http-config";

export const AdultPreviewTasks = (props) => {
	const {task} = props;
	const steps = useSelector(state => {
			return state.steps ? state.steps.filter(step => {
				return step.stepTaskId === task.taskId
			}) : []
		}
	);

	function submitTaskIsComplete() {
		httpConfig.put("/apis/task-api/", )
			.then(reply => {
					let {message, type} = reply;
					if(reply.status === 200) {
						task.taskIsComplete = 3;
					}
					//setStatus({message, type})
				}
			);
	};

	return (
		<>
			<div className="col-md-5 col-lg-4 mx-auto mb-5">
				<Card border="info">
					<Card.Header>
						<h3 className="title">Task</h3>
						<Card.Title className="kidCardTitle">{task.taskContent}</Card.Title>
						<h3 className="title">Due {task.taskDueDate.getDay}</h3>
						<TaskProgressBar
							taskIsComplete={task.taskIsComplete}
						/>
					</Card.Header>
					<Card.Img variant="top" src="https://images.unsplash.com/photo-1524420533980-5fe0aecc5fe6"/>
					<Card.Body>
						<h3 className="title">Steps</h3>
						{steps.map(step => <StepPreview step={step} key={step.stepId}/>)}
					</Card.Body>
					<ListGroup variant="flush">
						<ListGroup.Item><Button onClick={submitTaskIsComplete} variant="outline-info">Task Is Complete</Button></ListGroup.Item>
					</ListGroup>
				</Card>
			</div>
			<br/>
		</>
	)
};
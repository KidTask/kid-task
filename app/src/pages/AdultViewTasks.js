import React, {useEffect} from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {useDispatch, useSelector} from "react-redux";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import CardDeck from "react-bootstrap/CardDeck";
import ListGroup from "react-bootstrap/ListGroup";
import {StepPreview} from "../shared/components/step/StepPreview";
import {TaskProgressBar} from "../shared/components/task/TaskProgressBar";
import "../styles/adult-dashboard.css";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

//Actions
import {getAdultUsername} from "../shared/actions/adult-account-action";
import {useJwtAdultId} from "../shared/utils/JwtHelpers";
import {getKidByKidAdultId} from "../shared/actions/kid-account-actions";
import {getTaskAndStepsByKidUsername, getTasksAndSteps} from "../shared/actions/task-actions";
import {TaskPreview} from "../shared/components/task/TaskPreview";


export const AdultViewTasks = ({match}) => {

	const adultId  = useJwtAdultId();

	const dispatch = useDispatch();

	const sideEffects = () => {
		dispatch(getTaskAndStepsByKidUsername(match.params.kidUsername))
	};


	const sideEffectsInput = [adultId];

	useEffect(sideEffects, sideEffectsInput);

	const tasks = useSelector(state => {
		return state.tasks ? state.tasks : []
	});


			return (
			<>
				<div className="col-md-5 col-lg-4 mx-auto mb-5">
					<Card border="info">
						<Card.Header>
							<h3 className="title">Due soon</h3>
							<TaskProgressBar
								taskIsComplete = {100}
							/>
						</Card.Header>
						<Card.Img variant="top" src="https://images.unsplash.com/photo-1524420533980-5fe0aecc5fe6"/>
						<Card.Body >
							<h3 className="title">Task</h3>
							<Card.Title className="kidCardTitle">{task.taskContent}</Card.Title>
						</Card.Body>
						<Card.Body>
							<h3 className="title">Steps</h3>
							{tasks.map(task => <TaskPreview task={task} key={task.taskId}/>)}
						</Card.Body>
						<ListGroup variant="flush" className="beginTask">
							<ListGroup.Item><Button variant="outline-info">Begin task</Button></ListGroup.Item>
						</ListGroup>
						<ListGroup variant="flush" className="taskOpen">
							<ListGroup.Item><Button variant="outline-info">I'm done with my task!</Button></ListGroup.Item>
						</ListGroup>

					</Card>
				</div>
				<br/>
			</>
			)
};
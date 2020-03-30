import React, {useEffect} from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {Col} from "react-bootstrap";
import {Image} from "react-bootstrap";
import {TaskPreview} from "../shared/components/task/TaskPreview";
import {useJwtKidId} from "../shared/utils/JwtHelpers";
import {getKidByKidAdultId, getKidByKidId} from "../shared/actions/kid-account-actions";
import {useDispatch, useSelector} from "react-redux";

import {getTaskByTaskKidId, getTasksAndSteps} from "../shared/actions/task-actions";



export const Kid = () => {

	const kidId  = useJwtKidId();
	console.log(kidId);

	const dispatch = useDispatch();

	const sideEffects = () => {
		dispatch(getTasksAndSteps(kidId))
	};

	const sideEffectsInput = [kidId];

	useEffect(sideEffects, sideEffectsInput);

	const tasks = useSelector(state => {
		return state.tasks ? state.tasks : []
	});



	return (
		<>
			<Header/>
			<div className="container">
				<div className="row">
					<div className="mx-auto my-5">
						<h5><span>Kid</span>'s Dashboard</h5>
					</div>
				</div>

				<div className="row mb-6 pb-5" >

					{tasks.map(task => <TaskPreview task={task} key={task.taskId}/>)}


				</div>


				<div className="row">
					<Footer/>
				</div>
			</div>
			</>
			)
			};
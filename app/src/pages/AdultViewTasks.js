import React, {useEffect} from "react"
import {Header} from "../shared/components/header/Header";
import {useDispatch, useSelector} from "react-redux";
import {AdultPreviewTasks} from "../shared/components/task/AdultPreviewTasks";
import "../styles/adult-dashboard.css";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';

//Actions
import {getTaskAndStepsByKidUsername} from "../shared/actions/task-actions";


export const AdultViewTasks = ({match}) => {

	const dispatch = useDispatch();

	const sideEffects = () => {
		dispatch(getTaskAndStepsByKidUsername(match.params.kidUsername))
	};


	const sideEffectsInput = [match.params.kidUsername];

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
							<h5><span>{match.params.kidUsername.toUpperCase()}</span>'S TASKS</h5>
						</div>
					</div>
					<div className="row mb-6 pb-5" >
						{tasks.map(task => <AdultPreviewTasks task={task} key={task.taskId}/>)}
					</div>
				</div>
			</>
			)
};
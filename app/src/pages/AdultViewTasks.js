import React, {useEffect} from "react"
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {useDispatch, useSelector} from "react-redux";
import {AdultTaskPreview} from "../shared/components/task/AdultTaskPreview";
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
				<Header/>
				<div className="container">
					<div className="row">
						<div className="mx-auto my-5">
							<h5><span>Kid</span>'s Dashboard</h5>
						</div>
					</div>

					<div className="row mb-6 pb-5" >

						{tasks.map(task => <AdultTaskPreview task={task} key={task.taskId}/>)}


					</div>


					<div className="row">
						<Footer/>
					</div>
				</div>
			</>
			)
};
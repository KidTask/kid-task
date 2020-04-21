import React, {useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {
	getTaskByTaskId,
	updateTaskIsComplete
} from "../../actions/task-actions";
import Button from "react-bootstrap/Button";
import {Formik} from "formik";


export const UpdateTaskIsComplete = (clickedTask) => {

	const dispatch = useDispatch();

	/*const sideEffects = () => dispatch(getTaskByTaskId(task.taskId));

	useEffect(sideEffects, task.taskId);*/

	/*const clickedTask = useSelector(state =>
		console.log(state)
		return state;
	});*/


	return (
		<>
		<Formik
			const initialValues={{taskIsComplete: ''}}
			//value is not set and will return initial value unchanged
			onSubmit={(value, {setStatus}) => {
				const newTask = {...clickedTask, taskIsComplete: `${clickedTask.newTaskIsComplete}`};
				httpConfig.put(`/apis/task-api/${clickedTask.taskId}`, newTask)
					.then(reply => {
						if(reply.status === 200) {
							dispatch(updateTaskIsComplete(newTask));
						}
						setStatus(reply)
					})
			}
			}
		>
			{(props) => {
				const {
					status,
					handleSubmit,
				} = props;

				return (
					<>
						<form onSubmit={handleSubmit}>
							<Button type="submit" variant="outline-info">{clickedTask.buttonText}</Button>
						</form>
						<br/>
						{ status && (<div className={status.type}>{status.message}</div>) }
					</>
				)
			}}
		</Formik>
		</>
	);
};

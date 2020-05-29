import React, {useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {updateTaskIsComplete} from "../../actions/task-actions";
import Button from "react-bootstrap/Button";
import {Formik} from "formik";


export const UpdateTaskIsComplete = (clickedTask) => {

	const dispatch = useDispatch();

	return (
		<>
		<Formik
			const initialValues={{taskIsComplete: ''}}
			//value is not set and will return initial value unchanged
			onSubmit={(value, {setStatus}) => {
				const newTask = {...clickedTask.theTask, taskIsComplete: parseInt(clickedTask.newTaskIsComplete)};
				httpConfig.put(`/apis/task-api/${clickedTask.taskId}`, newTask)
					.then(reply => {
						setStatus(reply);
						if(reply.status === 200) {
							dispatch(updateTaskIsComplete(newTask));
							//app won't rerender for adult, manual refresh
							if (parseInt(clickedTask.newTaskIsComplete) === 3){
								setTimeout(() => window.location.reload(), 1000);
							}
						}
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

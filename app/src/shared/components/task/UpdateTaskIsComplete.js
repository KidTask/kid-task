import {httpConfig} from "../../utils/http-config";
import {updateTaskIsComplete} from "../../actions/task-actions";
import Button from "react-bootstrap/Button";
import {Formik} from "formik";
import React from "react";
import {useDispatch} from "react-redux";



export const UpdateTaskIsComplete = () => {

	const dispatch = useDispatch();
	return (
		<Formik
			const initialValues={{taskIsComplete: ""}}
			//value is not set and will return initial value unchanged
			onSubmit={(value, {setStatus}) => {
				const newTask = {...task, taskIsComplete: 1};
				httpConfig.put(`/apis/task-api/${task.taskId}`, newTask)
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
							<Button type="submit" variant="outline-info">Begin task</Button>
						</form>
						<br/>
						{
							status && (<div className={status.type}>{status.message}</div>)
						}
					</>
				)
			}}
		</Formik>
	);
};

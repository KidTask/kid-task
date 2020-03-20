import React from 'react';
import {ErrorMessage, Field, FieldArray, Formik} from 'formik';
import Form from 'react-bootstrap/Form';

import * as Yup from 'yup';
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import {FormDebugger} from "../FormDebugger";
import {httpConfig} from "../../utils/http-config";
//import { connect } from 'react-redux';
//import { setTasks } from './actionCreators';


const initialValues = {
	taskContent: '',
	taskAvatarUrl: '',
	taskDueDate: '',
	taskReward: '',
	taskSteps: [
		{
			stepContent: '',
		},
	],
};

export const TaskForm = () => (
	<>
		<Formik
			initialValues={initialValues}
			validationSchema={Yup.object({
				taskContent: Yup.string().required('Task is required'),
				taskAvatarUrl: Yup.string(),
				taskDueDate: Yup.string(),
				taskReward: Yup.string(),
				taskSteps: Yup.array().of(
					Yup.object({
						stepContent: Yup.string(),
					})
				),
			})}
			onSubmit={(values, {resetForm, setStatus}) => {
				httpConfig.post("/apis/task-api/", values)
				.then(reply => {
						let {message, type} = reply;
						if(reply.status === 200) {
							resetForm();
						}
					setStatus({message, type});
				});
			}}
		>
			{(props) => {
				const  {values, isSubmitting} = props;
				return(

				<Form noValidate>
					<Form.Group>
						<Form.Label>Task</Form.Label>
						<Form.Control name="taskContent" type="text" placeholder="Example: Clean your room." />
						<ErrorMessage name="taskContent">
							{msg => <div className="field-error">{msg}</div>}
						</ErrorMessage>
					</Form.Group>
					<FieldArray name="taskSteps">
						{({ push, remove }) =>
					<React.Fragment>
						{values.taskSteps && values.taskSteps.length > 0 && values.taskSteps.map((step, index) =>
						<Row>
							<Col sm="10">
								<Form.Control name={`taskSteps[${index}].stepContent`} type="text" placeholder="Add a step" />
							</Col>
							<br/>
							<br/>
							<Col sm="2">
								<Button type="button" variant="outline-danger" onClick={() => remove(index)}>X</Button>
							</Col>
						</Row>
						)}
					<Button
						type="button"
						onClick={() => push({stepContent: ''})}
						variant="outline-primary"
					>
						Add Step
					</Button>
					</React.Fragment>
						}
					</FieldArray>
					<br/>
					<br/>
					<Form.Label>Image</Form.Label>
					<Form.Control name="taskAvatarUrl" type="text" />
					<br/>
					<Row>
						<Col>
							<Form.Label>Due Date</Form.Label>
							<Form.Control name="taskDueDate" type="dateTime" />
						</Col>
						<Col>
							<Form.Label>Reward</Form.Label>
							<Form.Control name="taskReward" type="text" />
						</Col>
					</Row>
					<br/>
					<Button type="submit" variant="primary" disabled={isSubmitting}>Create Task</Button>
					<FormDebugger  {...props} />
				</Form>
				)}}

		</Formik>
	</>
); // end of TaskForm

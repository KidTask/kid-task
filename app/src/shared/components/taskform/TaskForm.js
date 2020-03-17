import React from 'react';
import {ErrorMessage, Field, FieldArray, Formik} from 'formik';
import Form from 'react-bootstrap/Form';

import * as Yup from 'yup';
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
//import { connect } from 'react-redux';
//import { setTasks } from './actionCreators';


const initialValues = {
	task: '',
	image: '',
	dueDate: '',
	reward: '',
	steps: [
		{
			content: '',
		},
	],
};

export const TaskForm = () => (
	<div>
		<Formik
			initialValues={initialValues}
			validationSchema={Yup.object({
				task: Yup.string().required('Required'),
				image: Yup.string(),
				dueDate: Yup.string(),
				reward: Yup.string(),
				steps: Yup.array().of(
					Yup.object({
						content: Yup.string(),
					})
				),
			})}
			onSubmit={values => {
				setTimeout(() => {
					alert(JSON.stringify(values, null, 2));
				}, 500);
			}}
		>
			{({ values, isSubmitting }) => (
				<Form>
					<Form.Group>
						<Form.Label>Task</Form.Label>
						<Form.Control name="task" type="text" placeholder="Example: Clean your room." />
						<ErrorMessage name="task">
							{msg => <div className="field-error">{msg}</div>}
						</ErrorMessage>
					</Form.Group>
					<FieldArray name="steps">
						{({ push, remove }) =>
					<React.Fragment>
						{values.steps && values.steps.length > 0 && values.steps.map((step, index) =>
						<Row>
							<Col sm="10">
								<Form.Control name={`steps[${index}].content`} type="text" placeholder="Add a step" />
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
						onClick={() => push({content: ''})}
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
					<Form.Control name="image" type="text" />
					<br/>
					<Row>
						<Col>
							<Form.Label>Due Date</Form.Label>
							<Form.Control name="dueDate" type="dateTime" />
						</Col>
						<Col>
							<Form.Label>Reward</Form.Label>
							<Form.Control name="reward" type="text" />
						</Col>
					</Row>
					<br/>
					<Button type="submit" variant="primary" disabled={isSubmitting}>Create Task</Button>
				</Form>
				)}
		</Formik>
	</div>
); // end of TaskForm

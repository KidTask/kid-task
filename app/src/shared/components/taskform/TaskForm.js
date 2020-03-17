import React from 'react';
import {ErrorMessage, Field, FieldArray, Formik} from 'formik';
import Form from 'react-bootstrap/Form';
import Col from 'react-bootstrap/Col';
import Button from 'react-bootstrap/Button';
import * as Yup from 'yup';
import { addTask, getTasks } from './requests';
import { connect } from 'react-redux';
import { setTasks } from './actionCreators';
import '../styles/TaskForm.css';
import divWithClassName from "react-bootstrap/cjs/divWithClassName";
import ErrorBoundary from "react-beautiful-dnd/src/view/drag-drop-context/error-boundary";


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
				image: Yup.mixed(),
				dueDate: Yup.date,
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
					<Field name="task" type="text" placeholder"Task" />
					<ErrorMessage name="task">
						{msg => <div className="field-error">{msg}</div>}
					</ErrorMessage>
					<div className="row">
						<div className="col">
							<Field name="image" type="image" />
						</div>
						<div className="col">
							<Field name="dueDate" type="dateTime"  />
						</div>
						<div className="col">
							<Field name="reward" type="text" />
						</div>
					</div>
					<FieldArray name="steps">
						{({ push, remove }) =>
					<React.Fragment>
						{values.steps && values.steps.length > 0 && values.steps.map((step, index) =>
						<div className="row">
							<div className="col">
								<Field name={`steps[${index}].content`} type="text" placeholder"Add a step" />
							</div>
							<div className="col">
								<button type="button" onClick={() => remove(index)}>X</button>
							</div>
						</div>
						)}
					<button
						type="button"
						onClick={() => push({content: ''})}
						className="secondary"
					>
						Add Step
					</button>
					</React.Fragment>
						}
					</FieldArray>
					<button type="submit" disabled={isSubmitting}>Create Task</button>
					<Debug />
				</Form>
				)}
		</Formik>
	</div>
); // end of TaskForm

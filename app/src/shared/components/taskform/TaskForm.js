import React from 'react';
import { Formik } from 'formik';
import Form from 'react-bootstrap/Form';
import Col from 'react-bootstrap/Col';
import Button from 'react-bootstrap/Button';
import * as yup from 'yup';
import { addTask, getTasks } from './requests';
import { connect } from 'react-redux';
import { setTasks } from './actionCreators';
import '../styles/TaskForm.css';
const schema = yup.object({
	description: yup.string().required('Description is required'),
});
function ContactForm({ setTasks }) {
	const handleSubmit = async (evt) => {
		const isValid = await schema.validate(evt);
		if (!isValid) {
			return;
		}
		await addTask(evt);
		const response = await getTasks();
		setTasks(response.data);
	}
	return (
		<div className="form">
			<Formik
				validationSchema={schema}
				onSubmit={handleSubmit}
			>
				{({
					  handleSubmit,
					  handleChange,
					  handleBlur,
					  values,
					  touched,
					  isInvalid,
					  errors,
				  }) => (
					<Form noValidate onSubmit={handleSubmit}>
						<Form.Row>
							<Form.Group as={Col} md="12" controlId="firstName">
								<Form.Label>
									<h4>Add Task</h4>
								</Form.Label>
								<Form.Control
									type="text"
									name="description"
									placeholder="Task Description"
									value={values.description || ''}
									onChange={handleChange}
									isInvalid={touched.description && errors.description}
								/>
								<Form.Control.Feedback type="invalid">
									{errors.description}
								</Form.Control.Feedback>
							</Form.Group>
						</Form.Row>
						<Button type="submit" style={{ 'marginRight': '10px' }}>Save</Button>
					</Form>
				)}
			</Formik>
		</div>
	);
}
ContactForm.propTypes = {
}
const mapStateToProps = state => {
	return {
		tasks: state.tasks,
	}
}
const mapDispatchToProps = dispatch => ({
	setTasks: tasks => dispatch(setTasks(tasks))
})
export default connect(
	mapStateToProps,
	mapDispatchToProps
)(ContactForm);
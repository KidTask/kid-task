import React from 'react';
import { useState, useEffect } from 'react';
import '../styles/TaskForm.css';
import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';
import { connect } from 'react-redux';
import {TaskForm} from '../shared/components/taskform/TaskForm';
import { editTask, getTasks, deleteTask } from './requests';

function HomePage({ tasks }) {
	const [items, setItems] = useState([]);
	const [todoItems, setTodoItems] = useState([]);
	const [doneItems, setDoneItems] = useState([]);
	const [initialized, setInitialized] = useState(false);
	const onDragEnd = async (evt) => {
		const { source } = evt;
		let item = {};
		if (source.droppableId == "todoDroppable") {
			item = todoItems[source.index];
			item.done = true;
		}
		else {
			item = doneItems[source.index];
			item.done = false;
		}
		await editTask(item);
		await getTodos();
	};
	const setAllItems = (data) => {
		if (!Array.isArray(data)) {
			return;
		}
		setItems(data);
		setTodoItems(data.filter(i => !i.done));
		setDoneItems(data.filter(i => i.done));
	}
	const getTodos = async () => {
		const response = await getTasks();
		setAllItems(response.data);
		setInitialized(true);
	}
	const removeTodo = async (task) => {
		await deleteTask(task.id);
		await getTodos();
	}
	useEffect(() => {
		setAllItems(tasks);
		if (!initialized) {
			getTodos();
		}
	}, [tasks]);
	return (
		<div className="App">
			<div className='col-12'>
				<TaskForm />
				<br />
			</div>
			<div className='col-12'>
				<div className='row list'>
					<DragDropContext onDragEnd={onDragEnd}>
						<Droppable droppableId="todoDroppable">
							{(provided, snapshot) => (
								<div
									className='droppable'
									ref={provided.innerRef}
								>
									&nbsp;
									<h2>To Do</h2>
									<div class="list-group">
										{todoItems.map((item, index) => (
											<Draggable
												key={item.id}
												draggableId={item.id}
												index={index}
											>
												{(provided, snapshot) => (
													<div
														className='list-group-item '
														ref={provided.innerRef}
														{...provided.draggableProps}
														{...provided.dragHandleProps}
													>
														{item.description}
														<a onClick={removeTodo.bind(this, item)}>
															<i class="fa fa-close"></i>
														</a>
													</div>
												)}
											</Draggable>
										))}
									</div>
									{provided.placeholder}
								</div>
							)}
						</Droppable>
						<Droppable droppableId="doneDroppable">
							{(provided, snapshot) => (
								<div
									className='droppable'
									ref={provided.innerRef}
								>
									&nbsp;
									<h2>Done</h2>
									<div class="list-group">
										{doneItems.map((item, index) => (
											<Draggable
												key={item.id}
												draggableId={item.id}
												index={index}
											>
												{(provided, snapshot) => (
													<div
														className='list-group-item'
														ref={provided.innerRef}
														{...provided.draggableProps}
														{...provided.dragHandleProps}
													>
														{item.description}
														<a onClick={removeTodo.bind(this, item)}>
															<i class="fa fa-close"></i>
														</a>
													</div>
												)}
											</Draggable>
										))}
									</div>
									{provided.placeholder}
								</div>
							)}
						</Droppable>
					</DragDropContext>
				</div>
			</div>
		</div>
	);
}
const mapStateToProps = state => {
	return {
		tasks: state.tasks,
	}
}
export default connect(
	mapStateToProps,
	null
)(HomePage);
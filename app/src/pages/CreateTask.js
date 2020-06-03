import React from "react";
import {Header} from "../shared/components/header/Header";
import {Footer} from "../shared/components/footer/Footer";
import {TaskForm} from "../shared/components/taskform/TaskForm";



export const CreateTask = ({match}) => {
	return (
		<>
			<Header/>
			<div className="container parent-cards">
				<h5>Create a Task</h5>
				<TaskForm match={match}/>
			</div>
			</>
	)
};
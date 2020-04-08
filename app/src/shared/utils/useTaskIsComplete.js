import React, {useState, useEffect} from "react";
import {httpConfig} from "./http-config";

export function useTaskIsComplete() {
	const [status, setStatus] = useState();


	const temp = (currentTask, taskIsComplete) => {
		const newTask = {...currentTask, taskIsComplete};
		return httpConfig.put(`/apis/task-api/${currentTask.taskId}`, newTask)
		.then(reply => {
			setStatus(reply)
		})};

	return {status, temp}
}
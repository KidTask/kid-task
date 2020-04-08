import React, {useState, useEffect} from "react";
import {httpConfig} from "./http-config";

export function useTaskIsComplete(currentTask, taskIsComplete) {
	const [status, setStatus] = useState();
	const newTask = {...currentTask, taskIsComplete};
	useEffect(()=>{
		httpConfig.put(`/apis/task-api/${currentTask.taskId}`, newTask)
			.then(reply => {
				setStatus(reply)
			});
	}, [status]);
	return status
}
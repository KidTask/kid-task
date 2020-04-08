import ProgressBar from "react-bootstrap/ProgressBar";
import Card from "react-bootstrap/Card";
import React from "react";

// <ProgressBar animated now={33} variant="info" label={`Working on it!`}/>

export function TaskProgressBar(props) {
	console.log(props.taskIsComplete);
	const {taskIsComplete} = props;
	if (taskIsComplete === 0) {
		return <ProgressBar animated now={20} variant="info" label={`Let's get started!`}/>
	} else if (taskIsComplete === 1) {
		return <ProgressBar animated now={50} variant="info" label={`Working on it!`}/>
	} else if (taskIsComplete === 2) {
		return <ProgressBar animated now={100} variant="info" label={`I'm done!`}/>
	} else {return null}
}


import React from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import ProgressBar from "react-bootstrap/ProgressBar";


export const TaskPreview = () => {
	return (
		<>
			<div className="col-md-5 col-lg-4 mx-auto mb-5">
				<Card border="info">
					<Card.Header>
						<ProgressBar animated now={33} variant="info" label={`Working on it!`} />
					</Card.Header>
					<Card.Body className="row">
						<div>
						<img className="taskAvatar mx-2" alt="task avatar"
							  src="https://images.unsplash.com/photo-1524420533980-5fe0aecc5fe6"/></div>
			<div className="col-9">
						<Card.Title>This is where the task would be if it were a run on sentence that would be very complicated for a young kid to grasp.</Card.Title>
		</div>
				</Card.Body>
					<ListGroup variant="flush">
						<ListGroup.Item>This would be step 1 after clicking the Begin Task button</ListGroup.Item>
						<ListGroup.Item>This would be step 2 </ListGroup.Item>
						<ListGroup.Item>This would be step 3 </ListGroup.Item>

					</ListGroup>
					<ListGroup variant="flush" className="beginTask">
						<ListGroup.Item><Button variant="outline-info">Begin task</Button></ListGroup.Item>
					</ListGroup>
					<ListGroup variant="flush" className="taskOpen">
						<ListGroup.Item><Button variant="outline-info">I'm done with my task!</Button></ListGroup.Item>
					</ListGroup>

				</Card>
			</div>
			<br/>
		</>
	)
};
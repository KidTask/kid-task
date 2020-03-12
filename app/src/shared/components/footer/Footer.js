import React from "react";


import {Link} from "react-router-dom";


import "../../../style.css";


import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {library} from "@fortawesome/fontawesome-svg-core";
import {faInfoCircle, faUserFriends} from "@fortawesome/free-solid-svg-icons";

library.add(faInfoCircle, faEnvelope, faUserFriends);

export const Footer = () => (
	<>
		<footer className="page-footer bg-light fixed-bottom py-2">
			<Container className="container">
				<div className="d-flex justify-content-center">
					<Row id="icons">
						<Col>
							<Link to='/about'>
								<i><FontAwesomeIcon icon={faInfoCircle} size="sm" alt="Kid Task Project Information"/></i>
							</Link>
						</Col>
						<Col>
							<a href="https://github.com/KidTask/kid-task"
								title="KidTask' repository on GitHub">
								{/*<i><FontAwesomeIcon icon={faGithub} size="sm"/></i>*/}
							</a>
						</Col>
						<Col>
							<a href="mailto:kidtask@gmail.com"
								title="Kid Task's email">
								<i><FontAwesomeIcon icon={faEnvelope} size="sm"/></i>
							</a>
						</Col>
						<Col>
							<Link to='/team'>
								<i><FontAwesomeIcon icon={faUserFriends} size="sm" alt="Kid Task Team"/></i>
							</Link>
						</Col>
					</Row>
				</div>
				<div className="d-flex justify-content-center">
					<Row>
						<Col id="group-name">&reg; 2020 By Kid Task – CNM Ingenuity Deep Dive Bootcamp Group</Col>
					</Row>
				</div>
			</Container>
		</footer>
	</>
);
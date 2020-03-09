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
import {faGithub} from "@fortawesome/free-brands-svg-icons";

library.add(faInfoCircle, faGithub, faEnvelope, faUserFriends);

export const Footer = () => (
	<>
		<footer className="page-footer bg-dark fixed-bottom py-2">
			<Container className="container">
				<div className="d-flex justify-content-center">
					<Row id="icons">
						<Col>
							<Link to='/about'>
								<i><FontAwesomeIcon icon={faInfoCircle} size="2x" alt="Kid Task Project Information"/></i>
							</Link>
						</Col>
						<Col>
							<a href="https://github.com/KidTask/kid-task"
								title="KidTask' repository on GitHub">
								<i><FontAwesomeIcon icon={faGithub} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<a href="mailto:kidtask@gmail.com"
								title="Kid Task's email">
								<i><FontAwesomeIcon icon={faEnvelope} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<Link to='/team'>
								<i><FontAwesomeIcon icon={faUserFriends} size="2x" alt="Kid Task Team"/></i>
							</Link>
						</Col>
					</Row>
				</div>
				<Row>
					<Col id="group-name">By Kid Task – CNM Ingenuity Deep Dive Bootcamp Group</Col>
				</Row>
			</Container>
		</footer>
	</>
);
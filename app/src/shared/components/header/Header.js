import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Container from "react-bootstrap/Container";
import "../../../style.css";
export const Header = (props) => {
    return(
        <Navbar expand="lg" variant="light" bg="light">
            <Container>
                <Navbar.Brand href="#">Kid Task</Navbar.Brand>
            </Container>
        </Navbar>
    )
};
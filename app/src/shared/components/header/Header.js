import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Container from "react-bootstrap/Container";
import {SignUpModal} from "./sign-up/SignUpModal";
import {KidSignUpModal} from "./sign-up/KidSignUpModal";
import "../../../style.css";
export const Header = (props) => {
    return(
        <Navbar expand="lg" variant="light" bg="light">
            <Container>
                <Navbar.Brand href="#">Kid Task</Navbar.Brand>
            </Container>
            <SignUpModal/>
            <KidSignUpModal/>
        </Navbar>
    )
};
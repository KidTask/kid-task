import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {LoginModal} from "../login/LoginModal";
import "../../../style.css";
export const Header = (props) => {
    return(
        <Navbar bg="primary" variant="dark">
        <LinkContainer exact to="/" >
        <Navbar.Brand id={"navbar.brand"}>APCIMAP</Navbar.Brand>
        </LinkContainer>
        <Nav className="mr-auto">
        <LinkContainer exact to="/user">
        <Nav.Link>user</Nav.Link>
        </LinkContainer>
        <SignUpModal/>
        <LoginModal/>
        </Nav>
        </Navbar>
)
};
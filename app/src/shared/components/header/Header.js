import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {SignUpModal} from "./sign-up/SignUpModal";
import {LoginModal} from "./login/LoginModal";
import "../../../style.css";
import "./header.css";
export const Header = () => {
    return(
        <Navbar bg="primary" variant="dark">
        <Navbar.Brand id={"navbar.brand"}>Kid Task</Navbar.Brand>
        <Nav className="mr-auto">
        <Nav.Link>User</Nav.Link>
        <SignUpModal/>
        <LoginModal/>
        </Nav>
        </Navbar>
)
};
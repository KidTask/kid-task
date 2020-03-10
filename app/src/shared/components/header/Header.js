import React from "react";
import Navbar from "react-bootstrap/Navbar";
import "../../../style.css";
export const Header = (props) => {
    return(
        <Navbar expand="lg" variant="light" bg="light">
            <Container>
                <Navbar.Brand href="#">Navbar</Navbar.Brand>
            </Container>
        </Navbar>
)
};
import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Container from "react-bootstrap/Container";
import "../../../style.css";
import NavDropdown from "react-bootstrap/NavDropdown";
import Image from 'react-bootstrap/Image'


export const Header = (props) => {
    return(
        <Navbar variant="light" bg="light">
           <Container>
              <Navbar.Brand href="#">Kid Task</Navbar.Brand>
              <Navbar.Collapse className="justify-content-end">
                 <NavDropdown alignRight title="" id="dropdown-menu-align-right">
                    <NavDropdown.Item href="#action/3.1">+ Add Kid</NavDropdown.Item>
                    <NavDropdown.Divider />
                    <NavDropdown.Item href="#action/3.2">Edit Profile</NavDropdown.Item>
                 </NavDropdown>
              </Navbar.Collapse>
              <div className="pull-right">
                 <Image className="thumbnail-image"
                        src="http://www.fillmurray.com/200/300"
                        width="30"
                        height="30"
                        alt="user pic"
                        rounded
                 />
              </div>
           </Container>

        </Navbar>
    )
};
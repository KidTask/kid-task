import React from "react"
import Navbar from "react-bootstrap/Navbar";
import NavDropdown from "react-bootstrap/NavDropdown";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import NavLink from "react-bootstrap/NavLink";
import {Link} from "react-router-dom";

export const NavBar = () => (
    <>
        <header>
            <nav className="navbar navbar-expand-sm navbar-dark bg-dark"><a href="/"><span className="navbar-brand">Infinity ÷ -0</span>
            </a>
                <button aria-controls="basic-navbar-nav" type="button" aria-label="Toggle navigation"
                        className="navbar-toggler collapsed"><span className="navbar-toggler-icon"></span></button>
                <div className="navbar-collapse collapse"><span className="navbar-text">Signed in as: <a
                    href="/">Foo Bar Baz</a></span>
                    <div className="font-weight-light font-italic dropdown nav-item"><a aria-haspopup="true" aria-expanded="false"
                                                                                        href="#"
                                                                                        className="dropdown-toggle nav-link"
                                                                                        role="button">CLICK ME</a></div>
                </div>
            </nav>
        </header>
    </>
);
import Nav from "./Nav";
import NavItem from "./NavItem";


export default function Header() {
    return(
        <header>
            <div className="logo">LOGO</div>
            <Nav>
                <NavItem>Home</NavItem>
                <NavItem>About</NavItem>
                <NavItem>Services</NavItem>
                <NavItem>Contact</NavItem>
            </Nav>
        </header>
    );
}
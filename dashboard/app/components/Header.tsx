import Nav from "./Nav";
import NavItem from "./NavItem";


export default function Header() {
    return(
        <header>
            <div className="logo">LOGO</div>
            <nav>
                <div className="nav-item">Home</div>
                <div className="nav-item">About</div>
                <div className="nav-item">Services</div>
                <div className="nav-item">Contact</div>
            </nav>
            <Nav>
                <NavItem>Home</NavItem>
                <NavItem>About</NavItem>
                <NavItem>Services</NavItem>
                <NavItem>Contact</NavItem>
                <div className="nav-item">About</div>
                <div className="nav-item">Services</div>
                <div className="nav-item">Contact</div>
            </Nav>
        </header>
    );
}
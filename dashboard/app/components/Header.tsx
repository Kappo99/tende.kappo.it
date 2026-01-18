import Nav from "./Nav";
import NavItem from "./NavItem";


export default function Header() {
    return(
        <header className= "bg-[#2d3436] flex items-center justify-between py-5 px-7">
            <div className="text-3xl">LOGO</div>
            <Nav>
                <NavItem>Home</NavItem>
                <NavItem>About</NavItem>
                <NavItem>Services</NavItem>
                <NavItem>Contact</NavItem>
            </Nav>
        </header>
    );
}
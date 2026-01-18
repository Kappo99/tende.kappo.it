import Nav from "./Nav";


export default function Header() {
    return(
        <header className= "py-5 px-7 space-y-4">
            <h1 className="text-3xl text-center">CENTRALINA TENDE</h1>
            <Nav>
                <div className="flex">
                    <div className="border-2">Data</div>
                    <input type="date" name="date" className="border-2"/>
                </div>
                <button className="border-2">Reset</button>
            </Nav>
        </header>
    );
}
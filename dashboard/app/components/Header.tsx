import Nav from "./Nav";


export default function Header() {
    return(
        <header className= "flex flex-col items-center justify-center py-5 px-7">
            <div className="text-3xl">CENTRALINA TENDE</div>
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
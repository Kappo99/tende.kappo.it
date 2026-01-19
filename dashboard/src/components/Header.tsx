import Nav from "./Nav";
import { Button } from "@/components/ui/button";
import { Calendar22  } from "@/components/ui/datePicker";


export default function Header() {
    return(
        <header className= "py-5 px-7 space-y-4">
            <h1 className="text-3xl text-center">CENTRALINA TENDE</h1>
            <Nav>
                <Calendar22/>
                <Button variant="destructive">Reset</Button>
            </Nav>
        </header>
    );
}
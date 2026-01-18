Classe test, prova di parametri {

                                children
    interface IProps {
        text : string
        children : React.ReactNode
    }
    //{children,...props} dice tutto quello prima della virgola le estrae e le fa usare normalemente
    //                      tutto quello che viene dopo grazie ai ... dice di metterlo nel nome props, usando
    //                      props.text, props.prova ecc
    export default function NavItem({children,...props} : IProps) {
        return (
            <div className="nav-item">
                {props.text}
                {children}
            </div>
        );
    }

                                ?
    interface IProps {
    text? : string
    }
    // il ? serve ad impostare qualosa di default, se non c'è nulla che gli viene passato come parametro allora lo importa come parametro di default
    export default function Footer(props : IProps) {
        return (
            <footer>
                {props.text ?? "test"}
            </footer>
        );
    }
}



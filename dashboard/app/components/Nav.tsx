interface IProps {
    children : React.ReactNode
}

export default function Nav({children} : IProps) {
    return (
        <nav className= "flex gap-5">
            {children}
        </nav>
    );
}
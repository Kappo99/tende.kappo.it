interface IProps {
    children : React.ReactNode
}

export default function Nav({children} : IProps) {
    return (
        <nav>
            {children}
        </nav>
    );
}
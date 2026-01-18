interface IProps {
    children : React.ReactNode
}

export default function Nav({children} : IProps) {
    return(
        <nav className="flex justify-between bg-amber-300 w-full">
            {children}
        </nav>
    );
}
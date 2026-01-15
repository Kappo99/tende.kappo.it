interface IProps {
    children : React.ReactNode
}

export default function NavItem({children} : IProps) {
    return (
        <div className="nav-item">
            {children}
        </div>
    );
}
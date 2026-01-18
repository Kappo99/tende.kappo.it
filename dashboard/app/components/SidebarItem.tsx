interface IProps {
    children : React.ReactNode
}

export default function SidebarItem({children} : IProps) {
    return(
        <div className="sidebar-item">
            {children}
        </div>
    );
}
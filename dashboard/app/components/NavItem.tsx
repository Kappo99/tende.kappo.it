interface IProps {
    children : React.ReactNode
}

export default function NavItem({children} : IProps) {
    return (
        <div className="bg-[#0983e2] py-2.5 px-4 rounded-md">
            {children}
        </div>
    );
}
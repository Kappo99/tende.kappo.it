interface IProps {
    children : React.ReactNode
}

export default function SidebarItem({children} : IProps) {
    return(
        <div className="bg-[#2d3436] flex justify-center py-4 px-0 rounded-md">
            {children}
        </div>
    );
}
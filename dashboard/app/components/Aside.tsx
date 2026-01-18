interface IProps {
    children : React.ReactNode
}

export default function Aside({children} : IProps) {
    return(
        <aside className= "bg-gray-500 flex flex-col w-75 p-5 gap-4">
          {children}
        </aside>
    );
}
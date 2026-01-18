interface IProps {
    children : React.ReactNode
}

export default function Aside({children} : IProps) {
    return(
        <aside>
          {children}
        </aside>
    );
}
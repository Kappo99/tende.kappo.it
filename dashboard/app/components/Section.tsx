interface IProps {
    children : React.ReactNode
}

export default function Section({children} : IProps) {
    return (
        <section className= "flex flex-col gap-5 w-full p-5">
            {children}
        </section>
    );
}   
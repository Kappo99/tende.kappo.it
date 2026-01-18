interface IProps {
    children : React.ReactNode
}

export default function CardsContainer({children} : IProps) {
    return (
        <div className="flex w-full gap-5">
            {children}
        </div>
    );
}
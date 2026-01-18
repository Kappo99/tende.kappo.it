interface IProps {
    children : React.ReactNode
}

export default function CardsContainer({children} : IProps) {
    return (
        <div className="cards-container">
            {children}
        </div>
    );
}
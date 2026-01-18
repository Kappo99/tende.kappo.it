interface IProps {
    children : React.ReactNode
}

export default function CardTitle({children} : IProps) {
    return (
        <div className="card-title">
            {children}
        </div>
    );
}
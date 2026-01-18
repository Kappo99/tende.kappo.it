interface IProps {
    children : React.ReactNode
}

export default function CardContent({children} : IProps) {
    return (
        <div className="card-content">
            {children}
        </div>
    );
}
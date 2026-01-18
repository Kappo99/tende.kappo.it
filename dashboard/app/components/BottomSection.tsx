interface IProps {
    children : React.ReactNode
}

export default function BottomSection({children} : IProps) {
    return (
        <div className="bottom-section">
            {children}
        </div>
    );
}
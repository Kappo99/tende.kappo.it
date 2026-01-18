interface IProps {
    children : React.ReactNode
}

export default function BottomSection({children} : IProps) {
    return (
        <div className="flex gap-5">
            {children}
        </div>
    );
}
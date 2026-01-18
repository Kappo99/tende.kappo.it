interface IProps {
    children : React.ReactNode
}

export default function Card({children} : IProps) {
    return (
        <div className="bg-[#73b8fd] flex flex-1 flex-col rounded-xl">
            {children}
        </div>
    );
}
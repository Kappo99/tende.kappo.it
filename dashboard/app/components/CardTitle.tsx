interface IProps {
    children : React.ReactNode
}

export default function CardTitle({children} : IProps) {
    return (
        <div className="text-black text-xl flex justify-center items-center mt-6">
            {children}
        </div>
    );
}
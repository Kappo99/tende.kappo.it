interface IProps {
    children : React.ReactNode
}

export default function CardContent({children} : IProps) {
    return (
        <div className="bg-white text-[#676767] font-normal flex justify-center items-center p-5 m-[10px_20px_30px_20px] rounded-xl">
            {children}
        </div>
    );
}
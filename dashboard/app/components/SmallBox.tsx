interface IProps {
    children : React.ReactNode
}

export default function SmallBox({children} : IProps) {
    return(
        <div className="text-black bg-[#fde9a6] flex justify-center items-center rounded-xl">
            {children}
        </div>
    );
}
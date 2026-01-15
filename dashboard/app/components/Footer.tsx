interface IProps {
    text? : string
}

export default function Footer(props : IProps) {
    return (
        <footer>
            {props.text ?? "test"}
        </footer>
    );
}
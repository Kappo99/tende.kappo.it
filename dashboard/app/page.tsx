import Aside from "./components/Aside";
import BottomSection from "./components/BottomSection";
import Card from "./components/Card";
import CardContent from "./components/CardContent";
import CardsContainer from "./components/CardsContainer";
import CardTitle from "./components/CardTitle";
import Hero from "./components/Hero";
import Section from "./components/Section";
import SidebarItem from "./components/SidebarItem";
import SmallBox from "./components/SmallBox";

export default function Home() {
  return (
    <main className="flex w-full">

      <Aside>
        {["Menu 1", "Menu 2", "Menu 3", "Menu 4"].map((item, index) => (
          <SidebarItem key={index}>{item}</SidebarItem>
        ))}
      </Aside>

      <Section>
        <Hero />

        <CardsContainer>
          {[
            { title: "Card 1", content: "Content" },
            { title: "Card 2", content: "Content" }, 
            { title: "Card 3", content: "Content" }
          ].map((item, index) => (
            <Card key={index}>
              <CardTitle>{item.title}</CardTitle>
              <CardContent>{item.content}</CardContent>
            </Card>
          ))}
        </CardsContainer>

        <BottomSection>
          <div className="bg-[#fb78a7] flex flex-2 justify-center items-center p-4 rounded-xl">Large Box</div>
          <div className="flex flex-col flex-1 gap-5">
            <SmallBox>Small Box 1</SmallBox>
            <SmallBox>Small Box 2</SmallBox>
          </div>
        </BottomSection>
      </Section>
    </main>
  );
}

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
    <main className= "flex w-full">

      <Aside>
        <SidebarItem>Menu 1</SidebarItem>
        <SidebarItem>Menu 2</SidebarItem>
        <SidebarItem>Menu 3</SidebarItem>
        <SidebarItem>Menu 4</SidebarItem>
      </Aside>

      <Section>
        <Hero/>

        <CardsContainer>
          <Card>
            <CardTitle>Card 1</CardTitle>
            <CardContent>Content</CardContent>
          </Card>
          <Card>
            <CardTitle>Card 2</CardTitle>
            <CardContent>Content</CardContent>
          </Card>
          <Card>
            <CardTitle>Card 3</CardTitle>
            <CardContent>Content</CardContent>
          </Card>
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

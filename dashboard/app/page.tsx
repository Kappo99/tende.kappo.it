import Aside from "./components/Aside";
import BottomSection from "./components/BottomSection";
import Card from "./components/card";
import CardContent from "./components/CardContent";
import CardsContainer from "./components/CardsContainer";
import CardTitle from "./components/CardTitle";
import Footer from "./components/Footer";
import Header from "./components/Header";
import Hero from "./components/Hero";
import Section from "./components/Section";
import SidebarItem from "./components/SidebarItem";

export default function Home() {
  return (
    <>

      <Header />

      <main>

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
            <div className="left-box">Large Box</div>
            <div className="right-column">
              <div className="small-box">Small Box 1</div>
              <div className="small-box">Small Box 2</div>
            </div>
          </BottomSection>
        </Section>
      </main>

      <Footer text="FOOTER - © 2025" />
      <Footer />
    </>
  );
}

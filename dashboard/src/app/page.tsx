import { Button } from "@/components/ui/button";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

export default function Home() {
  return (
    <main className="container mx-auto px-4 py-8">
      <Tabs defaultValue="account" className="w-100">
        <TabsList>
          <TabsTrigger value="account">SENSORE VENTO</TabsTrigger>
          <TabsTrigger value="password">SENSORE PIOGGIA</TabsTrigger>
          <TabsTrigger value="password">REGISTRO ALLARMI</TabsTrigger>
        </TabsList>
        <TabsContent value="account">Make changes to your account here.</TabsContent>
        <TabsContent value="password">Change your password here.</TabsContent>
      </Tabs>
    </main>
  );
}

import { Input } from "@/components/ui/input"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

export default function Home() {
  return (
    <main className="container mx-auto px-4 py-8">
      <Tabs defaultValue="account" className="w-100">
        <div className="flex justify-between w-full">
          <TabsList>
            <TabsTrigger value="vento">SENSORE VENTO</TabsTrigger>
            <TabsTrigger value="pioggia">SENSORE PIOGGIA</TabsTrigger>ada
            <TabsTrigger value="allarmi">REGISTRO ALLARMI</TabsTrigger>
          </TabsList>
          <Input/>
        </div>
        <TabsContent value="vento">Make changes to your account here.</TabsContent>
        <TabsContent value="pioggia">Change your password here.</TabsContent>
        <TabsContent value="allarmi">allarmi</TabsContent>
      </Tabs>
    </main>
  );
}

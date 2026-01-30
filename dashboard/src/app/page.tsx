import { Input } from "@/components/ui/input"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

export default function Home() {
  return (
    <main className="container mx-auto px-4 py-8">
      <Tabs defaultValue="vento" className="w-full">
        <div className="flex justify-between">
          <TabsList>
            <TabsTrigger value="vento">SENSORE VENTO</TabsTrigger>
            <TabsTrigger value="pioggia">SENSORE PIOGGIA</TabsTrigger>
            <TabsTrigger value="allarmi">REGISTRO ALLARMI</TabsTrigger>
          </TabsList>
          <div>
            <Input />
          </div>
        </div>
        <TabsContent value="vento">Make changes to your account here.</TabsContent>
        <TabsContent value="pioggia">Change your password here.</TabsContent>
        <TabsContent value="allarmi">allarmi</TabsContent>
      </Tabs>
    </main>
  );
}

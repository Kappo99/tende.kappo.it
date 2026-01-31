'use client';

import { Input } from "@/components/ui/input"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { WindSensorTab } from "@/components/WindSensorTab";
import { RainSensorTab } from "@/components/RainSensorTab";
import { AlarmRegisterTab } from "@/components/AlarmRegisterTab";

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
            <Input placeholder="Filtra per data..." />
          </div>
        </div>
        <TabsContent value="vento">
          <WindSensorTab />
        </TabsContent>
        <TabsContent value="pioggia">
          <RainSensorTab />
        </TabsContent>
        <TabsContent value="allarmi">
          <AlarmRegisterTab />
        </TabsContent>
      </Tabs>
    </main>
  );
}

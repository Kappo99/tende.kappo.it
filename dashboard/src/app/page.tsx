'use client';

import { Input } from "@/components/ui/input"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { WindSensorTab } from "@/components/WindSensorTab";
import { RainSensorTab } from "@/components/RainSensorTab";
import { AlarmRegisterTab } from "@/components/AlarmRegisterTab";
import { useState } from "react";

export default function Home() {

  const [limit, setLimit] = useState(5000);

  return (
    <main className="container mx-auto px-4 py-8">
      <Tabs defaultValue="vento" className="w-full">
        <div className="flex justify-between">
          <TabsList>
            <TabsTrigger value="vento">SENSORE VENTO</TabsTrigger>
            <TabsTrigger value="pioggia">SENSORE PIOGGIA</TabsTrigger>
            <TabsTrigger value="allarmi">REGISTRO ALLARMI</TabsTrigger>
          </TabsList>
          <div className="flex ">
            <span className="flex items-center border border-black rounded-l-lg h-full px-2 ">righe</span>
            <Input className="rounded-l-none" type="number" min={0} value={limit} onChange={(e) => setLimit(Number(e.currentTarget.value))}/>
          </div>
        </div>
        <TabsContent value="vento">
          <WindSensorTab limit={limit}/>
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

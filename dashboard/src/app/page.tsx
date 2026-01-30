import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { Input } from "@/components/ui/input"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

type InvoiceRow = {
  id: number
  date: string
  value: number
}

const columns: ColumnDef<InvoiceRow>[] = [
  { label: "ID", name: "id" },
  { label: "Data", name: "date" },
  { label: "Valore", name: "value" },
]

const data: InvoiceRow[] = [
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
  { id: 1, date: "data", value: 250 },
]

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
        <TabsContent value="vento">
          <GenericTable columns={columns} data={data} />
        </TabsContent>
        <TabsContent value="pioggia">Change your password here.</TabsContent>
        <TabsContent value="allarmi">allarmi</TabsContent>
      </Tabs>
    </main>
  );
}

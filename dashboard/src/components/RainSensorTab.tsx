'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useRainSensor } from "@/lib/api/queries/rainSensor";
import { RainSensor } from "@/lib/api/types";

const columns: ColumnDef<RainSensor>[] = [
  { label: "ID", name: "id" },
  { label: "Data", name: "date" },
  { 
    label: "Pioggia", 
    name: (row: RainSensor) => row.rain ? "Sì" : "No" 
  },
];

type RainSensorTab = {
  limit : number;
}

export function RainSensorTab({limit} : RainSensorTab) {
  const { data, isLoading, error } = useRainSensor({ limit });

  if (isLoading) {
    return (
      <div className="flex items-center justify-center py-8">
        <p className="text-muted-foreground">Caricamento dati sensore pioggia...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex items-center justify-center py-8">
        <p className="text-destructive">Errore nel caricamento: {error.message}</p>
      </div>
    );
  }

  return <GenericTable columns={columns} data={data || []} />;
}

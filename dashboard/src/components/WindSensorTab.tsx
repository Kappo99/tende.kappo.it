'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useWindSensor } from "@/lib/api/queries/windSensor";
import { WindSensor } from "@/lib/api/types";

const columns: ColumnDef<WindSensor>[] = [
  { label: "ID", name: "id" },
  { label: "Data", name: "date" },
  { label: "Frequenza", name: "frequency" },
];

export function WindSensorTab() {
  const { data, isLoading, error } = useWindSensor({ 'wind-limit': 50 });

  if (isLoading) {
    return (
      <div className="flex items-center justify-center py-8">
        <p className="text-muted-foreground">Caricamento dati sensore vento...</p>
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

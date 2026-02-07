'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useWindSensor } from "@/lib/api/queries/windSensor";
import { WindSensor } from "@/lib/api/types";
import { compressZeros } from "@/utils/functions";

const columns: ColumnDef<WindSensor>[] = [
  { label: "ID", name: (r) => r._placeholder ? "..." : r.id },
  { label: "Data", name: (r) => r._placeholder ? "..." : r.date },
  {
    label: "Frequenza",
    name: (r) => (r._placeholder ? "..." : r.frequency),
    className: (r) => {
      // Placeholder (riga "...") sempre grigia
      if ((r as any)._placeholder) return "text-muted-foreground";

      // Priorità: >1500 grigio, altrimenti >0 rosso
      const freq = (r as any).frequency as number | undefined;
      if (typeof freq === "number" && freq > 1500) return "text-muted-foreground";
      if (typeof freq === "number" && freq > 0) return "text-destructive";

      return "";
    },
  },
];

type WindSensorTab = {
  limit: number;
};

export function WindSensorTab({ limit }: WindSensorTab) {
  const { data, isLoading, error } = useWindSensor({ limit /* minValue: 10 */ });

  const dataCompressed = compressZeros(data || []);

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

  return <GenericTable columns={columns} data={dataCompressed || []} />;
}

'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useAlarmRegister } from "@/lib/api/queries/alarmRegister";
import { AlarmRegister } from "@/lib/api/types";

const columns: ColumnDef<AlarmRegister>[] = [
  { label: "ID", name: "id" },
  { label: "Data", name: "date" },
  { label: "Allarme", name: "alarm" },
  { 
    label: "Attivo", 
    name: (row: AlarmRegister) => row.active ? "Sì" : "No" 
  },
];

export function AlarmRegisterTab() {
  const { data, isLoading, error } = useAlarmRegister({ limit: 50 });

  if (isLoading) {
    return (
      <div className="flex items-center justify-center py-8">
        <p className="text-muted-foreground">Caricamento registro allarmi...</p>
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

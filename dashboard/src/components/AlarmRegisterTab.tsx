'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useAlarmRegister } from "@/lib/api/queries/alarmRegister";
import { AlarmRegister } from "@/lib/api/types";

const columns: ColumnDef<AlarmRegister>[] = [
  { label: "ID", name: "id" },
  { label: "Data", name: "date" },
  { label: "Allarme", name: "alarm", className: (row: AlarmRegister) => row.active ? "text-red-600 font-bold" : ""  },
];

type AlarmRegisterTab = {
  limit : number;
}

export function AlarmRegisterTab({limit} : AlarmRegisterTab) {
  const { data, isLoading, error } = useAlarmRegister({ limit});

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

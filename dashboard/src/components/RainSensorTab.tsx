'use client';

import { ColumnDef, GenericTable } from "@/components/GenericTable";
import { useRainSensor } from "@/lib/api/queries/rainSensor";
import { RainSensor } from "@/lib/api/types";

type RainRow = RainSensor & { _placeholder?: boolean };

function compressNoRuns(rows: RainSensor[]): RainRow[] {
  const out: RainRow[] = [];
  let i = 0;

  while (i < rows.length) {
    const r = rows[i];

    // Se è "Sì" (piove), non comprimo
    if (r.rain) {
      out.push(r);
      i++;
      continue;
    }

    // Run consecutiva di "No"
    let j = i;
    while (j < rows.length && rows[j].rain === false) j++;

    const runLen = j - i;

    // ✅ Se la run è 1 o 2, NON ha senso inserire "..."
    // perché non ci sono righe "intermedie" da nascondere.
    if (runLen <= 2) {
      for (let k = i; k < j; k++) out.push(rows[k]);
      i = j;
      continue;
    }

    // ✅ runLen >= 3: prima, "...", ultima
    const first = rows[i];
    const last = rows[j - 1];

    out.push(first);

    out.push({
      ...first,
      id: -Math.abs(first.id), // id finto numerico
      _placeholder: true,
    });

    out.push(last);

    i = j;
  }

  return out;
}

const columns: ColumnDef<RainRow>[] = [
  {
    label: "ID",
    name: (r) => (r._placeholder ? "..." : r.id),
    className: (r) => (r._placeholder ? "text-muted-foreground" : ""),
  },
  {
    label: "Data",
    name: (r) => (r._placeholder ? "..." : r.date),
    className: (r) => (r._placeholder ? "text-muted-foreground" : ""),
  },
  {
    label: "Pioggia",
    name: (r) => (r._placeholder ? "..." : (r.rain ? "Sì" : "No")),
    className: (r) => {
      if (r._placeholder) return "text-muted-foreground";
      return r.rain ? "text-destructive" : "";
    },
  },
];

type RainSensorTabProps = {
  limit: number;
};

export function RainSensorTab({ limit }: RainSensorTabProps) {
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

  const compact = compressNoRuns(data || []);

  return <GenericTable columns={columns} data={compact} />;
}

# API Client Documentation

Questo modulo gestisce tutte le comunicazioni tra il frontend Next.js e il backend PHP/Slim.

## Struttura

```
api/
├── config.ts          # Configurazione endpoint e base URL
├── client.ts          # Client axios centralizzato
├── types.ts           # Tipi TypeScript dai DTO PHP
├── schemas.ts         # Schema Zod per validazione runtime
└── queries/
    ├── windSensor.ts      # Hook per sensore vento
    ├── rainSensor.ts      # Hook per sensore pioggia
    └── alarmRegister.ts   # Hook per registro allarmi
```

## Configurazione

### Variabili d'Ambiente

Crea un file `.env.local` nella root del progetto `dashboard/`:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Per produzione, imposta l'URL del backend reale.

## Utilizzo

### Esempio Base

```tsx
'use client';

import { useWindSensor } from '@/lib/api/queries/windSensor';

export function MyComponent() {
  const { data, isLoading, error } = useWindSensor({ 'wind-limit': 10 });

  if (isLoading) return <div>Caricamento...</div>;
  if (error) return <div>Errore: {error.message}</div>;

  return <div>{/* Usa i dati */}</div>;
}
```

### Con Parametri

```tsx
const { data } = useWindSensor({
  date: '2024-01-31',
  'wind-limit': 50,
  'min-value': 100
});
```

### Hook Disponibili

#### Wind Sensor
- `useWindSensor(params)` - Lista dati sensore vento
- `useWindSensorConsecutive(params)` - Valori consecutivi
- `useWindSensorMinutes()` - Minuti dall'ultimo record

#### Rain Sensor
- `useRainSensor(params)` - Lista dati sensore pioggia

#### Alarm Register
- `useAlarmRegister(params)` - Lista registro allarmi

## Caratteristiche

### Caching Automatico
TanStack Query gestisce automaticamente il caching:
- **staleTime**: 30 secondi (dati considerati "freschi")
- **gcTime**: 5 minuti (tempo di cache)
- I dati vengono riutilizzati se i parametri non cambiano

### Validazione con Zod
Tutte le risposte API vengono validate con Zod per garantire type safety a runtime.

### Gestione Errori
Gli errori vengono gestiti centralmente nel client axios e propagati agli hook.

## Estendere l'API

Per aggiungere un nuovo endpoint:

1. Aggiungi l'endpoint in `config.ts`
2. Definisci i tipi in `types.ts`
3. Crea lo schema Zod in `schemas.ts`
4. Crea l'hook in `queries/`
5. Usa l'hook nei componenti

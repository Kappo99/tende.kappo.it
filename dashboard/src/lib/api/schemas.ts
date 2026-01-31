/**
 * Zod schemas per validazione runtime delle risposte API
 */
import { z } from 'zod';

// Validazione per date MySQL (YYYY-MM-DD HH:MM:SS) o ISO datetime
const dateStringSchema = z.string().refine(
  (val) => {
    // Accetta formato MySQL datetime (YYYY-MM-DD HH:MM:SS) o ISO datetime
    const mysqlDateTimeRegex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
    const isoDateTimeRegex = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/;
    return mysqlDateTimeRegex.test(val) || isoDateTimeRegex.test(val) || !isNaN(Date.parse(val));
  },
  { message: 'Formato data non valido' }
);

// Wind Sensor Schema
export const windSensorSchema = z.object({
  id: z.number().int().positive(),
  date: dateStringSchema,
  frequency: z.number().int().nonnegative(),
});

export const windSensorArraySchema = z.array(windSensorSchema);

// Rain Sensor Schema
export const rainSensorSchema = z.object({
  id: z.number().int().positive(),
  date: dateStringSchema,
  rain: z.boolean(),
});

export const rainSensorArraySchema = z.array(rainSensorSchema);

// Alarm Register Schema
export const alarmRegisterSchema = z.object({
  id: z.number().int().positive(),
  date: dateStringSchema,
  alarm: z.string(),
  active: z.boolean(),
});

export const alarmRegisterArraySchema = z.array(alarmRegisterSchema);

// Consecutive Values Response Schema (basato su ConsecutiveValueResponseDto)
// Nota: ConsecutiveValueResponseDto ha solo id e date, non frequency
export const consecutiveValueSchema = z.object({
  id: z.number().int().positive(),
  date: dateStringSchema,
});

export const consecutiveValueArraySchema = z.array(consecutiveValueSchema);

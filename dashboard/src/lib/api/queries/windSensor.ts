/**
 * TanStack Query hooks per Wind Sensor
 */
import { useQuery, UseQueryOptions } from '@tanstack/react-query';
import { apiClient } from '../client';
import { API_ENDPOINTS } from '../config';
import { WindSensor, WindSensorRequestParams, WindSensorConsecutiveParams, ConsecutiveValue } from '../types';
import { windSensorArraySchema, consecutiveValueArraySchema } from '../schemas';

// Query keys
export const windSensorKeys = {
  all: ['windSensor'] as const,
  lists: () => [...windSensorKeys.all, 'list'] as const,
  list: (params: WindSensorRequestParams) => [...windSensorKeys.lists(), params] as const,
  consecutive: (params: WindSensorConsecutiveParams) => [...windSensorKeys.all, 'consecutive', params] as const,
  minutes: () => [...windSensorKeys.all, 'minutes'] as const,
};

/**
 * Hook per ottenere i dati del sensore vento
 */
export function useWindSensor(
  params: WindSensorRequestParams = {},
  options?: Omit<UseQueryOptions<WindSensor[], Error>, 'queryKey' | 'queryFn'>
) {
  return useQuery<WindSensor[], Error>({
    queryKey: windSensorKeys.list(params),
    queryFn: async () => {
      const queryParams = new URLSearchParams();
      
      if (params.date) queryParams.append('date', params.date);
      if (params.limit) queryParams.append('limit', params.limit.toString());
      if (params.minValue) queryParams.append('minValue', params.minValue.toString());
      
      const url = `${API_ENDPOINTS.WIND_SENSOR}${queryParams.toString() ? `?${queryParams.toString()}` : ''}`;
      const data = await apiClient.get<WindSensor[]>(url);
      
      // Validazione con Zod
      return windSensorArraySchema.parse(data);
    },
    staleTime: 30000, // I dati sono considerati "freschi" per 30 secondi
    gcTime: 5 * 60 * 1000, // Cache per 5 minuti (ex cacheTime)
    ...options,
  });
}

/**
 * Hook per ottenere valori consecutivi del sensore vento
 */
export function useWindSensorConsecutive(
  params: WindSensorConsecutiveParams,
  options?: Omit<UseQueryOptions<ConsecutiveValue[], Error>, 'queryKey' | 'queryFn'>
) {
  return useQuery<ConsecutiveValue[], Error>({
    queryKey: windSensorKeys.consecutive(params),
    queryFn: async () => {
      const queryParams = new URLSearchParams();
      queryParams.append('date', params.date);
      queryParams.append('consValue', params.consValue.toString());
      queryParams.append('min', params.min.toString());
      queryParams.append('max', params.max.toString());
      
      const url = `${API_ENDPOINTS.WIND_SENSOR_CONSECUTIVE}?${queryParams.toString()}`;
      const data = await apiClient.get<ConsecutiveValue[]>(url);
      
      // Validazione con Zod
      return consecutiveValueArraySchema.parse(data);
    },
    enabled: !!params.date && !!params.consValue, // Esegui solo se i parametri obbligatori sono presenti
    staleTime: 30000,
    gcTime: 5 * 60 * 1000,
    ...options,
  });
}

/**
 * Hook per ottenere i minuti dall'ultimo record
 */
export function useWindSensorMinutes(
  options?: Omit<UseQueryOptions<{ minutes: number }, Error>, 'queryKey' | 'queryFn'>
) {
  return useQuery<{ minutes: number }, Error>({
    queryKey: windSensorKeys.minutes(),
    queryFn: async () => {
      const data = await apiClient.get<{ minutes: number }>(API_ENDPOINTS.WIND_SENSOR_MINUTES);
      return data;
    },
    staleTime: 10000, // I minuti cambiano frequentemente, cache più breve
    gcTime: 2 * 60 * 1000,
    refetchInterval: 30000, // Refetch ogni 30 secondi per aggiornare i minuti
    ...options,
  });
}

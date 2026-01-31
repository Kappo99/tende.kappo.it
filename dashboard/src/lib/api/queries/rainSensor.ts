/**
 * TanStack Query hooks per Rain Sensor
 */
import { useQuery, UseQueryOptions } from '@tanstack/react-query';
import { apiClient } from '../client';
import { API_ENDPOINTS } from '../config';
import { RainSensor, RainSensorRequestParams } from '../types';
import { rainSensorArraySchema } from '../schemas';

// Query keys
export const rainSensorKeys = {
  all: ['rainSensor'] as const,
  lists: () => [...rainSensorKeys.all, 'list'] as const,
  list: (params: RainSensorRequestParams) => [...rainSensorKeys.lists(), params] as const,
};

/**
 * Hook per ottenere i dati del sensore pioggia
 */
export function useRainSensor(
  params: RainSensorRequestParams = {},
  options?: Omit<UseQueryOptions<RainSensor[], Error>, 'queryKey' | 'queryFn'>
) {
  return useQuery<RainSensor[], Error>({
    queryKey: rainSensorKeys.list(params),
    queryFn: async () => {
      const queryParams = new URLSearchParams();
      
      if (params.date) queryParams.append('date', params.date);
      if (params['rain-limit']) queryParams.append('rain-limit', params['rain-limit'].toString());
      
      const url = `${API_ENDPOINTS.RAIN_SENSOR}${queryParams.toString() ? `?${queryParams.toString()}` : ''}`;
      const data = await apiClient.get<RainSensor[]>(url);
      
      // Validazione con Zod
      return rainSensorArraySchema.parse(data);
    },
    staleTime: 30000, // I dati sono considerati "freschi" per 30 secondi
    gcTime: 5 * 60 * 1000, // Cache per 5 minuti
    ...options,
  });
}

/**
 * TanStack Query hooks per Alarm Register
 */
import { useQuery, UseQueryOptions } from '@tanstack/react-query';
import { apiClient } from '../client';
import { API_ENDPOINTS } from '../config';
import { AlarmRegister, AlarmRegisterRequestParams } from '../types';
import { alarmRegisterArraySchema } from '../schemas';

// Query keys
export const alarmRegisterKeys = {
  all: ['alarmRegister'] as const,
  lists: () => [...alarmRegisterKeys.all, 'list'] as const,
  list: (params: AlarmRegisterRequestParams) => [...alarmRegisterKeys.lists(), params] as const,
};

/**
 * Hook per ottenere i dati del registro allarmi
 */
export function useAlarmRegister(
  params: AlarmRegisterRequestParams = {},
  options?: Omit<UseQueryOptions<AlarmRegister[], Error>, 'queryKey' | 'queryFn'>
) {
  return useQuery<AlarmRegister[], Error>({
    queryKey: alarmRegisterKeys.list(params),
    queryFn: async () => {
      const queryParams = new URLSearchParams();
      
      if (params.date) queryParams.append('date', params.date);
      if (params['register-limit']) queryParams.append('register-limit', params['register-limit'].toString());
      
      const url = `${API_ENDPOINTS.ALARM_REGISTER}${queryParams.toString() ? `?${queryParams.toString()}` : ''}`;
      const data = await apiClient.get<AlarmRegister[]>(url);
      
      // Validazione con Zod
      return alarmRegisterArraySchema.parse(data);
    },
    staleTime: 30000, // I dati sono considerati "freschi" per 30 secondi
    gcTime: 5 * 60 * 1000, // Cache per 5 minuti
    ...options,
  });
}

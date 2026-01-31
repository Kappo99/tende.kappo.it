/**
 * TypeScript types basati sui DTO PHP del backend
 */

// Wind Sensor Types
export interface WindSensor {
  id: number;
  date: string;
  frequency: number;
}

export interface WindSensorRequestParams {
  date?: string;
  'wind-limit'?: number;
  'min-value'?: number;
}

export interface WindSensorConsecutiveParams {
  date: string;
  'cons-value': number;
  'wind-min': number;
  'wind-max': number;
}

// Consecutive Value (diverso da WindSensor, ha solo id e date)
export interface ConsecutiveValue {
  id: number;
  date: string;
}

// Rain Sensor Types
export interface RainSensor {
  id: number;
  date: string;
  rain: boolean;
}

export interface RainSensorRequestParams {
  date?: string;
  'rain-limit'?: number;
}

// Alarm Register Types
export interface AlarmRegister {
  id: number;
  date: string;
  alarm: string;
  active: boolean;
}

export interface AlarmRegisterRequestParams {
  date?: string;
  'register-limit'?: number;
}

// API Response wrapper
export interface ApiResponse<T> {
  data: T;
  success: boolean;
  message?: string;
}

// Error response
export interface ApiError {
  message: string;
  code?: number;
  errors?: Record<string, string[]>;
}

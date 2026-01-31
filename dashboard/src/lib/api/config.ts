/**
 * API Configuration
 * Base URL per le chiamate al backend
 */
export const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL;

export const API_ENDPOINTS = {
  // Wind Sensor
  WIND_SENSOR: '/wind-sensor',
  WIND_SENSOR_CONSECUTIVE: '/wind-sensor/consecutive-values',
  WIND_SENSOR_MINUTES: '/wind-sensor/minutes',
  
  // Rain Sensor
  RAIN_SENSOR: '/rain-sensor',
  
  // Alarm Register
  ALARM_REGISTER: '/alarm-register',
  
  // Health Check
  HEALTH: '/health',
} as const;

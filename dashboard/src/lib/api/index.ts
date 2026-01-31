/**
 * Barrel export per facilitare l'importazione degli hook e tipi API
 */

// Hooks
export * from './queries/windSensor';
export * from './queries/rainSensor';
export * from './queries/alarmRegister';

// Types
export * from './types';

// Config
export { API_BASE_URL, API_ENDPOINTS } from './config';

// Client (esportato per casi avanzati)
export { apiClient } from './client';

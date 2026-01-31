/**
 * Axios client centralizzato per le chiamate API
 */
import axios, { AxiosInstance, AxiosError, AxiosRequestConfig } from 'axios';
import { API_BASE_URL } from './config';
import { ApiError } from './types';

// Formato risposta standard del backend PHP
interface ApiResponseWrapper<T> {
  code: number;
  message: string;
  data?: T;
  errors?: Record<string, string[]>;
}

class ApiClient {
  private client: AxiosInstance;

  constructor() {
    this.client = axios.create({
      baseURL: API_BASE_URL,
      timeout: 10000, // 10 secondi
      headers: {
        'Content-Type': 'application/json',
      },
    });

    // Request interceptor
    this.client.interceptors.request.use(
      (config) => {
        // Qui puoi aggiungere token di autenticazione se necessario
        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );

    // Response interceptor per gestione errori centralizzata
    this.client.interceptors.response.use(
      (response) => {
        return response;
      },
      (error: AxiosError) => {
        const apiError: ApiError = {
          message: error.message || 'Errore nella richiesta',
          code: error.response?.status,
        };

        if (error.response?.data) {
          // Il backend restituisce un formato di errore standard
          const errorData = error.response.data as ApiResponseWrapper<never>;
          if (errorData.message) {
            apiError.message = errorData.message;
          }
          if (errorData.errors) {
            apiError.errors = errorData.errors;
          }
          if (errorData.code) {
            apiError.code = errorData.code;
          }
        }

        return Promise.reject(apiError);
      }
    );
  }

  /**
   * GET request con estrazione del campo data dalla risposta wrapper
   */
  async get<T>(url: string, config?: AxiosRequestConfig): Promise<T> {
    const response = await this.client.get<ApiResponseWrapper<T>>(url, config);
    
    // Il backend restituisce { code, message, data }
    // Estraiamo solo il campo data
    if (response.data.data !== undefined) {
      return response.data.data;
    }
    
    // Se non c'è data, restituiamo l'intera risposta (per casi come minutes)
    return response.data as unknown as T;
  }

  /**
   * POST request (non utilizzato dalla dashboard, ma disponibile per future estensioni)
   */
  async post<T>(url: string, data?: any, config?: AxiosRequestConfig): Promise<T> {
    const response = await this.client.post<ApiResponseWrapper<T>>(url, data, config);
    
    if (response.data.data !== undefined) {
      return response.data.data;
    }
    
    return response.data as unknown as T;
  }
}

// Export singleton instance
export const apiClient = new ApiClient();

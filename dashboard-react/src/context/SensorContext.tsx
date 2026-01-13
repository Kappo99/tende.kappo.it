// src/context/SensorContext.tsx

import React, { createContext, useContext, useState, useEffect } from 'react';

// Definizione del tipo per l'utente
interface Sensor {
  id: number;
  name: string;
  email: string;
}

// Definizione del tipo del contesto
interface SensorContextType {
  sensors: Sensor[];
  fetchSensors: () => Promise<void>; // Funzione per recuperare gli utenti
}

// Crea il contesto
const SensorContext = createContext<SensorContextType | undefined>(undefined);

// Creazione del provider
export const SensorProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [sensors, setSensors] = useState<Sensor[]>([]);

  // Funzione per fare una chiamata API e recuperare gli utenti
  const fetchSensors = async () => {
    try {
      const response = await fetch('/api/sensors'); // URL dell'API
      const data = await response.json();
      setSensors(data);
    } catch (error) {
      console.error("Errore nel recupero degli utenti:", error);
    }
  };

  // Carica gli utenti all'inizio
  useEffect(() => {
    fetchSensors();
  }, []);

  return (
    <SensorContext.Provider value={{ sensors, fetchSensors }}>
      {children}
    </SensorContext.Provider>
  );
};

// Custom hook per usare il contesto degli utenti
export const useSensors = (): SensorContextType => {
  const context = useContext(SensorContext);
  if (context === undefined) {
    throw new Error('useSensors deve essere utilizzato all\'interno di un SensorProvider');
  }
  return context;
};

// src/context/SensorContext.tsx

import React, { createContext, useContext, useState, useEffect } from 'react';

// Definizione del tipo per l'utente
interface Sensor {
  id: number;
  data: string;
  frequenza: number;
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
      // const response = await fetch('/api/sensors'); // URL dell'API
      // const data = await response.json();

      const data = [];
      let currentId = 450;
      let currentDate = new Date('2024-09-01T22:34:25');
      console.log('API');
      

      while (currentId >= 1) {
        let freq = Math.floor(Math.random() * 2001) - 700;
        if (freq < 0)
          freq = 0;
        data.push({
          id: currentId,
          data: currentDate.toISOString().replace('T', ' ').substring(0, 19), // formato data "YYYY-MM-DD HH:MM:SS"
          frequenza: freq
        });

        // Genera un intervallo casuale di 1 o 2 secondi
        const interval = Math.random() < 0.5 ? 1000 : 2000;

        // Riduci la data corrente di quell'intervallo
        currentDate = new Date(currentDate.getTime() - interval);

        // Decrementa l'ID
        currentId--;
      }

      setSensors(data);
    } catch (error) {
      console.error('Errore nel recupero degli utenti:', error);
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

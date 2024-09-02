// src/App.tsx
import React from 'react';
import Dashboard from './pages/Dashboard';
import { SensorProvider } from './context/SensorContext';

const App: React.FC = () => {
  return (
    <SensorProvider>
      <Dashboard />
    </SensorProvider>
  );
}

export default App;

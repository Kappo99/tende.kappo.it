'use client';

/**
 * QueryClientProvider per TanStack Query
 * Wrapper necessario per utilizzare React Query in Next.js App Router
 */
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ReactNode, useState } from 'react';

export function QueryProvider({ children }: { children: ReactNode }) {
  // Creiamo il QueryClient nello stato per evitare di condividerlo tra richieste SSR
  const [queryClient] = useState(
    () =>
      new QueryClient({
        defaultOptions: {
          queries: {
            // Configurazione di default per tutte le query
            staleTime: 30000, // 30 secondi
            gcTime: 5 * 60 * 1000, // 5 minuti (ex cacheTime)
            retry: 1, // Riprova una volta in caso di errore
            refetchOnWindowFocus: true, // Refetch quando la finestra torna in focus
            refetchOnReconnect: true, // Refetch quando si riconnette
          },
        },
      })
  );

  return (
    <QueryClientProvider client={queryClient}>{children}</QueryClientProvider>
  );
}

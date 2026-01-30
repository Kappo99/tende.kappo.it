# Variabili d'Ambiente

## APP_ENV

**Scopo**: Definisce l'ambiente di esecuzione dell'applicazione.

**Valori possibili**:
- `development` - Ambiente di sviluppo (default)
- `production` - Ambiente di produzione

**Utilizzo**:
- In **development**: vengono mostrati dettagli completi degli errori, stack trace, ecc.
- In **production**: vengono mostrati solo messaggi di errore generici per sicurezza

**Esempio**:
```env
APP_ENV=production
```

## LOG_LEVEL

**Scopo**: Definisce il livello minimo di logging da registrare.

**Valori possibili** (in ordine di priorità crescente):
- `debug` - Tutti i log (default)
- `info` - Informazioni generali
- `notice` - Notifiche importanti
- `warning` - Avvisi
- `error` - Errori
- `critical` - Errori critici
- `alert` - Allarmi
- `emergency` - Emergenze

**Utilizzo**:
- Se impostato a `debug`, vengono registrati tutti i log
- Se impostato a `error`, vengono registrati solo errori, critical, alert ed emergency
- Utile per ridurre il volume di log in produzione

**Esempio**:
```env
LOG_LEVEL=error
```

## MINUTI

**Scopo**: Definisce il numero minimo di minuti che devono passare tra un allarme attivo e il successivo.

**Valore**: Numero intero (default: 30)

**Utilizzo**:
- Quando viene inserito un nuovo allarme, viene verificato se sono passati almeno `MINUTI` minuti dall'ultimo allarme attivo
- Se sì, l'allarme viene marcato come `active = 1` e può essere notificato
- Se no, l'allarme viene marcato come `active = 0` e non viene notificato

**Esempio**:
```env
MINUTI=30
```

## Note

Tutte le variabili hanno valori di default, quindi l'applicazione funzionerà anche senza il file `.env`, ma è consigliabile configurarle correttamente per ogni ambiente.

# Configurazione File di Ambiente

## Struttura File

L'applicazione supporta tre tipi di file di configurazione:

1. **`.env`** (opzionale) - File base con valori di default
2. **`.env.development`** - Configurazione per ambiente di sviluppo
3. **`.env.production`** - Configurazione per ambiente di produzione

## Come Funziona il Caricamento

Il sistema carica i file in questo ordine:

1. **Prima** carica `.env` (se esiste) - valori base
2. **Poi** carica `.env.{APP_ENV}` (se esiste) - sovrascrive i valori base

### Determinazione dell'Ambiente

L'ambiente viene determinato in questo ordine di priorità:

1. **Variabile d'ambiente del server** (`$_SERVER['APP_ENV']` o `getenv('APP_ENV')`)
   - Impostabile nel server web (Apache/Nginx) o nel sistema operativo
   - **Raccomandato per produzione** per maggiore sicurezza
   
2. **Valore nel file `.env`** (chiave `APP_ENV`)
   - Se non esiste variabile d'ambiente del server
   
3. **Default**: `development`

## Setup Consigliato

### Per Sviluppo Locale

```bash
# Copia il file di esempio
cp .env.development.example .env.development

# Modifica i valori in .env.development
# L'applicazione caricherà automaticamente questo file se APP_ENV=development
```

### Per Produzione

**Opzione 1: Variabile d'ambiente del server (RACCOMANDATO)**

Imposta la variabile d'ambiente nel server:

```bash
# Linux/Apache (.htaccess o virtual host)
SetEnv APP_ENV production

# Nginx
fastcgi_param APP_ENV production;

# Oppure nel sistema operativo
export APP_ENV=production
```

Poi crea il file:
```bash
cp .env.production.example .env.production
# Modifica i valori sensibili (password, ecc.)
```

**Opzione 2: Solo file .env.production**

Crea solo `.env.production` con `APP_ENV=production` dentro.

### File .env Base (Opzionale)

Il file `.env` è opzionale. Puoi:
- **Non usarlo**: Usa solo `.env.development` e `.env.production`
- **Usarlo per valori comuni**: Metti valori condivisi tra ambienti, poi sovrascrivi con i file specifici

## Esempi

### Esempio 1: Solo file specifici per ambiente

```
api/
├── .env.development    # Solo per sviluppo
└── .env.production     # Solo per produzione
```

### Esempio 2: Con file base

```
api/
├── .env                # Valori comuni (opzionale)
├── .env.development    # Sovrascrive .env per sviluppo
└── .env.production     # Sovrascrive .env per produzione
```

### Esempio 3: Con variabile d'ambiente server

```bash
# Nel server (produzione)
export APP_ENV=production

# File necessari
api/
└── .env.production     # Viene caricato automaticamente
```

## Sicurezza

⚠️ **IMPORTANTE**: 

- **NON committare** file `.env*` con dati sensibili nel repository
- Usa `.gitignore` per escluderli (già configurato)
- In produzione, preferisci variabili d'ambiente del server invece di file `.env`
- I file `.env.example` e `.env.*.example` sono template sicuri da committare

## Verifica

Per verificare quale ambiente è attivo, controlla l'endpoint:

```bash
GET /api/health
```

Oppure aggiungi temporaneamente nel codice:

```php
echo "Ambiente attivo: " . ($_ENV['APP_ENV'] ?? 'non definito');
```

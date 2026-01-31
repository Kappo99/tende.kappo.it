# API Backend - Tende Kappo Smart Home

API REST backend sviluppata con PHP Slim Framework per gestire i dati dei sensori della centralina tende.

## Struttura del Progetto

```
api/
├── config/              # File di configurazione
│   ├── database.php      # Configurazione database
│   ├── dependencies.php # Dependency Injection container
│   └── routes.php       # Definizione routes
├── public/              # Entry point pubblico
│   ├── index.php        # Bootstrap applicazione
│   └── .htaccess        # Rewrite rules
├── src/
│   ├── Bootstrap/       # Bootstrap applicazione
│   ├── Common/          # Classi astratte generiche
│   │   ├── BaseModel.php
│   │   ├── BaseRepository.php
│   │   ├── BaseService.php
│   │   ├── BaseManager.php
│   │   ├── BaseController.php
│   │   └── BaseDto.php
│   ├── Controllers/     # Controller layer
│   ├── Database/        # Database connection
│   ├── Dto/            # Data Transfer Objects
│   │   ├── Request/    # Request DTOs
│   │   └── Response/   # Response DTOs
│   ├── Managers/        # Manager layer (business logic)
│   ├── Models/         # Model layer (entities)
│   ├── Repositories/   # Repository layer (data access)
│   └── Services/       # Service layer
└── composer.json       # Dipendenze PHP
```

## Architettura

Il progetto segue un'architettura a livelli:

1. **Controller** → Gestisce le richieste HTTP e le risposte
2. **Manager** → Logica di business
3. **Service** → Logica applicativa
4. **Repository** → Accesso ai dati
5. **Model** → Entità del dominio

Ogni livello utilizza classi astratte generiche (`Base*`) per ridurre la duplicazione del codice.

## Installazione

1. Installa le dipendenze:
```bash
cd api
composer install
```

2. Configura le variabili d'ambiente:
```bash
# Per sviluppo locale
cp .env.development.example .env.development
# Modifica .env.development con le tue credenziali database

# Per produzione
cp .env.production.example .env.production
# Modifica .env.production con le credenziali di produzione
```

3. Avvia il server di sviluppo:
```bash
# Windows
start-server.bat

# Linux/Mac
chmod +x start-server.sh
./start-server.sh

# Oppure manualmente
php -S localhost:8000 -t public
```

Il server sarà disponibile su: **http://localhost:8000**

Per maggiori dettagli sul testing, vedi [TESTING.md](TESTING.md)

## Endpoint Disponibili

### Sensore Vento
- `GET /api/wind-sensor` - Recupera i dati del sensore vento
  - Query params: `date`, `minValue`, `limit`
  
- `POST /api/wind-sensor` - Inserisce dati del sensore vento
  - Body: `{ "frequency": [100, 200, 300], "date": ["2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00"] }`
  - Supporta anche array JSON come stringhe: `{ "frequency": "[100,200,300]", "date": "[\"2024-01-31 10:00:00\",\"2024-01-31 10:01:00\"]" }`
  
- `GET /api/wind-sensor/consecutive-values` - Recupera valori consecutivi
  - Query params: `date`, `consValue`, `min`, `max`
  
- `GET /api/wind-sensor/minutes` - Calcola i minuti dall'ultimo record inserito

### Sensore Pioggia
- `GET /api/rain-sensor` - Recupera i dati del sensore pioggia
  - Query params: `date`, `limit`
  
- `POST /api/rain-sensor` - Inserisce dati del sensore pioggia
  - Body: `{ "rain": [true, false, true], "date": ["2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00"] }`
  - Supporta anche array JSON come stringhe

### Registro Allarmi
- `GET /api/alarm-register` - Recupera il registro allarmi
  - Query params: `date`, `limit`
  
- `POST /api/alarm-register` - Inserisce un nuovo allarme
  - Body: `{ "idAlarm": 1 }`
  - Logica: Se sono passati almeno `MINUTI` (default: 30) dall'ultimo allarme attivo, l'allarme viene marcato come attivo
  - Response include: `minutes` (minuti dall'ultimo), `active` (se l'allarme è attivo), `shouldNotify` (se deve essere notificato)

### Health Check
- `GET /api/health` - Verifica lo stato dell'API

## Esempi di Utilizzo

### Recuperare dati vento per una data specifica
```
GET /api/wind-sensor?date=2024-01-31&limit=50
```

### Recuperare valori consecutivi
```
GET /api/wind-sensor/consecutive-values?date=2024-01-31&consValue=5&min=150&max=1500
```

### Recuperare dati pioggia
```
GET /api/rain-sensor?date=2024-01-31&limit=100
```

### Inserire dati vento
```
POST /api/wind-sensor
Content-Type: application/json

{
  "frequency": [150, 200, 250],
  "date": ["2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00"]
}
```

### Inserire dati pioggia
```
POST /api/rain-sensor
Content-Type: application/json

{
  "rain": [true, false, true],
  "date": ["2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00"]
}
```

### Inserire un allarme
```
POST /api/alarm-register
Content-Type: application/json

{
  "idAlarm": 1
}
```

### Calcolare minuti dall'ultimo dato vento
```
GET /api/wind-sensor/minutes
```

## Formato Risposta

Tutte le risposte seguono questo formato:

```json
{
  "code": 200,
  "message": "Operazione eseguita con successo",
  "data": [...]
}
```

In caso di errore:

```json
{
  "code": 400,
  "message": "Messaggio di errore",
  "errors": []
}
```

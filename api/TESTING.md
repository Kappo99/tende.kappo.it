# Guida al Testing dell'API

## Avvio del Server di Sviluppo

### Windows

```bash
# Metodo 1: Usa lo script batch
start-server.bat

# Metodo 2: Comando manuale
cd api
php -S localhost:8000 -t public
```

### Linux/Mac

```bash
# Metodo 1: Usa lo script shell (dai i permessi di esecuzione prima)
chmod +x start-server.sh
./start-server.sh

# Metodo 2: Comando manuale
cd api
php -S localhost:8000 -t public
```

Il server sarà disponibile su: **http://localhost:8000**

## Test con Browser

Apri semplicemente nel browser:

```
http://localhost:8000/api/health
```

Dovresti vedere una risposta JSON:
```json
{
  "status": "ok",
  "timestamp": "2024-01-31 12:00:00"
}
```

## Test con Script Automatici

### Windows

```bash
test-api.bat
```

### Linux/Mac

```bash
chmod +x test-api.sh
./test-api.sh
```

## Test Manuali con cURL

### Health Check
```bash
curl -X GET http://localhost:8000/api/health
```

### Wind Sensor (GET)
```bash
# Base
curl -X GET http://localhost:8000/api/wind-sensor

# Con filtri
curl -X GET "http://localhost:8000/api/wind-sensor?date=2024-01-31&limit=10&minValue=100"
```

### Wind Sensor Minutes
```bash
curl -X GET http://localhost:8000/api/wind-sensor/minutes
```

### Rain Sensor (GET)
```bash
# Base
curl -X GET http://localhost:8000/api/rain-sensor

# Con filtri
curl -X GET "http://localhost:8000/api/rain-sensor?date=2024-01-31&limit=10"
```

### Alarm Register (GET)
```bash
# Base
curl -X GET http://localhost:8000/api/alarm-register

# Con filtri
curl -X GET "http://localhost:8000/api/alarm-register?date=2024-01-31&limit=10"
```

### Wind Sensor (POST)
```bash
curl -X POST http://localhost:8000/api/wind-sensor \
  -H "Content-Type: application/json" \
  -d "{\"frequency\":[100,200,300],\"date\":[\"2024-01-31 10:00:00\",\"2024-01-31 10:01:00\",\"2024-01-31 10:02:00\"]}"
```

### Rain Sensor (POST)
```bash
curl -X POST http://localhost:8000/api/rain-sensor \
  -H "Content-Type: application/json" \
  -d "{\"rain\":[true,false,true],\"date\":[\"2024-01-31 10:00:00\",\"2024-01-31 10:01:00\",\"2024-01-31 10:02:00\"]}"
```

### Alarm Register (POST)
```bash
curl -X POST http://localhost:8000/api/alarm-register \
  -H "Content-Type: application/json" \
  -d "{\"idAlarm\":1}"
```

## Test con Postman

1. **Importa la Collection** (vedi `postman-collection.json` se disponibile)
2. Oppure crea manualmente le richieste:
   - Method: `GET` o `POST`
   - URL: `http://localhost:8000/api/{endpoint}`
   - Headers: `Content-Type: application/json`
   - Body (solo per POST): JSON con i dati

### Esempio Health Check in Postman:
- Method: `GET`
- URL: `http://localhost:8000/api/health`
- Send

## Test con PowerShell (Windows)

```powershell
# Health Check
Invoke-RestMethod -Uri "http://localhost:8000/api/health" -Method Get

# Wind Sensor
Invoke-RestMethod -Uri "http://localhost:8000/api/wind-sensor?limit=5" -Method Get

# POST Wind Sensor
$body = @{
    frequency = @(100, 200, 300)
    date = @("2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00")
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/wind-sensor" -Method Post -Body $body -ContentType "application/json"
```

## Test con JavaScript/Fetch

Apri la console del browser su `http://localhost:8000` e prova:

```javascript
// Health Check
fetch('http://localhost:8000/api/health')
  .then(res => res.json())
  .then(data => console.log(data));

// Wind Sensor
fetch('http://localhost:8000/api/wind-sensor?wind-limit=5')
  .then(res => res.json())
  .then(data => console.log(data));

// POST Wind Sensor
fetch('http://localhost:8000/api/wind-sensor', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    frequency: [100, 200, 300],
    date: ["2024-01-31 10:00:00", "2024-01-31 10:01:00", "2024-01-31 10:02:00"]
  })
})
  .then(res => res.json())
  .then(data => console.log(data));
```

## Risposte Attese

### Successo (200/201)
```json
{
  "code": 200,
  "message": "Operazione eseguita con successo",
  "data": [...]
}
```

### Errore (400/500)
```json
{
  "code": 400,
  "message": "Messaggio di errore",
  "errors": []
}
```

## Troubleshooting

### Errore: "Could not connect to database"
- Verifica che il database sia avviato
- Controlla le credenziali in `.env` o `.env.development`
- Verifica che il file `.env.development` esista

### Errore: "Class not found"
- Esegui `composer install` nella cartella `api`
- Verifica che `vendor/autoload.php` esista

### Errore: "Route not found"
- Verifica che il server sia avviato su `localhost:8000`
- Controlla che l'URL sia corretto (es. `/api/health` non `/health`)

### Porta 8000 già in uso
- Cambia la porta: `php -S localhost:8080 -t public`
- Oppure ferma il processo che usa la porta 8000

## Verifica Rapida

Esegui questo comando per verificare che tutto funzioni:

```bash
curl http://localhost:8000/api/health
```

Se vedi una risposta JSON con `"status": "ok"`, tutto è configurato correttamente!

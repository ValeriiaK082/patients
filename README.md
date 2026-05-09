# Lab Results App

A full-stack application for managing patient lab results, built with Laravel (backend), Vue.js (frontend), and MySQL (database).

---

## Tech Stack

- **Backend**: Laravel 11, PHP 8.3, JWT Auth
- **Frontend**: Vue.js 3, Vite, Axios, Vue Router
- **Database**: MySQL 8.0
- **Infrastructure**: Docker, Docker Compose
- **CI/CD**: GitLab CI/CD

---

---

## How to Run Locally

### 1. Clone the repository

```bash
git clone https://github.com/ValeriiaK082/patients.git
cd patients
```

### 2. Configure environment

Open `backend/.env` and make sure the database section looks like this:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=labresults
DB_USERNAME=labuser
DB_PASSWORD=labpassword
```

### 3. Start all containers

```bash
docker compose up --build -d
```

This starts:

- MySQL database on port `3306`
- Laravel API on port `8000`
- Vue.js frontend on port `5173`

### 4. Run database migrations

```bash
docker exec lab_backend php artisan migrate
```

### 5. Import patient data from CSV

Copy the CSV file into the backend storage folder:

```bash
docker cp results.csv lab_backend:/var/www/html/storage/app/results.csv
```

Run the import command:

```bash
docker exec lab_backend php artisan import:results /var/www/html/storage/app/results.csv
```

Import logs are saved to `storage/logs/import.log`. Check them with:

```bash
docker exec lab_backend cat storage/logs/import.log
```

---

## API Endpoints

### POST /api/login

Authenticate a patient and receive a JWT token.

---

### GET /api/results

Returns the authenticated patient's data and lab results.

**Headers:**

```
Authorization: Bearer <token>
Accept: application/json
```

---

## CI/CD Pipeline (GitHub Actions)
 
The `.github/workflows/ci.yml` file defines 2 jobs that run automatically on every push to `main`:
 
| Job              | Description                                  |
|------------------|----------------------------------------------|
| `test-backend`   | Spins up PHP 8.3 + MySQL, runs Laravel tests |
| `build-frontend` | Installs Node 20, builds Vue.js app          |

### Run tests locally

```bash
docker exec lab_backend php artisan test
```

---

## Stopping the App

```bash
docker compose down
```

To also remove the database volume:

```bash
docker compose down -v
```


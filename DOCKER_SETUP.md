# PRMS - Patient Records Management System

## Complete Docker Setup

### Prerequisites
- Docker Desktop installed and running
- Git (to clone the repository)

### Quick Start

1. **Clone the repository:**
   ```bash
   git clone https://github.com/AltheaEHEM1/COMMITS-RDT.git
   cd COMMITS-RDT
   ```

2. **Copy environment file:**
   ```bash
   copy .env.example .env
   ```

3. **Update .env for Docker:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=prms
   DB_USERNAME=root
   DB_PASSWORD=

   MEILISEARCH_HOST=http://meilisearch:7700
   SCOUT_DRIVER=meilisearch
   ```

4. **Build and start all services:**
   ```bash
   docker-compose up -d
   ```

5. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Run migrations:**
   ```bash
   docker-compose exec app php artisan migrate:fresh --seed
   ```

7. **Import patient data to Meilisearch:**
   ```bash
   docker-compose exec app php artisan scout:import "App\Models\Patient"
   ```

### Access the Application

- **Laravel App**: http://localhost:8000
- **Vite Dev Server**: http://localhost:5173
- **Meilisearch**: http://localhost:7700
- **MySQL**: localhost:3306

### Useful Commands

```bash
# View logs
docker-compose logs -f app
docker-compose logs -f vite

# Stop all services
docker-compose down

# Rebuild containers
docker-compose up -d --build

# Access app container shell
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan [command]
```

### Development Workflow

1. Make changes to your code
2. Vite will automatically reload CSS/JS changes
3. Laravel changes are reflected immediately
4. Database changes persist in Docker volumes

## Important Notes

- All services run in containers
- Hot module replacement (HMR) works for frontend development
- Database data persists between container restarts
- Meilisearch data persists between container restarts
- Use `docker-compose down -v` to remove all data volumes

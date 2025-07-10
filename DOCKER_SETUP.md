# PRMS - Patient Records Management System

## Quick Start with Docker Desktop

### How to setup docker for meilisearch

1. Open Docker Desktop
2. Click on "Containers" in the left sidebar
3. Click the terminal button
4. Navigate to project directory using this command:
    ```bash
    cd "c:\laragon\www\COMMITS-RDT"
    ```
5. Run the docker-compose using this command:
    ```bash
    docker-compose up -d meilisearch
    ```
6. Wait for Meilisearch to start (check the logs for "Meilisearch is ready" or check if the container is active/running)
7. Go back to vscode or your IDE
8. Run this command in terminal to import existing patients:
    ```bash
    php artisan scout:import "App\Models\Patient"
    ```
9. Start Laravel: `php artisan serve`

## Important Notes

-   Meilisearch will be available at: http://localhost:7700
-   Laravel will be available at: http://localhost:8000
-   Patient search data persists between restarts
-   New patients are automatically indexed when created
-   Only need to run `scout:import` once after starting Meilisearch for the first time
-   You need to setup the Meilisearch configuration once (see .env.example for reference)

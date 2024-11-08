# Deploying Pharmacare Health Screening System on Docker Desktop (MacBook)

This guide provides step-by-step instructions for deploying the Pharmacare Health Screening System using Docker Desktop on a MacBook.

## Prerequisites

1. Install Docker Desktop for Mac from the official Docker website.
2. Ensure Docker Desktop is running on your MacBook.

## Steps for Deployment

1. Clone the repository (if you haven't already):
   ```
   git clone https://github.com/your-username/pharmacare-health-screening.git
   cd pharmacare-health-screening
   ```

2. Build the Docker image:
   ```
   docker build -t pharmacare-health-screening .
   ```

3. Create a Docker network for the application:
   ```
   docker network create pharmacare-network
   ```

4. Start a MySQL container:
   ```
   docker run --name pharmacare-mysql --network pharmacare-network -e MYSQL_ROOT_PASSWORD=your_root_password -e MYSQL_DATABASE=pharmacare_health_screening -d mysql:5.7
   ```

5. Import the database schema:
   ```
   docker exec -i pharmacare-mysql mysql -uroot -pyour_root_password pharmacare_health_screening < backend/database/create_database.sql
   ```

6. Start the PHP backend container:
   ```
   docker run --name pharmacare-backend --network pharmacare-network -v $(pwd)/backend:/var/www/html -p 8080:80 -d php:7.4-apache
   ```

7. Install necessary PHP extensions and enable mod_rewrite:
   ```
   docker exec pharmacare-backend docker-php-ext-install pdo pdo_mysql
   docker exec pharmacare-backend a2enmod rewrite
   docker exec pharmacare-backend service apache2 restart
   ```

8. Start the React frontend container:
   ```
   docker run --name pharmacare-frontend --network pharmacare-network -p 3000:80 -d pharmacare-health-screening
   ```

9. Access the application:
   - Frontend: Open a web browser and go to `http://localhost:3000`
   - Backend API: The API will be accessible at `http://localhost:8080/api.php`

## Stopping the Application

To stop the application and clean up the containers:

1. Stop and remove the containers:
   ```
   docker stop pharmacare-frontend pharmacare-backend pharmacare-mysql
   docker rm pharmacare-frontend pharmacare-backend pharmacare-mysql
   ```

2. Remove the network:
   ```
   docker network rm pharmacare-network
   ```

## Troubleshooting

- If you encounter any issues with container networking, ensure that Docker Desktop has the necessary permissions and that the Docker daemon is running.
- Check container logs for any error messages:
  ```
  docker logs pharmacare-frontend
  docker logs pharmacare-backend
  docker logs pharmacare-mysql
  ```

Remember to replace 'your_root_password' with a secure password of your choice.

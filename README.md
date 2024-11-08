# Pharmacare Health Screening Database System

This project implements a comprehensive health screening database system for Pharmacare, designed to provide valuable health insights, streamline screening processes, and improve patient care outcomes.

## Features

- Patient management (add, view, edit, delete)
- Health screening data management
- Custom report generation with various options
- Data visualization for health trends
- User authentication and role-based access control
- Caching mechanism for improved performance
- PDF report generation

## Project Structure

```
pharmacare_health_screening/
├── frontend/
│   └── src/
│       ├── components/
│       ├── pages/
│       ├── utils/
│       └── styles/
├── backend/
│   ├── api/
│   ├── database/
│   ├── models/
│   ├── services/
│   └── lib/
├── scripts/
├── docs/
├── tests/
│   ├── frontend/
│   └── backend/
├── config/
└── Dockerfile
```

## Setup and Installation

1. Clone the repository:
   ```
   git clone https://github.com/your-username/pharmacare-health-screening.git
   cd pharmacare-health-screening
   ```

2. Set up the backend:
   - Ensure PHP and MySQL are installed on your system
   - Import the database schema:
     ```
     mysql -u your_username -p < backend/database/create_database.sql
     mysql -u your_username -p pharmacare_health_screening < backend/database/schema_update.sql
     ```
   - Install FPDF library:
     ```
     php download_fpdf.php
     ```

3. Set up the frontend:
   ```
   cd frontend
   npm install
   ```

4. Configure the database connection:
   - Copy `config/database.example.php` to `config/database.php`
   - Update the database credentials in `config/database.php`

## Running the Application

### Frontend
```
cd frontend
npm start
```

### Backend
Ensure your PHP server is running and pointing to the `backend/api` directory.

## Deployment

### Docker Deployment
```
docker-compose up -d
```

### Cloud Deployment
```
bash scripts/cloud_deploy.sh
```

### On-Premises Deployment
```
bash scripts/on_premises_deploy.sh
```

## Testing

### Frontend Tests
```
cd frontend
npm test
```

### Backend Tests
```
cd backend/tests
php phpunit.phar
```

## Documentation

For more detailed information about the system's architecture, API endpoints, and usage instructions, please refer to the documentation in the `docs/` directory.

## Contributing

Please read CONTRIBUTING.md for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the LICENSE.md file for details.

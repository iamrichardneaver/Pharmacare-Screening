<?php
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../services/PatientService.php';
require_once __DIR__ . '/../services/HealthScreeningService.php';
require_once __DIR__ . '/../services/LocationService.php';
require_once __DIR__ . '/../services/ScreeningTypeService.php';
require_once __DIR__ . '/auth_middleware.php';

$config = require __DIR__ . '/../../config/database.php';

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$patientService = new PatientService($pdo);
$healthScreeningService = new HealthScreeningService($pdo);
$locationService = new LocationService($pdo);
$screeningTypeService = new ScreeningTypeService($pdo);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$resource = $uri[1] ?? null;
$resourceId = $uri[2] ?? null;

// Authenticate the request
$user = authenticate();

switch ($resource) {
    case 'patients':
        handlePatientRequests($method, $resourceId, $patientService, $user);
        break;
    case 'screenings':
        handleScreeningRequests($method, $resourceId, $healthScreeningService, $user);
        break;
    case 'reports':
        handleReportRequests($method, $healthScreeningService, $user);
        break;
    case 'locations':
        handleLocationRequests($method, $resourceId, $locationService, $user);
        break;
    case 'screening-types':
        handleScreeningTypeRequests($method, $resourceId, $screeningTypeService, $user);
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Resource not found"]);
        break;
}

function handleLocationRequests($method, $resourceId, $locationService, $user) {
    if ($user['role_name'] !== 'admin') {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        return;
    }

    switch ($method) {
        case 'GET':
            $locations = $locationService->getAllLocations();
            echo json_encode($locations);
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $newLocationId = $locationService->addLocation($data['name']);
            echo json_encode(["id" => $newLocationId, "message" => "Location added successfully"]);
            break;
        case 'DELETE':
            if (!$resourceId) {
                http_response_code(400);
                echo json_encode(["error" => "Location ID is required"]);
                break;
            }
            $success = $locationService->deleteLocation($resourceId);
            if ($success) {
                echo json_encode(["message" => "Location deleted successfully"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Location not found"]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
    }
}

function handleScreeningTypeRequests($method, $resourceId, $screeningTypeService, $user) {
    if ($user['role_name'] !== 'admin') {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        return;
    }

    switch ($method) {
        case 'GET':
            $screeningTypes = $screeningTypeService->getAllScreeningTypes();
            echo json_encode($screeningTypes);
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $newScreeningTypeId = $screeningTypeService->addScreeningType($data['name']);
            echo json_encode(["id" => $newScreeningTypeId, "message" => "Screening type added successfully"]);
            break;
        case 'DELETE':
            if (!$resourceId) {
                http_response_code(400);
                echo json_encode(["error" => "Screening type ID is required"]);
                break;
            }
            $success = $screeningTypeService->deleteScreeningType($resourceId);
            if ($success) {
                echo json_encode(["message" => "Screening type deleted successfully"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Screening type not found"]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
    }
}

// ... (keep other request handling functions)

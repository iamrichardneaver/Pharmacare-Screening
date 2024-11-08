<?php
function authenticate($requiredRole = null) {
    $headers = apache_request_headers();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

    if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $token = $matches[1];
    // In a real application, you would validate the token here
    // For this example, we'll just check if it's a non-empty string
    if (empty($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    // Fetch user data based on the token
    global $userService;
    $user = $userService->getUserByToken($token);

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    if ($requiredRole && $user['role_name'] !== $requiredRole) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
        exit;
    }

    return $user;
}

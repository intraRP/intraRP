<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

use App\Auth\Permissions;
use App\Helpers\Flash;
use App\Utils\AuditLogger;

if (!Permissions::check('full_admin')) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/users/roles/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $color = trim($_POST['color'] ?? '');
    $permissions = $_POST['permissions'] ?? [];

    if (empty($name) || empty($color)) {
        Flash::set('error', 'missing-fields');
        header("Location: /admin/users/roles/index.php");
        exit;
    }

    $permissions_json = json_encode($permissions);

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_users_roles (name, priority, color, permissions) VALUES (:name, :priority, :color, :permissions)");
        $stmt->execute([
            ':name' => $name,
            ':priority' => $priority,
            ':color' => $color,
            ':permissions' => $permissions_json
        ]);

        Flash::set('role', 'created');
        $auditLogger = new AuditLogger($pdo);
        $auditLogger->log($_SESSION['userid'], 'Rolle erstellt', 'Name: ' . $name, 'Rollen', 1);
        header("Location: /admin/users/roles/index.php");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Insert Error (roles): " . $e->getMessage());
        Flash::set('error', 'exception');
        header("Location: /admin/users/roles/index.php");
        exit;
    }
} else {
    header("Location: /admin/users/roles/index.php");
    exit;
}

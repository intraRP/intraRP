<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

use App\Auth\Permissions;
use App\Helpers\Flash;
use App\Utils\AuditLogger;

if (!Permissions::check('admin')) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/enotf/management/fahrzeuge/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $veh_type = trim($_POST['veh_type'] ?? '');
    $identifier = trim($_POST['identifier'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $doctor = isset($_POST['doctor']) ? 1 : 0;
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($name) || empty($veh_type) || empty($identifier)) {
        Flash::set('error', 'missing-fields');
        header("Location: /admin/enotf/management/fahrzeuge/index.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_edivi_fahrzeuge (name, veh_type, identifier, priority, doctor, active) VALUES (:name, :veh_type, :identifier, :priority, :doctor, :active)");
        $stmt->execute([
            ':name' => $name,
            ':veh_type' => $veh_type,
            ':identifier' => $identifier,
            ':priority' => $priority,
            ':doctor' => $doctor,
            ':active' => $active
        ]);

        Flash::set('vehicle', 'created');
        $auditLogger = new AuditLogger($pdo);
        $auditLogger->log($_SESSION['userid'], 'Fahrzeug erstellt ', 'Name: ' . $name . ' | Typ: ' . $veh_type, 'Fahrzeuge', 1);
        header("Location: /admin/enotf/management/fahrzeuge/index.php");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Insert Error: " . $e->getMessage());
        Flash::set('error', 'exception');
        header("Location: /admin/enotf/management/fahrzeuge/index.php");
        exit;
    }
} else {
    header("Location: /admin/enotf/management/fahrzeuge/index.php");
    exit;
}

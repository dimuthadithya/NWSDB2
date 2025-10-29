<?php
require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_computers'])) {

        $ComputerCategoryId = DbHelper::getCategoryId('Computer');

        // Basic Information
        $deviceName = $_POST['device_name'];
        $model = $_POST['model'];
        $madeIn = $_POST['made_in'];
        $categoryId = $ComputerCategoryId;

        // Assignment Information
        $sectionId = $_POST['section_id'];
        $assignedTo = $_POST['assigned_to'];

        // Hardware Specifications
        $operatingSystem = $_POST['operating_system'];
        $processor = $_POST['processor'];
        $ram = $_POST['ram'];
        $hardDriveCapacity = $_POST['hard_drive_capacity'];
        $keyboard = $_POST['keyboard'];
        $mouse = $_POST['mouse'];

        // Connectivity & Network
        $networkConnectivity = $_POST['network_connectivity'];
        $printerConnectivity = $_POST['printer_connectivity'];
        $ipAddress = $_POST['ip_address'];
        $virusGuard = $_POST['virus_guard'];

        // Additional Information
        $monitorInfo = $_POST['monitor_info'];
        $cpuSerial = $_POST['cpu_serial'];
        $purchaseDate = $_POST['purchase_date'];
        $status = $_POST['status'];

        // Notes
        $notes = $_POST['notes'];

        $deviceId = DbHelper::createDevice(
            $deviceName,
            $model,
            $madeIn,
            $categoryId,
            $sectionId,
            $assignedTo,
            $operatingSystem,
            $processor,
            $ram,
            $hardDriveCapacity,
            $keyboard,
            $mouse,
            $networkConnectivity,
            $printerConnectivity,
            $ipAddress,
            $virusGuard,
            $monitorInfo,
            $cpuSerial,
            $purchaseDate,
            $status,
            $notes
        );

        if ($deviceId) {
            header('Location: ../pages/computers.php?device_add=success');
            exit();
        } else {
            header('Location: ../pages/computers.php?device_add=failed');
            exit();
        }
    }
}

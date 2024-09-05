<?php
session_start();
include "../includes/db.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SESSION['user_type'] != 'admin') {
    $_SESSION['error_message'] = "Access denied. You must be an admin to view this page.";
    header("Location: ../pages/dashboard.php");
    exit();
}

if(isset($_POST['year'])) {
    $selectedYear = $_POST['year'];


    $sql = "SELECT * FROM facility WHERE YEAR(date_time) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $selectedYear);
    $stmt->execute();
    $result = $stmt->get_result();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getProperties()->setCreator("Your Name")
        ->setLastModifiedBy("Your Name")
        ->setTitle("Facility Report")
        ->setSubject("Facility Report")
        ->setDescription("Facility report for the year ".$selectedYear)
        ->setKeywords("facility report")
        ->setCategory("Report");

    $sheet->setCellValue('A1', 'Date & Time');
    $sheet->setCellValue('B1', 'Title');
    $sheet->setCellValue('C1', 'Address');
    $sheet->setCellValue('D1', 'Participants');

    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A'.$rowNumber, $row['date_time']);
        $sheet->setCellValue('B'.$rowNumber, $row['title']);
        $sheet->setCellValue('C'.$rowNumber, $row['address']);
        $sheet->setCellValue('D'.$rowNumber, $row['participants']);
        $rowNumber++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="facility_report_'.$selectedYear.'.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
} else {
    $_SESSION['error_message'] = "Year parameter is not provided.";
    header("Location: ../pages/matches.php");
    exit();
}
?>

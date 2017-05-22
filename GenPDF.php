<?php
session_start();
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
include 'header.php';


$mpdf = new mPDF('utf-8','A4-P');
$stylesheet = file_get_contents('css/FontStyle.css');
$elements =  $_POST['element'];


// Write some HTML code:
$mpdf->writeHTML($stylesheet,1);
$mpdf->WriteHTML($elements,2);

// Output a PDF file directly to the browser
$mpdf->Output();


?>
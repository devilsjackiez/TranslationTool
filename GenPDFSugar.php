<?php
session_start();
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
include 'header.php';

$TranslationID = $_GET['TransID'];

function ConnectLocalDBFind()
{
    /*$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "translationmanagement";*/
    $servername = "vmmysqlintha.coast.ebuero.de";
    $username = "sugarcrm_hr";
    $password = "gicaDee9";
    $dbname = "sugarcrm_hr";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //echo "successful";
    return $conn;
}
$conn = ConnectLocalDBFind();
$conn->set_charset("utf8");
$sql = "SELECT * FROM translation_t WHERE Request_Id='" . $TranslationID . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        /*$ContentElement = $row['ContentElement'];*/
        $Element = $row['ContentElement'];
        $Flang = $row['From_lang'];
        $TLang = $row['To_lang'];
    }
}




$mpdf = new mPDF('utf-8','A4-P');
$stylesheet = file_get_contents('css/FontStyle.css');
$elements =  $Element;


// Write some HTML code:
$mpdf->writeHTML($stylesheet,1);
$mpdf->WriteHTML($elements,2);

// Output a PDF file directly to the browser
$mpdf->Output('Translation_'.$Flang.'_To_'.$TLang.'.pdf','I');


?>
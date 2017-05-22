<?php
require_once __DIR__ . '/vendor/autoload.php';
include('../../config.php');
include('../../custom/include/language/en_us.lang.php');
include('function.php');
include('PHPMailer/PHPMailerAutoload.php');
include('header.php');

$URequestTransID = $_POST['RequestID'];

$conn = ConnectLocalDB();
$conn->set_charset("utf8");
$sql = "SELECT * FROM translation_t WHERE Request_Id='" . $URequestTransID . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        /*$ContentElement = $row['ContentElement'];*/
        $ModuleType = $row['Module_Type'];
        $FromLanguage = $row['From_lang'];
        $ToLanguage = $row['To_lang'];
        $DateDue = $row['Due_date'];
        $IssueID = $row['JiraID'];
        $ApprovalPATH = $row['ApprovePath'];
    }
}
$subject = "Translation Approval - Jira Issue ID : " . $IssueID;
$toAddress = "nazim.saad@clbs.co.th,Manuela.Trivella@clbs.co.th,mo@clbs.co.th,matthias.schenk@clbs.co.th,nicole.pulfer@clbs.co.th,j.patanasutakit@clbs.co.th,kritika.soni@clbs.co.th";
//$toAddress = "j.patanasutakit@clbs.co.th";
$updateContent = '<div><strong>Type : <a>' . $ModuleType . '</a></strong></div>
                      <div><strong>Language From : <a>' . $FromLanguage . '</a></strong></div>
                      <div><strong>Language To : <a>' . $ToLanguage . '</a></strong></div>
                      <div><strong>Due Date : <a>' . $DateDue . '</a></strong></div>
                      <div><strong>Jira Issue ID : <a>' . $IssueID . '</a></strong></div>
                      <div><strong>Approval URL : <a href='.$ApprovalPATH.'>Click To Open Approval Page</a></strong></div>';

$agentName = "Recruiting CLBS";
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'localhost';
$mail->SMTPAuth = false;
$mail->CharSet = "utf-8";
$mail->From = "recruiting@clbs.co.th";
$mail->FromName = $agentName;
$addrList = explode(',', $toAddress);
foreach ($addrList as $address) {
    $mail->addAddress($address);
}
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $updateContent;
$mail->AltBody = $updateContent;

notifySendingResult($mail);
$conn->close();

?>
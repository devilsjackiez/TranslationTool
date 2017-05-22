<?php
require_once 'function.php';

FormInsert();


function FormInsert()
{
    $Gen = GenerateRequestTranslationID();
    /*echo '<h1>Module Type : ' . $_GET['CVDoc'] .
        '</h1><br><h1>From Language : ' . $_GET['Fromlang'] .
        '</h1><br><h1>To Language : ' . $_GET['Tolang'] .
        '</h1><br><h1>Request Date : ' . $_GET['RequestDate'] .
        '</h1><br><h1>Due Date : ' . $_GET['DueDate'] .
        '</h1><br><h1>Applicant ID : ' . $_GET['applicant_id'] .
        '</h1><br><h1>Request ID : ' . $Gen . '</h1>';*/
    $setRequestURL = "index.php?CVDoc=" . $_GET['CVDoc'] . "&Fromlang=" . $_GET['Fromlang'] . "&Tolang=" . $_GET['Tolang'] . "&RequestDate=" .
    $_GET['RequestDate'] . "&DueDate=" . $_GET['DueDate'] . "&id=" . $_GET['applicant_id'] . "&RequestTranslationID=" . $Gen . "&CVID=" .$_GET['CVID'];
    $setRequestURL2 = "approve.php?CVDoc=" . $_GET['CVDoc'] . "&Fromlang=" . $_GET['Fromlang'] . "&Tolang=" . $_GET['Tolang'] . "&RequestDate=" .
        $_GET['RequestDate'] . "&DueDate=" . $_GET['DueDate'] . "&id=" . $_GET['applicant_id'] . "&RequestTranslationID=" . $Gen. "&CVID=" .$_GET['CVID'];

    $KeepUrl = "http://hrm.clbs.co.th/addonplugin/requesttranslation/" . $setRequestURL;
    $KeepApprove = "http://hrm.clbs.co.th/addonplugin/requesttranslation/" .$setRequestURL2;
    insertRequestTranslation($Gen,$_GET['CVDoc'], $_GET['Fromlang'], $_GET['Tolang'], $_GET['RequestDate'], $_GET['DueDate'], $_GET['applicant_id'], $KeepUrl,$KeepApprove,$_GET['CVID']);
    CreateJiraTicket($_GET['CVDoc'], $_GET['Fromlang'], $_GET['Tolang'], $_GET['DueDate'],$KeepUrl,$Gen);
    SendRequestEmailToShift($Gen);
    AddWatcher($Gen);
}


?>


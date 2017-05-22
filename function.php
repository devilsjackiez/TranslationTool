<?php
require_once __DIR__ . '/vendor/autoload.php';
include('../../config.php');
include('../../custom/include/language/en_us.lang.php');
include('PHPMailer/PHPMailerAutoload.php');
/*$elementText = $_POST['element'];*/
/*GenerateRequestTranslationID();*/
/*UpdateContentDataTranlation();*/
/*$DataContent = $_POST['dataContent'];
echo $DataContent;*/
//SelectContentData();
//ConnectLocalDB();
//ConnectLocalDB();
//CreateJiraTicket();
//UpdateJiraTicketSaveButton();
//UpdateJiraTicketSaveAndSubmitButton();
//SendRequestEmailToShift();

function ConnectDB()
{

    global $sugar_config;
    mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']) or die(mysql_error());
    mysql_select_db($sugar_config['dbconfig']['db_name']) or die(mysql_error());
}

function ConnectLocalDB()
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

function GetCVbyUserID($idCV)
{

    ConnectDB();
    $resultUser = mysql_query("SELECT * FROM leads_dcup_cvdocument_1_c ld where ld.leads_dcup_cvdocument_1leads_ida='" . $idCV . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($resultUser)) {
        /*$IdA = $row['leads_dcup_cvdocument_1leads_ida'];*/
        $Idb = $row['leads_dcup_cvdocument_1dcup_cvdocument_idb'];
    }
    $result = mysql_query("SELECT cv.id,cv.name,cv.date_entered,cv.cvpath FROM dcup_cvdocument cv where id='" . $Idb . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($result)) {
        /*$cvID = $row['id'];
        $cvName = $row['name'];
        $cvDateEn = $row['date_entered'];*/
        $cvPath = $row['cvpath'];
    }
    $url = utf8_encode($cvPath);
    return $url;
}

function GetEdubyUserID($idCV)
{

    ConnectDB();
    $resultUser = mysql_query("SELECT * FROM sugarcrm_hr.leads_dcup_educert_1_c where leads_dcup_educert_1leads_ida='" . $idCV . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($resultUser)) {
        /*$IdA = $row['leads_dcup_cvdocument_1leads_ida'];*/
        $Idb = $row['leads_dcup_educert_1dcup_educert_idb'];
    }
    $result = mysql_query("SELECT * FROM sugarcrm_hr.dcup_educert where id='" . $Idb . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($result)) {
        /*$cvID = $row['id'];
        $cvName = $row['name'];
        $cvDateEn = $row['date_entered'];*/
        $cvPath = $row['edupath'];
    }
    $url = utf8_encode($cvPath);
    return $url;
}

function GetReferbyUserID($idCV)
{

    ConnectDB();
    $resultUser = mysql_query("SELECT * FROM sugarcrm_hr.leads_dcup_refdocument_1_c where leads_dcup_refdocument_1leads_ida='" . $idCV . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($resultUser)) {
        /*$IdA = $row['leads_dcup_cvdocument_1leads_ida'];*/
        $Idb = $row['leads_dcup_refdocument_1dcup_refdocument_idb'];
    }
    $result = mysql_query("SELECT re.id,re.name,re.date_entered,re.refpath FROM sugarcrm_hr.dcup_refdocument re where id='" . $Idb . "'")
    or die ("Oops! cannot query");
    while ($row = mysql_fetch_assoc($result)) {
        /*$cvID = $row['id'];
        $cvName = $row['name'];
        $cvDateEn = $row['date_entered'];*/
        $cvPath = $row['refpath'];
    }
    $url = utf8_encode($cvPath);
    return $url;
}

function insertRequestTranslation($Gen, $moduleType, $FromLang, $ToLang, $Requestdate, $Duedate, $applicantID, $UrlPath, $ApprovePath, $parentID)
{
    $conn = ConnectLocalDB();
    $stmt = $conn->prepare("INSERT INTO translation_t (Request_Id, Module_Type, From_lang, To_lang,Request_date, Due_date, Applicant_Id,ContentElement,URLPath,ApprovePath,parentId,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")
    or die ("Show error : " . mysqli_error($conn));
//    $Tran = '<p>Translate Here</p>';
    $Tran = '<p><span style="font-family: opensans, sans-serif;"></span></p>';
    $status = 'In Progress';
    $stmt->bind_param('ssssssssssss', $Gen, $moduleType, $FromLang, $ToLang, $Requestdate, $Duedate, $applicantID, $Tran, $UrlPath, $ApprovePath, $parentID, $status);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function SendRequestEmailToShift($idRequest)
{

    $conn = ConnectLocalDB();
    $conn->set_charset("utf8");
//    $sql = "SELECT * FROM translation_t WHERE Request_Id='" . $idRequest . "'";
    $sql = "SELECT * FROM translation_t WHERE Request_Id='$idRequest'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            /*$ContentElement = $row['ContentElement'];*/
            $ModuleType = $row['Module_Type'];
            $FromLanguage = $row['From_lang'];
            $ToLanguage = $row['To_lang'];
            $DateDue = $row['Due_date'];
            $IssueID = $row['JiraID'];
            $URLPATH = $row['URLPath'];
        }
    }
    $subject = "Translation Requested - Jira Issue ID : ".$IssueID;
//    $toAddress = "j.patanasutakit@clbs.co.th";
    $toAddress = "nazim.saad@clbs.co.th,Manuela.Trivella@clbs.co.th,mo@clbs.co.th,matthias.schenk@clbs.co.th,nicole.pulfer@clbs.co.th,j.patanasutakit@clbs.co.th,kritika.soni@clbs.co.th";
    /*$toAddress = "matthias.schenk@clbs.co.th,sandra.palfy@dbs-gmbh.de";*/
//    $updateContent = '<div><strong>Translation Link : <a>' . $URLPATH . '</a></strong></div>';
    $updateContent = '<div><strong>Type : <a>' . $ModuleType . '</a></strong></div>
                      <div><strong>Language From : <a>' . $FromLanguage . '</a></strong></div>
                      <div><strong>Language To : <a>' . $ToLanguage . '</a></strong></div>
                      <div><strong>Due Date : <a>' . $DateDue . '</a></strong></div>
                      <div><strong>Jira Issue ID : <a>' . $IssueID . '</a></strong></div>
                      <div><strong>Transaltion URL : <a href='.$URLPATH.'>Click To Open Translation Page</a></strong></div>';

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
}

function notifySendingResult($mail)
{
    if (!$mail->send()) {
        echo "<h2>Mailer Error:" . $mail->ErrorInfo . "</h2>";
    } else {
        echo '<h2>Email has been sent.</h2>';
    }

}

function SelectContentData($RequestTransID)
{
    $conn = ConnectLocalDB();
    $conn->set_charset("utf8");
    $sql = "SELECT * FROM translation_t WHERE Request_Id='" . $RequestTransID . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ContentElement = $row['ContentElement'];
        }
        if ($ContentElement==""){
            /*$conn = ConnectLocalDB();
            $conn->set_charset("utf8");
            $stmt = $conn->prepare("UPDATE translation_t SET ContentElement=? WHERE Request_Id=?");
            $ht = "<p><span style=\"font-family: opensans, sans-serif;\"></span></p>";
            $stmt->bind_param('ss', $ht, $RequestTransID);
            $stmt->execute();
            $stmt->close();
            SelectContentData($RequestTransID);*/
            return "<P></P>";
        }else{
            return $ContentElement;
        }
        /*return $ContentElement;*/
        /*return $ContentElement;*/
    } else {
        echo "";
        return "<P></P>";
    }

    $conn->close();
}

function UpdateContentDataTranlation($ContentElement, $UserId)
{
    $conn = ConnectLocalDB();
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("UPDATE translation_t SET ContentElement=? WHERE Request_Id=?");
    $stmt->bind_param('ss', htmlspecialchars_decode($ContentElement), $UserId);
    $stmt->execute();
    $stmt->close();
}

function UpdateStatusResolved($UserId)
{
    $conn = ConnectLocalDB();
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("UPDATE translation_t SET status=? WHERE Request_Id=?");
    $status = 'Resolved';
    $stmt->bind_param('ss', $status, $UserId);
    $stmt->execute();
    $stmt->close();
}

function GenerateRequestTranslationID()
{

//-----------------------Define------------------------------------------------
    $url = "http://hrm.clbs.co.th/service/v4_1/rest.php";

    $username = "admin";
    $password = "Cidkebi3";

//function to make cURL request
//login -----------------------------------------------------
    $login_parameters = array(
        "user_auth" => array(
            "user_name" => $username,
            "password" => md5($password),
            "version" => "1"
        ),
        "application_name" => "Request Translation",
        "name_value_list" => array(),
    );

    ob_start();
    $curl_request0 = curl_init();

    curl_setopt($curl_request0, CURLOPT_URL, $url);
    curl_setopt($curl_request0, CURLOPT_POST, 1);
    curl_setopt($curl_request0, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($curl_request0, CURLOPT_HEADER, 1);
    curl_setopt($curl_request0, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl_request0, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_request0, CURLOPT_FOLLOWLOCATION, 0);

    $jsonEncodedData0 = json_encode($login_parameters);

    $post0 = array(
        "method" => "login",
        "input_type" => "JSON",
        "response_type" => "JSON",
        "rest_data" => $jsonEncodedData0
    );

    curl_setopt($curl_request0, CURLOPT_POSTFIELDS, $post0);
    $result0 = curl_exec($curl_request0);
    curl_close($curl_request0);

    $result0 = explode("\r\n\r\n", $result0, 2);
    $response0 = json_decode($result0[1]);
    ob_end_flush();

    $session_id = ($response0->id);
    $_SESSION["RequestTranslate"] = $session_id;
    return $session_id;
}

function CreateJiraTicket($DocType, $Flang, $Tlang, $Ddate, $KeepUrl, $Gen)
{
    $data = array(
        'fields' => array(
            'project' => array('key' => 'MISC',),
            'issuetype' => array('name' => 'Task'),
            'summary' => 'Translation Request',
            'description' => 'Type : ' . $DocType . '\\\\
             Language From : ' . $Flang . '\\\\
             Language To : ' . $Tlang . '\\\\
             Due Date : ' . $Ddate . '\\\\
             Translation URL : ' . $KeepUrl . '',
            /*'issuetype' => array('name' => 'Translation'),*/
            'assignee' => array('name' => ''),
            /*'customfield_11508' => "Jackrin", //Text Field
            'customfield_11509' => "Patanasutakit", //Text Field*/
            /*            'customfield_13100' => array('id' => "CLBS"), //Select List*/
            /*'watches' => array('name'=>'j.patanasutakit'),*/
        ),
    );

    $username = "jira.help";
    $password = "lx@2xf!fKTM4";
//    $username = "j.patanasutakit";
//    $password = "baynalove";
    $url = "http://jira.coast.ebuero.de/rest/api/2/issue/";
    $ch = curl_init();

    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json'
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    $result = curl_exec($ch);
    $ch_error = curl_error($ch);


    if ($ch_error) {
        echo "cURL Error: $ch_error";
        $GLOBALS['log']->fatal($ch_error);
    } else {
        /*echo $result;*/
        $obj = json_decode($result);
        echo $obj->{'key'};
        echo $obj->{'id'};

        $requestedby = "";

        echo $Gen;
        $conn = ConnectLocalDB();
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("UPDATE translation_t SET JiraID=? WHERE Request_Id='$Gen'");
        $stmt->bind_param('s', $obj->{'key'});
        $stmt->execute();
        $stmt->close();

    }
}

function AddWatcher($RequestID)
{

    $conn = ConnectLocalDB();
    $conn->set_charset("utf8");
    $sql = "SELECT * FROM translation_t WHERE Request_Id='" . $RequestID . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $JIRAID = $row['JiraID'];
        }

        $data = array(
            /*'nazim.saad',
            'manuela.trivella',
            'c.khuantakhop',
            'matthias.schenk',
            'ganis.dulyapach'*/
            'matthias.schenk'
        );
        $username = 'j.patanasutakit';
        $password = 'baynalove';
        $url = "http://jira.coast.ebuero.de/rest/api/2/issue/".$JIRAID."/watchers";
//        $url = "http://jira.coast.ebuero.de/rest/api/2/issue/MISC-1095/watchers";
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json'
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        foreach ($data as $key => $user) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($user));
            $result = curl_exec($ch);
        }

        curl_close($ch);
    }
}


?>



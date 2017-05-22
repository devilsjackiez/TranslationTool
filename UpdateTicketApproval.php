<?php
include ('function.php');
$URequestTransID = $_POST['RequestID'];

$conn = ConnectLocalDB();
$conn->set_charset("utf8");
$sql = "SELECT * FROM translation_t WHERE Request_Id='" . $URequestTransID . "'";
//$sql = "SELECT * FROM translation_t WHERE Request_Id='h7b8orlmi9ooqmukasfpqbblu4'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $Typedoc = $row['Module_Type'];
        $UFLang = $row['From_lang'];
        $UTLang = $row['To_lang'];
        $UDuedate = $row['Due_date'];
        $ApproveURL = $row['ApprovePath'];
        $UJiraticket = $row['JiraID'];
    }
} else {
    echo null;
}
$conn->close();

//    $username = "jira.help";
//    $password = "lx@2xf!fKTM4";
$username = "j.patanasutakit";
$password = "baynalove";
$url = "http://jira.coast.ebuero.de/rest/api/2/issue/".$UJiraticket;
$ch = curl_init();

$headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
);

$data = array(
    'fields' => array(
        'project' => array('key' => 'MISC',),
        'summary' => 'Translation Request',
        'description' => 'Type : ' . $Typedoc . '\\\\
             Language From : ' . $UFLang . '\\\\
             Language To : ' . $UTLang . '\\\\
             Due Date : ' . $UDuedate . '\\\\
             Approval URL : ' . $ApproveURL . '',
        /*'customfield_11508' => "Jackrin", //Text Field
        'customfield_11509' => "Patanasutakit", //Text Field*/
        /*            'customfield_13100' => array('id' => "CLBS"), //Select List*/
        /*'watches' => array('name'=>'j.patanasutakit'),*/
    ),
);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
$result = curl_exec($ch);
$ch_error = curl_error($ch);

if ($ch_error) {
    echo "cURL Error: $ch_error";
    $GLOBALS['log']->fatal($ch_error);
} else {
    echo $result;

    $requestedby = "";

}


?>
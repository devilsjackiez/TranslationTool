<?php
/*@ini_set('display_errors', '0');*/
include 'vendor/autoload.php';
require_once "function.php";
include('../../config.php');
include('../../custom/include/language/en_us.lang.php');
include 'header.php';
$idLead = $_GET["id"];
$TransId = $_GET['RequestTranslationID'];
/*echo "<script type='text/javascript'>alert($cvPath);</script>";*/


?>
<script>
    tinymce.init({
        selector: '#mytextarea',
        schema: 'html',
        element_format: 'html',
        /*encoding: 'xml',*/
        /*protect: '',*/
        theme: 'modern',
        /*table_clone_elements: "p",*/
        plugins: [
            'advlist autolink lists image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime nonbreaking save table contextmenu directionality',
            'template paste textcolor colorpicker textpattern imagetools toc'
        ],
        forced_root_block: 'a',
        invalid_elements: 'a',
        toolbar1: 'undo redo | fontselect | insert | bold italic underline strikethrough | bullist numlist outdent indent alignleft aligncenter alignright alignjustify | ltr rtl | ',
        toolbar2: 'image | preview removeformat | forecolor backcolor | fontsizeselect | table',
        font_formats: 'Open Sans=opensans,sans-serif; Kochi-Mincho=kochimincho; AkrutiKndPadmini=Akpdmi-n',
        fontsize_formats: '6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 36pt 40pt 64pt 72pt',
        /*image_advtab: true,*/
        doctype: "<!DOCTYPE html>",
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        /*        content_css: [
         /!*'http://fonts.googleapis.com/css?family=Lato:300,300i,400,400i',*!/
         /!*'//www.tinymce.com/css/codepen.min.css',*!/
         /!*'FontStyle.css'*!/
         ],*/
        entity_encoding: "raw",
        width: 660,
        height: 610
    });

</script>

<body>
<div style="margin-bottom: 10px;">
    <h1 align="center" style="padding-bottom: 10px;">Translator Management Tools</h1>
    <h3 align="center" style="line-height: 10px;">Translation is due to :&nbsp;<?php echo $_GET['DueDate']; ?></h3>

</div>
<div class="col-md-12" align="center">
    <div class="form-inline" style="width: 700px;margin-left: 10px;">
        <div class="form-group">
            <h3 for="langSelect" style="font-size: 1.5em;">From : &nbsp;<?php echo $_GET['Fromlang']; ?>&nbsp;</h3>
            <!--<input type="text" class="form-control" name="langSelect" value="<?php /*echo $_GET['Fromlang']; */ ?>"
                   style="width: 100px;text-align: center;" readonly required>-->
        </div>
        <div class="form-group">
            <h3 for="langSelect2" style="font-size: 1.5em;">&nbsp;To :&nbsp;<?php echo $_GET['Tolang']; ?></h3>
            <!--<input type="text" class="form-control" name="langSelect2" value="<?php /*echo $_GET['Tolang']; */ ?>"
                   style="width: 100px;text-align: center;" readonly required>-->
        </div>
    </div>
    <br><br>
</div>
<div class="col-md-6">
    <div>
        <div align="center">
            <iframe class="embed-responsive-item"
                    src='http://docs.google.com/gview?url=<?php
                    $conn = ConnectLocalDB();
                    $conn->set_charset("utf8");
                    $sql = "SELECT * FROM translation_t WHERE Request_Id='" . $TransId . "'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $Module = $row['Module_Type'];
                        }
                        /*return $ContentElement;*/
                    } else {
                        echo null;
                    }
                    $conn->close();

                    if($_GET['CVDoc'] =='CV'){
                        echo GetCVbyUserID($idLead);
                    }else if($_GET['CVDoc'] =='Education Certificate'){
                        echo GetEdubyUserID($idLead);
                    }else if($_GET['CVDoc'] =='Reference'){
                        echo GetReferbyUserID($idLead);
                    }
                     ?>&embedded=true'
                    width='680' height='750' frameborder='0'></iframe>
            <?php /*echo GetCVbyUserID($idLead); */ ?>
        </div>
    </div>
</div>
<?php
//$text = SelectContentData($TransId);

/**/

$text = SelectContentData($TransId);
$pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';

// preg_match_all returns an associative array
preg_match_all($pattern, $text, $matches);

// the data you want is in $matches[0], dump it with var_export() to see it

for ($i = 0; $i <= count($matches[0]); $i++) {
    /*echo $matches[0][$i];*/
    $text2 = str_replace("$matches[0][$i]", "<!--email_off-->" . $matches[0][$i] . "<!--/email_off-->", htmlspecialchars($text));

}
/*echo "<br>".htmlspecialchars($text2);*/
?>
<div class="col-md-6" align="center">
    <div>
        <div class="form-group">
            <form method="post" id="myform" action="GenPDF.php" target="result">
                <textarea class="form-control" rows="10" id="mytextarea" name="element"><?php echo $text2 ?></textarea>
                <button type="submit" class="btn btn-default" name="Submit" id="btnradious0"
                        style="margin-top: 10px;">Save
                </button>
                <button type="button" class="btn btn-default" name="SubmitAndSave" id="btnradious1"
                        style="margin-top: 10px;border-radius: 0px;box-shadow: 2px 5px 10px black;"
                >Save & Submit
                </button>
            </form>
        </div>
    </div>
</div>
<input class="hidden" type="text" value="<?php echo $_GET['RequestTranslationID']; ?>" id="Userid"/>
<script type="text/javascript">
    $(document).ready(function () {
        UserId = $("#Userid").val();
        /*alert(UserId);*/
        $("#btnradious0").click(function () {

            var txt;
            var r = confirm("Click OK for save progress and view sample file or Click cancle for only view.");
            if (r == true) {
                console.log(tinyMCE.activeEditor.getContent());
                $.ajax({
                    type: 'post',
                    url: 'UpdateProgress.php',
                    data: $.param({
                        dataContent: tinyMCE.activeEditor.getContent(),
                        UserId: UserId
                    }),
                    success: function (html) {
                        /*alert(html);*/
                        alert("Save Successful")
                    }
                });

            } else {
                txt = "You pressed Cancel!";
            }
            /*element = console.log(tinyMCE.activeEditor.getContent({format: 'raw'}));*/
            /*location.replace("http://http://localhost:8080/TranslatorManagement/function.php");*/
        });
    });
    document.getElementById('btnradious0').addEventListener('click', function () {
        window.open('GenPDF.php', 'result', 'width=600,height=900');
        document.getElementById('myform').submit();
    });
</script>
<script>
    $(document).ready(function () {
        RequestID = $("#Userid").val();
        $("#btnradious1").click(function () {
            var txt;
            var r = confirm("Click OK for Update URL on Jira Ticket to approval and view sample file " +
                "\nor Click cancle for only view.");
            if (r == true) {
                console.log(tinyMCE.activeEditor.getContent());
                $.ajax({
                    type: 'post',
                    url: 'UpdateProgress.php',
                    data: $.param({
                        dataContent: tinyMCE.activeEditor.getContent(),
                        UserId: UserId
                    }),
                    success: function (html) {
                        /*alert(html);*/
                        alert("Submit Successful")
                    }
                });
                $.ajax({
                    type: 'post',
                    url: 'UpdateTicketApproval.php',
                    data: $.param({
                        RequestID :RequestID
                    }),
                    success: function (data) {
                        /*alert(data);*/
//                        txt = "You pressed Cancel!";
//                        window.open('GenPDF.php', 'result');
//                        document.getElementById('myform').submit();
                    }
                });
                $.ajax({
                    type: 'post',
                    url: 'SendEmailForApproval.php',
                    data: $.param({
                        RequestID :RequestID
                    }),
                    success: function (data) {
                        /*alert(data);*/
//                        txt = "You pressed Cancel!";
//                        window.open('GenPDF.php', 'result');
//                        document.getElementById('myform').submit();
                        document.getElementById('btnradious1').addEventListener('click', function () {
                            window.open('GenPDF.php', 'result', 'width=600,height=900');
                            document.getElementById('myform').submit();
                        });
                    }
                });

            }else {
//                txt = "You pressed Cancel!";
//                window.open('GenPDF.php', 'result');
//                document.getElementById('myform').submit();
            }

        });
        document.getElementById('btnradious1').addEventListener('click', function () {
            window.open('GenPDF.php', 'result', 'width=600,height=900');
            document.getElementById('myform').submit();
        });
    });
</script>
</body>

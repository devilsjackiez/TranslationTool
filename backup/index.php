<?php

include 'vendor/autoload.php';
require_once "function.php";
include('../../config.php');
include('../../custom/include/language/en_us.lang.php');
include 'header.php';


$idLead = $_GET["id"];

/*echo "<script type='text/javascript'>alert($cvPath);</script>";*/


?>

<script>
    tinymce.init({
        selector: '#mytextarea',
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample | fontsizeselect',
        fontsize_formats: '6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 36pt 40pt',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ],
        entity_encoding: "raw",
        width: 700,
        height: 560
    });
</script>
<body>
<div class="container-fluid">
    <!--<div class="navbar navbar-inverse"></div>-->
    <h1 align="center" style="padding-bottom: 20px;">Translator Management System</h1>
    <div class="col-md-5 col-md-offset-1">
        <div>
            <div class="form-group" style="width: 200px;">
                <label for="langSelect" style="font-size: 1.5em;">Select list :</label>
                <!--<select class="form-control" id="langSelect">
                    <option>English</option>
                    <option>Italian</option>
                    <option>Spanish</option>
                    <option>Thai</option>
                </select>-->
                <input type="text" class="form-control" name="FromLanguage" value="<?php echo $_GET['Fromlang']; ?>"
                       readonly required>
            </div>
        </div>
        <div>
            <iframe class="responsive"
                    src='http://docs.google.com/gview?url=<?php echo GetCVbyUserID($idLead); ?>&embedded=true'
                    width='700' height='700' frameborder='0'></iframe>
            <?php echo GetCVbyUserID($idLead); ?>
        </div>
    </div>
    <div class="col-md-5" style="padding-left: 70px;">
        <div>
            <div class="form-group" style="width: 200px;">
                <label for="langSelect" style="font-size: 1.5em;">Select list :</label>
                <!--<select class="form-control" id="langSelect">
                    <option value="en">English</option>
                    <option value="it">Italian</option>
                    <option value="sp">Spanish</option>
                    <option value="th">Thai</option>
                </select>-->
                <input type="text" class="form-control" name="ToLanguage" value="<?php echo $_GET['Tolang']; ?>"
                       readonly required>
            </div>
        </div>
        <div>
            <!--            --><?php
            /*            $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile('What.pdf');
                        $text = $pdf->getText();
                        */ ?>
            <div class="form-group">
                <form method="post" id="myform" action="GenPDF.php" target="result">
                <textarea class="form-control" rows="10" id="mytextarea"
                          name="element"><?php /*echo $text; */ ?></textarea>
                    <button type="submit" class="btn btn-default" name="Submit" id="btnradious0"
                            style="margin-top: 10px;">Save
                    </button>
                    <button type="submit" class="btn btn-default" name="Submit" id="btnradious0"
                            style="margin-top: 10px;">Save & Submit
                    </button>
                </form>
            </div>
            <?php

            if (isset($_POST['Submit'])) {
                $_SESSION['element'] = $_POST['element'];
            }
            ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    $("#btnradious0").click(function () {
                        element = console.log(tinyMCE.activeEditor.getContent({format: 'raw'}));

                        /*location.replace("http://http://localhost:8080/TranslatorManagement/function.php");*/

                    });
                });
                document.getElementById('btnradious0').addEventListener('click', function () {
                    window.open('GenPDF.php', 'result', 'width=600,height=900');
                    document.getElementById('myform').submit();
                });
            </script>
        </div>
    </div>
</div>
</body>
</html>
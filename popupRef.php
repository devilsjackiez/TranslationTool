<?php
include 'header.php';
?>
<body>
<div class="container">
    <div class="panel panel-default" style="background-image: url('img/backGray.jpg');color: white;margin-top: 25px;">
        <div class="panel-heading" style="background-color: black;color: white;"><h1>Request Translation</h1></div>
        <div class="panel-body">
            <form class="form-horizontal" action="update.php" method="get">
                <div class="form-group">
                    <label class="control-label col-md-3" style="color: white;">Document Type:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="CVDoc" value="Reference" readonly required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" style="color: white;">From Language:</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="langSelect" name="Fromlang" required>
                            <option value="">Select Language</option>
                            <option value="English">English</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Italian">Italian</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Thai">Thai</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" style="color: white;">To language:</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="langSelect" name="Tolang" required>
                            <option value="">Select Language</option>
                            <option value="English">English</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Italian">Italian</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Thai">Thai</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" style="color: white;">Due Date:</label>
                    <div class="col-sm-4">
                        <input type="date" dataformatas="dd/mm/yyyy" class="form-control" name="DueDate" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="form-group hidden">
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="RequestDate" value="<?php echo date('Y-m-d'); ?>"
                               required> //Hidden Field of ApplicantID
                    </div>
                </div>
                <div class="form-group hidden">
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" name="applicant_id" value="<?php echo $_GET['id']; ?>"
                               required> //Hidden Field of ApplicantID
                        <input type="hidden" class="form-control" name="CVID" value="<?php echo $_GET['CVID']; ?>"
                               required> //Hidden Field of ApplicantID
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" id="btnradious0">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

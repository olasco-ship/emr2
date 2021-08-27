<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$patient = medicalReports::find_by_id($_GET['id']);


require('../layout/header.php');
?>



    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> GP Consultation </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body">

                            <a href="../consultant/index.php" style="font-size: large">&laquo; Back</a>
                            <ul style="font-size: large;">

                                <li><a href="printtravelReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For Travelling </a></li>
                                <li><a href="printPilgrimageReports.php?id=<?php echo  $patient->id ?>">Medical Certificate Of Fitness For Pilgrimage </a></li>
                                <li><a href="PrintfurtherReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For Further Studies </a></li>
                                <li><a href="PrintnyscReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For NYSC Programme </a></li>
                                <li><a href="printlicenceReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For Drivers licence </a></li>
                                <li><a href="printemployReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For Employment </a></li>
                                <li><a href="printmedReports.php?id=<?php echo $patient->id ?>">Medical Certificate Of Fitness For Admission </a></li>

                            </ul>

                        </div>






                    </div>
                </div>
            </div>




        </div>
    </div>




<?php
require('../layout/footer.php');


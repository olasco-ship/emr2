<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/1/2019
 * Time: 9:25 AM
 */
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}


$user = User::find_by_id($session->user_id);

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/auth/signin.php");
}

$bill = Bill::find_by_id($_GET['id']);

$confirmation = Bill::find_by_waiting_consultation($bill->bill_number);

if (empty($confirmation)){
    redirect_to("visit.php");
}



$patient = Patient::find_by_id($bill->patient_id);
$patient_clinics = PatientSubClinic::count_patient_clinics($patient->id);



if (is_post()) {


    if (isset($_POST['waiting'])) {

        $subClinic = SubClinic::find_by_id($_POST['sub_clinic_id']);

        $patient_id         = test_input($_POST['patient_id']);
        $waiting_list       = test_input($_POST['waiting']);

        $patient            = Patient::find_by_id($patient_id);

        $wait_list                = new WaitingList();
        $wait_list->sync          = "off";
        $wait_list->patient_id    = $patient->id;
        $wait_list->clinic_id     = $subClinic->clinic_id;
        $wait_list->sub_clinic_id = $_POST['sub_clinic_id'];
        $wait_list->room_id       = 0;
        $wait_list->officer       = $user->full_name();
        $wait_list->vitals        = '';
        $wait_list->status        = 'nurse';
        $wait_list->date          = strftime("%Y-%m-%d %H:%M:%S", time());
        $wait_list->save();

        $bill->status = "CLEARED";
        $bill->save();
        $session->message("Patient has been added to clinic's waiting list.");
        redirect_to('visit.php');
    }



}


require('../layout/header.php');
?>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Re-visit </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Patient</li>
                        <li class="breadcrumb-item active"> Re-visit</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-12">

                <div class="card">
                    <div class="header">
                        <a href="home.php" style="font-size: large">&laquo; Back</a>
                        <h2> Re-visit </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">


                            <div class="col-sm-12">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Hospital Number</th>
                                                            <td><?php echo $patient->folder_number ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th> Number Of Clinics</th>
                                                            <td><?php echo $patient_clinics ?></td>
                                                        </tr>
                                                        <tr >
                                                            <th> Clinic(s)</th>
                                                            <td><?php
                                                                $clinics = PatientSubClinic::find_patient_clinics($patient->id);
                                                                foreach ($clinics as $clinic) {
                                                                    $sub_clinic = SubClinic::find_by_id($clinic->sub_clinic_id);
                                                                    echo $sub_clinic->name . "<br/>";
                                                                }

                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <?php if (isset($patient->nhis_no) and (!empty($patient->nhis_no))) { ?>
                                                                <th>NHIS Number</th>
                                                                <td><?php echo $patient->nhis_no ?></td>
                                                            <?php  }  ?>
                                                        </tr>
                                                        <tr>
                                                            <?php if (isset($patient->nhis_no) and (!empty($patient->nhis_no))) { ?>
                                                                <th>NHIS Eligibility</th>
                                                                <td><?php echo $patient->nhis_eligibility ?></td>
                                                            <?php  }  ?>
                                                        </tr>
                                                        <tr>
                                                            <th>Title </th>
                                                            <td><?php echo $patient->title ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>First Name</th>
                                                            <td><?php echo $patient->first_name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Last Name</th>
                                                            <td><?php echo $patient->last_name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Birth Date</th>
                                                            <td><?php echo date('d/m/Y', strtotime($patient->dob))  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Age</th>
                                                            <td><?php echo getAge($patient->dob) . 'year(s)' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Gender</th>
                                                            <td><?php echo $patient->gender  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Blood Group</th>
                                                            <td><?php echo $patient->blood_group  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th> Genotype </th>
                                                            <td><?php echo $patient->genotype  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th> Phone Number </th>
                                                            <td><?php echo $patient->phone_number  ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th> Contact Address </th>
                                                            <td><?php echo $patient->address  ?></td>
                                                        </tr>

                                                    </table>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <form action="" method="post">


                                                    <div class="form-group">
                                                        <label>Hospital Sub Clinic</label>
                                                        <select class="form-control" id="sub_clinic_id" name="sub_clinic_id" required>
                                                            <option value="">--Select Sub-Clinic--</option>
                                                            <?php $patientCL = PatientSubClinic::find_patient_clinics($patient->id);

                                                            foreach ($patientCL as $patientC) {
                                                                $find = SubClinic::find_by_id($patientC->sub_clinic_id);
                                                            ?>
                                                                <option value="<?php echo $find->id; ?>"><?php echo $find->name; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="text" class="form-control" name="patient_id" value="<?php echo $patient->id ?>" hidden>
                                                    </div>


                                                    <!--
                                                    <div class="form-group">
                                                        <label>Hospital Clinic</label>
                                                        <select class="form-control" id="clinic_id" name="clinic_id" required>
                                                            <option value="">--Select Clinic--</option>
                                                            <?php
                                                            $finds = Clinic::find_all();
                                                            foreach ($finds as $find) {
                                                            ?>
                                                                <option value="<?php echo $find->id; ?>"><?php echo $find->name; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="text" class="form-control" name="patient_id" value="<?php echo $patient->id ?>" hidden>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Sub-Clinic</label>
                                                        <div id="sub_clinic_id">

                                                        </div>
                                                    </div>
                                                    -->



                                                    <button type="submit" name="waiting" class="btn btn-success">Submit</button>
                                                </form>
                                            </div>


                                        </div>

                            </div>





                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>





<?php

require('../layout/footer.php');

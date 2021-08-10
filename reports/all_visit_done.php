<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$index = 1;





?>




                            <form class="form-inline" action="" method="post">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">Start Date</span>
                                    </div>
                                    <input type="text" class="form-control" autocomplete="off" name="startDate" id="startDate" placeholder="Start Date" value="<?php echo $first_date; ?>" required>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">End Date</span>
                                    </div>
                                    <input type="text" class="form-control" autocomplete="off" name="endDate" id="endDate" placeholder="End Date" value="<?php echo $last_date; ?>" required>
                                </div>

                                <div class="input-group mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" name="search" onClick="location.href=location.href" class="btn btn-outline-warning">Refresh</button>
                                </div>

                            </form>


                            <?php
                            if (is_post()) {
                                $start_date = trim($_POST['startDate']);
                                $start_date = date("Y-m-d", strtotime($start_date));

                                $end_date = trim($_POST['endDate']);
                                $end_date = date("Y-m-d", strtotime($end_date));

                                $start_sec = "00:00:00";
                                $end_sec   = "23:59:59";
                                $startDate = $start_date . " " . $start_sec;
                                $endDate   = $end_date . " " . $end_sec;
                                $waiiting = WaitingList::find_all_done_by_date($startDate, $endDate);
                                if (empty($waiiting)) {  ?>
                                    <div  class="alert alert-info alert-dismissible" role="alert" style="width: 800px">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        No hospital visit for this period
                                    </div>
                                <?php  } else {  ?>
                                    <div  class="alert alert-success alert-dismissible" role="alert" style="width: 800px">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        All records of Hospital visit between <?php echo $start_date ." and ". $end_date ?>
                                    </div>
                                <?php  } ?>
                                <div class="card">
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table m-b-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Folder No.</th>
                                                    <th>Patients</th>
                                                    <th>Sub Clinic</th>
                                                    <th>Doctor Seen</th>
                                                    <th> Date</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (is_post()) {
                                                    foreach ($waiiting as $visit) {
                                                        $patient     = Patient::find_by_id($visit->patient_id);
                                                        $subClinic   = SubClinic::find_by_id($visit->sub_clinic_id);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $index++; ?></td>
                                                            <td><a href='patient_detail.php?id=<?php echo $visit->id ?>'><?php echo $patient->folder_number ?></a></td>
                                                            <td><?php echo $patient->full_name()  ?></td>
                                                            <td><?php echo $subClinic->name ?></td>
                                                            <td><?php echo $visit->dr_seen  ?> </td>
                                                            <td><?php $d_date = date('d/m/Y', strtotime($visit->date));
                                                                echo $d_date ?></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }  ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            <?php }  ?>








<?php
require('../layout/footer.php');


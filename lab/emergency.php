<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/25/2019
 * Time: 1:55 PM
 */

require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$user = User::find_by_id($session->user_id);



require('../layout/header.php');
?>



    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                            Laboratory Analysis </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Laboratory</li>
                            <li class="breadcrumb-item active">Analysis</li>
                        </ul>
                    </div>
                </div>
            </div>



            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card patients-list">

                        <div class="body">

                            <a style="font-size: larger" href="../lab/home.php">&laquo;Back</a>

                            <form class="form-inline" id="basic-form" action="" method="post">
                                <div class="form-group">
                                    <!--<div class="col-sm-12">-->
                                        <select class="form-control" name="department" required >
                                            <option value="" selected="selected" >--Select Laboratory--</option>
                                            <option value='Haematology'>Haematology</option>
                                            <option value='Blood Transfusion'>Blood Transfusion</option>
                                            <option value='Chemical Pathology'>Chemical Pathology</option>
                                            <option value='Microbiology'>Microbiology</option>
                                            <option value='Parasitology'>Parasitology</option>
                                            <option value='Histology'>Histology</option>
                                        </select>
                                   <!-- </div>-->
                                    <button type="submit" name="select_lab"  class="btn btn-outline-primary">Select Laboratory</button>
                                    <button type="button" name="search" onClick="location.href=location.href"  class="btn btn-outline-warning">Refresh</button>
                                </div>
                            </form>



                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#All">Pending Analysis
                                        <?php if (is_post()) {
                                            $dept = test_input($_POST['department']);
                                            echo  $dept;
                                        }

                                        ?>
                                    </a>
                                </li>
                                <!--                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#USA">USA</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#India">India</a></li>-->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content m-t-10 padding-0">
                                <div class="tab-pane table-responsive active show" id="All">
                                    <table class="table m-b-0 table-hover">
                                        <thead class="thead-primary">
                                        <tr>
                                            <th>Folder No.</th>
                                            <th>Patient Name</th>
                                            <th>Samp. Col By</th>
                                            <th>Clinic/Ward</th>
                                            <th>Doctor</th>
                                            <th>Test</th>
                                            <th>Date Of Samp. Col</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if (is_post()){

                                                $emergencies = Emergency::find_all();
                                                $status = 'REQUEST';
                                                $dept = test_input($_POST['department']);
                                             //   $results = Result::find_all_by_status_and_dept($status, $dept);
                                                foreach($emergencies as $em) {
                                                  //  $bill = Bill::find_by_id($result->bill_id);
                                                  //  $patient = Patient::find_by_id($result->patient_id);

                                                ?>
                                                <tr>
                                                    <?php
                                                    switch ($dept) {
                                                        case 'Haematology':
                                                      //  echo  "<td><a href='haem.php?id=$result->id'> $patient->folder_number </a></td>";
                                                        echo  "<td><a href='em_haem.php'> $em->folder </a></td>";
                                                             break;
                                                        case 'Blood Transfusion':
                                                            echo  "<td><a href='blood.php?id=$result->id'> $patient->folder_number </a></td>";
                                                            break;
                                                        case 'Chemical Pathology':
                                                        //    echo  "<td><a href='chem.php?id=$result->id'> $patient->folder_number </a></td>";
                                                            echo  "<td><a href='chema.php?id=$result->id'> $patient->folder_number </a></td>";
                                                              break;
                                                        case 'Microbiology':
                                                            echo  "<td><a href='micro.php?id=$result->id'> $patient->folder_number </a></td>";
                                                            break;
                                                        case 'Parasitology':
                                                            echo  "<td><a href='para.php?id=$result->id'> $patient->folder_number </a></td>";
                                                            break;
                                                        case 'Histology':
                                                            echo  "<td><a href='histo.php?id=$result->id'> $patient->folder_number </a></td>";
                                                            break;
                                                        default:
                                                          return;
                                                    }
                                                    ?>
                                                  <!--  <td><a href='micro.php?id=<?php /*echo $result->id */?>'><?php /*echo $patient->folder_number */?></a></td>-->
                                                    <td><?php echo $em->emergency_no  ?></td>
                                                    <td><?php echo $em->sample_col_by ?></td>
                                                    <td><?php echo $em->clinic ?></td>
                                                    <td><?php echo $em->doctor ?>  </td>
                                    
                                                </tr>

                                       <?php    } } else {
                                        $status = 'REQUEST';
                                        $results = Result::find_all_by_status($status);
                                        foreach($results as $result) {
                                            $bill = Bill::find_by_id($result->bill_id);
                                            $patient = Patient::find_by_id($result->patient_id);
                                            ?>
                                            <!--
                                            <tr>
                                                <td><a href='all_lab.php?id=<?php echo $result->id ?>'><?php echo $patient->folder_number ?></a></td>
                                                <td><?php echo $patient->full_name()  ?></td>
                                                <td><?php echo $result->sample_col_by ?></td>
                                                <td><?php echo $result->clinic ?></td>
                                                <td><?php echo $result->doctor ?>  </td>
                                                <td><?php  $decode = json_decode($result->test);
                                                    foreach ($decode as $test) { echo $test . "<br/>"; }
                                                    ?>
                                                </td>
                                                <td><?php $d_date = date('d/m/Y h:i a', strtotime($result->date_col)); echo $d_date ?></td>                                         
                                            </tr>
                                            -->
                                        <?php } } ?>
                                        </tbody>
                                    </table>
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



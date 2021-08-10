<?php


$result = ScanResult::find_by_waiting_list_id($waitList->id);
$patient = Patient::find_by_id($result->patient_id);
$user = User::find_by_id($session->user_id);


?>





<div class="body">
                            <div class="container">


                                <h4 style="text-align: center">OBAFEMI AWOLOWO UNIVERSITY TEACHING HOSPITALS COMPLEX</h4>
                                <h6 style="text-align: center">RADIOLOGY/ULTRASOUND RESULT</h6>


                                <form action="" method="post">


                                    <div class="row">

                                    </div>

                                    <div class="row">


                                        <div class="col-md-6">


                                            <div class="table-responsive">
                                                <!--<h4><?php /*echo $patient->full_name() */ ?></h4>-->
                                                <table class="table table">
                                                    <tbody>
                                                    <tr class="active">
                                                        <th>Patient</th>
                                                        <td> <?php // echo $patient->full_name()  ?>
                                                            <?php
                                                            if (!empty($patient)) {
                                                                echo $patient->full_name();
                                                            } else {
                                                                echo $bill->first_name ." ". $bill->last_name;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="active">
                                                        <th>Clinical Details</th>
                                                        <td> <?php echo $scanRequest->doc_com  ?></td>
                                                    </tr>

                                                    <?php
                                                    if (!empty($patient)) {
                                                        ?>
                                                        <tr class="active">
                                                            <th>Birthdate</th>
                                                            <td> <?php $d_date = date('d-M-Y', strtotime($patient->dob));
                                                                echo $d_date ?></td>
                                                        </tr>
                                                    <?php } ?>

                                                    <tr class="active">
                                                        <th>Age</th>
                                                        <td> <?php // echo $radWalkin->age . 'years'  ?>
                                                            <?php
                                                            if (!empty($patient)) {
                                                                echo getAge($patient->dob) . 'years';
                                                            } else {
                                                                echo $radWalkin->age . 'years' ;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="active">
                                                        <th>Sex</th>
                                                        <td> <?php // echo $patient->gender   ?>
                                                            <?php
                                                            if (!empty($patient)) {
                                                                echo $patient->gender ;
                                                            } else {
                                                                echo $radWalkin->gender  ;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr class="active">
                                                        <th>Investigations</th>
                                                        <td> <?php $decode = json_decode($result->scan);
                                                            foreach ($decode as $item) {
                                                                echo $item . ', ';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <table class="table table">
                                                <tbody>
                                                <tr class="active">
                                                    <th>Xray No.</th>
                                                    <td> <?php echo $result->xray_no   ?> </td>
                                                    <!--  <td> <input class="form-control" style="width: 300px;" value="" name="xray_no" /> </td>  -->
                                                </tr>

                                                <tr class="active">
                                                    <th>Hospital No.</th>
                                                    <td> <?php echo $patient->folder_number   ?> </td>
                                                </tr>
                                                <tr class="active">
                                                    <th>Ward/Clinic </th>
                                                    <td> <?php echo $result->ward ?> </td>
                                                </tr>
                                                <tr class="active">
                                                    <th> Doctor </th>
                                                    <td> <?php echo $scanRequest->consultant  ?> </td>
                                                </tr>
                                                <tr class="active">
                                                    <th> Radiologist </th>
                                                    <td> <?php echo $result->radiologist  ?> </td>
                                                </tr>

                                                <tr class="active">
                                                    <th>Result Date </th>
                                                    <td> <?php $d_date = date('d/M/Y h:i a', strtotime($result->date));
                                                        //   $time = date('h:i a', strtotime($result->time_col));
                                                        echo $d_date ?> </td>
                                                </tr>



                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="body">

                                        <textarea class="summernote" name="result">
                                             <?php // echo $result->resultData

                                             $decode = json_decode($result->resultData);
                                             echo $decode


                                             ?>

                                            </textarea>




                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                                    <label class="custom-file-label" for="inputGroupFile02">Choose file...</label>
                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                    <!--
                                    <p class="margin-top-30">
                                        <button type="submit" name="save_only" class="btn btn-lg btn-primary">Save Only</button> &nbsp;&nbsp;
                                        <button type="submit" name="save_and_send" class="btn btn-lg btn-success">Save And Send</button>
                                    </p>
                                    -->




                                </form>









                            </div>
                        </div>










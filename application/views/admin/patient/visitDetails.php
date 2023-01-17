<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
$genderList = $this->customlib->getGender();
$case_reference_id=$result['case_reference_id'];

$opd_visit_details =  $this->patient_model->getopdvisitDetailsbyvisitid($visitminid);
?> 
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div class="content-wrapper">
    <section class="content">
        <div class="row">     

            <div class="col-md-12 itemcol">
                <div class="nav-tabs-custom relative">
                   
                    <ul class="nav nav-tabs navlistscroll">
                          <li><a href="#overview" class="active" data-toggle="tab" aria-expanded="true"><i class="fa fa-th"></i> <?php echo $this->lang->line('overview'); ?></a></li>
                        <?php if ($this->rbac->hasPrivilege('checkup', 'can_view')) { ?>
                            <li ><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="far fa-caret-square-down"></i> <?php echo $this->lang->line('visits'); ?></a></li>

                            <?php
                        }
                         if ($this->rbac->hasPrivilege('opd_medication', 'can_view')) { ?>
                            <li><a href="#medication" class="medication" data-toggle="tab" aria-expanded="true"><i class="fa fa-medkit" aria-hidden="true"></i> <?php echo $this->lang->line("medication"); ?></a>
                            </li>

                        <?php }  ?>
                        <?php if ($this->rbac->hasPrivilege('opd_lab_investigation', 'can_view')) { ?>
                            <li><a href="#labinvestigation" data-toggle="tab" aria-expanded="true"><i class="fas fa-diagnoses"></i> <?php echo $this->lang->line('lab_investigation'); ?></a></li>
                        <?php } ?>

                         <?php if ($this->rbac->hasPrivilege('opd_operation_theatre', 'can_view')) { ?>
                        <li><a href="#operationtheatre" data-toggle="tab" aria-expanded="true"><i class="fas fa-cut"></i> <?php echo $this->lang->line("operations"); ?></a></li>

                        <?php }  

                        if ($this->rbac->hasPrivilege('opd_charges', 'can_view')) {
                            ?>
                            <li><a href="#charges" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('charges'); ?></a></li>
                            <?php
                        }
                        if ($this->rbac->hasPrivilege('opd_payment', 'can_view')) {     ?>
                            <li><a href="#payment" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('payments'); ?></a></li>
                            <?php
                        }                       
                        
                        if ($this->module_lib->hasActive('live_consultation')) { if ($this->rbac->hasPrivilege('opd_live_consult', 'can_view')) { ?>
                           
                            <li><a href="#live_consult" data-toggle="tab" aria-expanded="true"><i class="fa fa-video-camera ftlayer"></i> <?php echo $this->lang->line('live_consultation'); ?></a></li>
                            
                        <?php } } ?>

                         <?php if ($this->rbac->hasPrivilege('opd_timeline', 'can_view')) { ?>
                            <li><a href="#timeline" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('timeline'); ?></a></li>

                        <?php } ?>

                    </ul>
                   
                    <div class="tab-content pt6">
                        <div class="tab-pane tab-content-height  active" id="overview">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 border-r">

                                    <div class="box-header border-b mb10 pl-0 pt0">
                                        <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"> <?php echo composePatientName($result['patient_name'],$result['patient_id']); ?></h3>
                                        <?php // print_r($result); ?>
                                        <div class="pull-right">
                                             <div class="editviewdelete-icon pt8 text-center">
                                                <?php if ($this->rbac->hasPrivilege('opd_patient', 'can_edit')) { ?>
                                                    

                                                    <a href="#"  onclick="editRecord('<?php echo $visitminid; ?>')" data-target="#editModal" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                                <?php } ?>
                                                <?php if ($this->rbac->hasPrivilege('opd_patient', 'can_delete')) { ?>
                                                    <a class="" href="#" onclick="delete_patient('<?php echo $result['id'] ?>','<?php echo $result['patient_id'] ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('delete_patient'); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                        
                                                <?php } if ($this->rbac->hasPrivilege('opd_patient_discharge', 'can_view')) { ?>
                                                <a class="patient_discharge" href="#"    data-toggle="tooltip" title="<?php echo $this->lang->line('patient_discharge'); ?>"><i class="fa fa-hospital-o"></i>
                                                        </a> 
                                                <?php } if(!$is_discharge){
                                                    if ($this->rbac->hasPrivilege('opd_patient_discharge_revert', 'can_view')) { ?>
                                                     <a data-toggle="tooltip" class="" onclick="discharge_revert('<?php echo $result['case_reference_id']; ?>')" href="#" title="<?php echo $this->lang->line('discharge_revert')?>"><i class="fa fa-undo"> </i></a>
                                                    <?php
                                                } } ?>
                                                <input type="hidden" id="result_opdid" name="" value="<?php echo $result['id'] ?>">
                                            <input type="hidden" id="result_pid" name="" value="<?php echo $result['patient_id'] ?>"> 
                           
                                         </div>
                                        </div>
                                    </div> 
                                     <div class="row">
                                            <div class="col-lg-3 col-md-4 col-sm-12 ptt10">
                                                
                                                <?php

                                                    $image = $result['image'];
                                                    if (!empty($image)) {
                                                        $file = $result['image'];
                                                    } else {
                                                        $file = "uploads/patient_images/no_image.png";
                                                    }
                                                   
                                                    ?>
                                                    <img width="115" height="115" class="profile-user-img img-responsive img-rounded" src="<?php echo base_url(); ?><?php echo $file.img_time(); ?>" >
                                            
                                            </div><!--./col-lg-5-->
                                            <div class="col-lg-9 col-md-8 col-sm-12">
                                                <table class="table table-bordered mb0">
                                                   <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('gender'); ?></td>
                                                       <td><?php echo $result['gender']; ?></td>
                                                    </tr>
                                                     <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('age'); ?></td>
                                                        <td><?php echo $this->customlib->getPatientAge($result['age'],$result['month'],$result['day']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('guardian_name')?></td>
                                                       <td><?php echo $result['guardian_name']; ?></td>
                                                    </tr>
                                                     
                                                    <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('phone'); ?></td>
                                                         <td><?php echo $result['mobileno']; ?></td>
                                                    </tr>
                                                    <?php /** new code added be T. Prasad At 17-01-2023*/ ?>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('height'); ?></td>
                 <td><?php echo $opd_visit_details['height']; ?></td>
            </tr>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('weight'); ?></td>
                 <td><?php echo $opd_visit_details['weight']; ?></td>
            </tr>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('bp'); ?></td>
                 <td><?php echo $opd_visit_details['bp']; ?></td>
            </tr>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('pulse'); ?></td>
                 <td><?php echo $opd_visit_details['pulse']; ?></td>
            </tr>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('temperature'); ?></td>
                 <td><?php echo $opd_visit_details['temperature']; ?></td>
            </tr>
            <tr>
                <td class="bolds"><?php echo $this->lang->line('respiration'); ?></td>
                 <td><?php echo $opd_visit_details['respiration']; ?></td>
            </tr>
           
            <tr>
                <td class="bolds"><?php echo $this->lang->line('note'); ?></td>
                 <td><?php echo $opd_visit_details['note']; ?></td>
            </tr>
            

                                                   
                                                    
                                                </table>
                                                <div class="opd_symptoms_data_view">
<?php 
                                              //  print_r($opd_visit_details);
                                                ?>                                
                                                </div>
                                            </div><!--./col-lg-7-->
                                        </div><!--./row-->
                                         <hr class="hr-panel-heading hr-10">
                                            <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="align-content-center pt25">
                                                    <table class="table table-bordered">
                                                         <tr>
                                                            <td class="bolds"><?php echo $this->lang->line('case_id') ?></td>
                                                             <td><?php echo $result['case_reference_id']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bolds"><?php echo $this->lang->line('opd_no'); ?></td>
                                                             <td><?php echo $this->customlib->getSessionPrefixByType('opd_no').$opdid; ?></td>
                                                        </tr>
                                                       
                                                       
                                                    </table>
                                                </div>    
                                            </div>
                                           
                                        </div>
                                   
                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i> <?php echo $this->lang->line('known_allergies'); ?>:</b></p>
                                    <ul>  
                                    <?php 
                                        if(!empty($patientdetails['patient']['allergy'])){
                                    foreach($patientdetails['patient']['allergy'] as $row){ ?>
                                         <li><div ><?php echo $row['known_allergies']; ?></div></li>
                                    <?php } } ?>
                                </ul>
                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i> <?php echo $this->lang->line('findings'); ?>:</b></p>  
                                    <ul>
                                    <?php 
                                     if(!empty($patientdetails['patient']['findings'])){
                                    foreach($patientdetails['patient']['findings'] as $row){ ?>
                                         <li><div ><?php echo $row['finding_description']; ?></div></li>
                                    <?php } } ?>
                                </ul>
                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i> <?php echo $this->lang->line('symptoms'); ?>:</b></p> 
                                     <ul> 
                                    <?php if(!empty($patientdetails['patient']['symptoms'])){
                                    foreach($patientdetails['patient']['symptoms'] as $row){ ?>
                                          <li><div ><?php echo $row['symptoms']; ?></div></li>
                                    <?php } } ?>
                                </ul>
                                
                                    <hr class="hr-panel-heading hr-10"> 
                                    <div class="box-header mb10 pl-0">
                                        <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('consultant_doctor'); ?></h3>
                                        <div class="pull-right">
                                            <div class="editviewdelete-icon pt8">
                                              
                                            </div>  
                                        </div>
                                    </div> 


                                    <div class="staff-members">
                                       <?php 
                                        if(!empty($patientdetails['patient']['doctor'])){
                                        foreach($patientdetails['patient']['doctor'] as $value ){  ?>
                                            <div class="media">
                                                <div class="media-left">
                                                    <?php if($value['image']!=""){ ?>
                                                        <a href="#">
                                                        <img src="<?php echo base_url("uploads/staff_images/".$value['image'].img_time()); ?>" class="member-profile-small media-object"></a>
                                                    <?php }else{ ?>
                                                          <img src="<?php echo base_url("uploads/staff_images/no_image.png".img_time()) ?>" class="member-profile-small media-object"></a>
                                                    <?php } ?>
                                                     
                                                </div>
                                                <div class="media-body">
                                                    <a href="#" class="pull-right text-danger pt4" data-toggle="tooltip" data-placement="top" ></a>
                                                    <h5 class="media-heading"><a href="#"><?php echo $value["name"] . " " . $value["surname"]."  (".$value["employee_id"].")" ?></a>
                                                      
                                                    </h5>
                                                </div>
                                            </div><!--./media-->
                                             <?php } } ?>
                                     </div><!--./staff-members-->

                                    <div class="box-tab-header">
                                        <h3 class="box-tab-title"><?php echo $this->lang->line('timeline'); ?></h3>
                                    </div>
                                    <div class="timeline-header no-border">
                                        <div id="timeline_list">
                                            <?php
                                        if (empty($timeline_list)) {
                                                ?>
                                               
                                            <?php } else {
        ?>
                                                <ul class="timeline timeline-inverse">

                                                    <?php $i=0 ;
                                                        foreach ($timeline_list as $key => $value) {

                                                             ++$i;
                                                            if($i <= $recent_record_count)
                                                            {
                                                            ?>
                                                        <li class="time-label">
                                                            <span class="bg-blue">    <?php echo $this->customlib->YYYYMMDDTodateFormat($value['timeline_date']); ?>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-list-alt bg-blue"></i>
                                                            <div class="timeline-item">

                                                                <?php if (!empty($value["document"])) {?>
                                                                    <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" href="<?php echo base_url() . "patient/dashboard/download_patient_timeline/" . $value["id"] . "/" . $value["document"] ?>" data-original-title="<?php echo $this->lang->line('download'); ?>"><i class="fa fa-download"></i></a></span>
                                                                <?php }?>
                                                                <h3 class="timeline-header text-aqua"> <?php echo $value['title']; ?> </h3>
                                                                <div class="timeline-body">
                                                                    <?php echo $value['description']; ?>

                                                                </div>

                                                            </div>
                                                        </li>
                                                    <?php } } ?>
                                                    <li><i class="fa fa-clock-o bg-gray"></i></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div><!--./col-lg-6-->
                                 <div class="col-lg-6 col-md-6 col-sm-12">
                                         <div class="row">
                                            <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                       <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('opd_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['opd']['opd_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill($graph['opd']['payment']['total_payment'],$graph['opd']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['opd']['opd_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--./row-->
                                           </div><!--./col-lg-6-->
                                           <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                        <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('pharmacy_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['pharmacy']['pharmacy_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill(($graph['pharmacy']['payment']['total_payment']-$graph['pharmacy']['payment_refund']['total_payment']),$graph['pharmacy']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['pharmacy']['pharmacy_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                           </div><!--./col-lg-6-->
                                            
                                        </div><!--./row-->
                                        <div class="row">
                                            <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                       <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('pathology_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['pathology']['pathology_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill($graph['pathology']['payment']['total_payment'],$graph['pathology']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['pathology']['pathology_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--./row-->
                                           </div><!--./col-lg-6-->
                                           <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                        <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('radiology_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['radiology']['radiology_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill($graph['radiology']['payment']['total_payment'],$graph['radiology']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['radiology']['radiology_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                           </div><!--./col-lg-6-->
                                            
                                        </div><!--./row-->
                                        <div class="row">
                                            <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                       <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('blood_bank_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['blood_bank']['blood_bank_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill($graph['blood_bank']['payment']['total_payment'],$graph['blood_bank']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['blood_bank']['blood_bank_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--./row-->
                                           </div><!--./col-lg-6-->
                                           <div class="col-md-6 project-progress-bars">
                                                <div class="row">
                                                    <div class="col-md-12 mtop5">
                                                        <div class="topprograssstart">
                                                            <h5 class="text-uppercase mt5 bolds"><?php echo $this->lang->line('ambulance_billing_payment_graph'); ?>
                                                            </h5>
                                                            <p class="text-muted bolds"><?php echo $graph['ambulance']['ambulance_bill_payment_ratio'];?>%<span class="pull-right"> <?php echo $this->customlib->get_payment_bill($graph['ambulance']['payment']['total_payment'],$graph['ambulance']['bill']['total_bill']);?></span></p>
                                                            <div class="progress-group">
                                                                <div class="progress progress-minibar">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: <?php echo $graph['ambulance']['ambulance_bill_payment_ratio'];?>%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                           </div><!--./col-lg-6-->
                                            
                                        </div><!--./row-->

                                         <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('medication'); ?></h3>
                                           <div class="pull-right">
                                          </div>
                                        </div>
                                        <div class="box-header mb10 pl-0">
                                            <div class="table-responsive">
                                               <table class="table table-striped table-bordered table-hover " >
                                                        <thead>
                                                            <tr>
                                                            <th><?php echo $this->lang->line('date');?></th>
                                                            <th><?php echo $this->lang->line('medicine_name');?></th>
                                                            <th><?php echo $this->lang->line('dose');?></th>
                                                            <th><?php echo $this->lang->line('time');?></th>
                                                            <th><?php echo $this->lang->line('remark');?></th>
                                                          <tr>
                                                        </thead>
                                                        <tbody>
                                                             <?php 
                                                          for ($i=0; $i <$recent_record_count; $i++) { 
                                                         if(!empty($medicationreport_overview[$i])){
                                                   ?>
                                                   <tr>
                                                       <td><?php echo $this->customlib->YYYYMMDDTodateFormat($medicationreport_overview[$i]['date']); ?></td>
                                                       <td><?php echo $medicationreport_overview[$i]['medicine_name']?></td>
                                                        <td><?php echo $medicationreport_overview[$i]['medicine_dosage']." (".$medicationreport_overview[$i]['unit'].")";?></td>
                                                       <td><?php echo $this->customlib->getHospitalTime_Format($medicationreport_overview[$i]['time']);?></td>
                                                       <td><?php echo $medicationreport_overview[$i]['remark'];?></td>
                                                   </tr>
                                                   <?php
                                                }
                                            }
                                                ?>                                                        
                                                        </tbody>
                                              
                                                </table>
                                            </div>
                                         
                                        </div>
                                        <!---lab investigation-->

                                        <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('lab_investigation'); ?></h3>
                                           <div class="pull-right">
                                               
                                          </div>
                                        </div>
                                         <div class="box-header mb10 pl-0">
                                             <div class="table-responsive"> 
                                             <table class="table table-striped table-bordered table-hover" data-export-title="<?php echo $this->lang->line('lab_investigation'); ?>">
                                                <thead>
                                                    <th><?php echo $this->lang->line('test_name'); ?></th>
                                                     <th><?php echo $this->lang->line('lab'); ?></th>
                                                    <th><?php echo $this->lang->line('sample_collected'); ?></th>
                                                    <td><strong><?php echo $this->lang->line('expected_date'); ?></strong></td>
                                                     <th><?php echo $this->lang->line('approved_by'); ?></th>
                                                   
                                                </thead>
                                                <tbody id="">
                                                    <?php
                                                    $i=0;
                                                     foreach($investigations as $row ){ 
                                                        ++$i;

                                                              if($i <= $recent_record_count){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row['test_name']; ?><br/>
                                                           <?php echo "(".$row['short_name'].")"; ?></td>
                                                            <td><?php echo $this->lang->line($row['type']); ?></td>
                                                            <td><label>
                                                             <?php echo composeStaffNameByString($row['collection_specialist_staff_name'],$row['collection_specialist_staff_surname'],$row['collection_specialist_staff_employee_id']); ?>
                                                             </label>
                                                
                                                             <br/>
                                                             <label for=""><?php if($row['type']=='pathology'){ echo $this->lang->line('pathology');  }else{ echo $this->lang->line('radiology');

                                                             }  ?> : </label>
                                                
                                                                    <?php
                                                               echo $row['test_center']; 
                                                                ?>
                                                                <br/>
                                                                 <?php echo $this->customlib->YYYYMMDDTodateFormat($row['collection_date']); ?></td>
                                                                   
                                                             <td>
                                                            <?php
                                                            
                                                            echo  $this->customlib->YYYYMMDDTodateFormat($row['reporting_date']); ?>
                                                                
                                                            </td>
                                                            <td class="text-left">
                                                                 <label for=""><?php echo $this->lang->line('approved_by'); ?> : </label>
                                                                <?php      
                                                            echo composeStaffNameByString($row['approved_by_staff_name'],$row['approved_by_staff_surname'],$row['approved_by_staff_employee_id']);
                                                             ?>
                                                             <br/>
                                                            <?php                                
                                                            echo  $this->customlib->YYYYMMDDTodateFormat($row['parameter_update']);
                                                             ?>                                         
                                                            </td>
                                                           
                                                            </tr>
                                                             <?php } } ?>
                                                            </tbody>
                                                        </table>
                                            </div> 
                                         
                                        </div>

                                           <!---lab investigation-->


                                        <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('operation'); ?></h3>
                                           <div class="pull-right">
                                               
                                          </div>
                                        </div>
                                         <div class="box-header mb10 pl-0">
                                             <div class="table-responsive"> 
                                     <table class="table table-striped table-bordered table-hover" data-export-title="<?php echo $this->lang->line('operations'); ?>">
                                        <thead>
                                            <th><?php echo $this->lang->line("reference_no"); ?></th>
                                            <th><?php echo $this->lang->line("operation_date"); ?></th>
                                            <th><?php echo $this->lang->line("operation_name"); ?></th>
                                            <th><?php echo $this->lang->line("operation_category"); ?></th>
                                            <th><?php echo $this->lang->line("ot_technician"); ?></th>
                                        </thead>
                                            <tbody id="">
                                                    <?php
                                                    $i=0;
                                                if (!empty($operation_theatre)) {
                                                    foreach ($operation_theatre as $ot_key => $ot_value) {


                                                        $i++;
                                                         if($i <= $recent_record_count){
                                                        ?>  
                                                        <tr>    
                                                            <td><?php echo $this->customlib->getSessionPrefixByType('operation_theater_reference_no'). $ot_value["id"] ?></td>
                                             <td><?php echo 
                                                $this->customlib->YYYYMMDDHisTodateFormat($ot_value["date"],$this->customlib->getHospitalTimeFormat());
                                                ?></td>
                                                            <td><?php echo $ot_value["operation"]; ?></td>
                                                            <td><?php echo $ot_value["category"] ?></td>
                                                            <td><?php echo $ot_value['ot_technician'] ?></td>
                                                            
                                                            
                                                        </tr>
                                                    
                                                    <?php } } }?>
                                            </tbody>
                                        </table>
                                            </div> 
                                         
                                        </div>

                                        <!---consultant section-->
                                       
                                         <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('charges'); ?></h3>
                                           <div class="pull-right">
                                               
                                          </div>
                                        </div>
                                         <div class="box-header mb10 pl-0">
                                             <div class="table-responsive"> 
                                        <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                           
                                            <th><?php echo $this->lang->line('name'); ?></th>
                                            <th><?php echo $this->lang->line('charge_type'); ?></th>
                                           
                                            <th class=""><?php echo $this->lang->line('standard_charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                            <th class=""><?php echo $this->lang->line('tax'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('applied_charge') . ' (' . $currency_symbol . ')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?></th>
                                       
                                        </thead>
                                        <tbody>
                                         <?php 
                                            $total = 0;  $i=0;
                                            if (!empty($charges_detail)) {
                                                foreach ($charges_detail as $charges_key => $charges_value) {
                                                    ++$i;
                                                    if($i <= $recent_record_count){

                                                    $tax_amount = ($charges_value['apply_charge']*$charges_value['tax']/100) ;
                                                    $taxamount = amountFormat($tax_amount);
                                                    $total += $charges_value["amount"];
                                                ?>  
                                                    <tr>
                                                       
                                                        <td class="">
                                                            <?php echo $charges_value["name"]; ?>
                                                             <div class="bill_item_footer text-muted"><label><?php if($charges_value["note"] !=''){ echo $this->lang->line('charge_note').': ';} ?></label> <?php echo $charges_value["note"]; ?></div>
                                                        </td>
                                                        <td style="text-transform: capitalize;"><?php echo $charges_value["charge_type"] ?></td>
                                                       
                                                    
                                                        <td class="text-right"><?php echo $charges_value["standard_charge"] ?></td>
                                                       
                                                        <td class="text-right"><?php echo "(".$charges_value["tax"]."%) ".$taxamount ;?></td>
                                                        <td class="text-right"><?php echo $charges_value["apply_charge"] ?></td>
                                                        <td class="text-right"><?php echo $charges_value["amount"] ?></td>
                                                       
                                                       
                                                    </tr>
                                                    <?php
                                                  }
                                                }
                                            }
                                            ?>  

                                        </tbody>
                                    </table>
                                </div> 
                                         
                             </div>


                                        <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('payment'); ?></h3>
                                           <div class="pull-right">
                                               
                                          </div>
                                        </div>
                                         <div class="box-header mb10 pl-0">
                                             <div class="table-responsive"> 
                                      <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo $this->lang->line('transaction_id'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('note'); ?></th>
                                            <th><?php echo $this->lang->line('payment_mode'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('paid_amount') . " (" . $currency_symbol . ")"; ?></th>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $total_payment = 0; 
                                            if (!empty($payment_details)) {
                                                $total_payment = 0; $i=0;
                                                foreach ($payment_details as $payment) {

                                                     ++$i ;
                                                         if($i <= $recent_record_count){
                                                            if (!empty($payment['amount'])) {
                                                                $total_payment += $payment['amount'];

                                                            }
                                                    ?> 
                                                    <tr>
                                                        <td><?php echo $this->customlib->getSessionPrefixByType('transaction_id').$payment['id']; ?></td>
                                                        <td><?php echo $this->customlib->YYYYMMDDHisTodateFormat($payment['payment_date'],$this->customlib->getHospitalTimeFormat()); ?></td>
                                                        <td><?php echo $payment["note"] ?></td>
                                                         <td ><?php echo $this->lang->line(strtolower($payment["payment_mode"]))."<br>";

                                                        if($payment['payment_mode'] == "Cheque"){
                                                             if($payment['cheque_no']!=''){
                                       echo $this->lang->line('cheque_no') . ": ".$payment['cheque_no'];
                                      
                                    echo "<br>";
                                }
                                    if($payment['cheque_date']!='' && $payment['cheque_date']!='0000-00-00'){
                                       echo $this->lang->line('cheque_date') .": ".$this->customlib->YYYYMMDDTodateFormat($payment['cheque_date']);
                                   }
                                       

                                     }
                                                        ?>
                                                            

                                                        </td>
                                                        <td class="text-right"><?php echo $payment["amount"] ?></td>
                                                    </tr>

                                        <?php } 
                                    } }?> 
                                        </tbody>
                                               
                                    </table>
                                            </div> 
                                         
                                        </div>

                                        


                                      
                                        <div class="box-header mb10 pl-0">
                                           <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14"><?php echo $this->lang->line('live_consultation'); ?></h3>
                                           <div class="pull-right">
                                               
                                          </div>
                                        </div>
                                         <div class="box-header mb10 pl-0">
                                             <div class="table-responsive"> 
                                            <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <th><?php echo $this->lang->line('consultation_title'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('created_by'); ?> </th>
                                        <th><?php echo $this->lang->line('created_for'); ?></th>
                                        <th><?php echo $this->lang->line('patient'); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php $i=0;
                                    if (empty($visitconferences)) {
                                        ?>

                                        <?php
                                    } else {
                                        foreach ($visitconferences as $conference_key => $conference_value) {

                                             ++$i;

                                             if($i <= $recent_record_count){

                                            $return_response = json_decode($conference_value->return_response);
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $conference_value->title; ?></a>

                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($conference_value->description == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $conference_value->description; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>

                                                <td class="mailbox-name">
                                                <?php echo date($this->customlib->getHospitalDateFormat(true, true), strtotime($conference_value->date))?>
                                          
                                                <td class="mailbox-name">

                                                    <?php
                                                    if ($conference_value->created_id == $logged_staff_id) {
                                                        echo $this->lang->line('self');
                                                    } else {
                                                        $name= ($conference_value->create_by_surname == "") ? $conference_value->create_by_name : $conference_value->create_by_name . " " . $conference_value->create_by_surname;
        echo  $name. " (".$conference_value->for_create_role_name." : ".$conference_value->for_create_employee_id.")";
                                                    }
                                                    ?></td>

                                                <td class="mailbox-name">
                                                    <?php

                                                          $name= ($conference_value->create_for_surname == "") ? $conference_value->create_for_name : $conference_value->create_for_name . " " . $conference_value->create_for_surname;
        echo  $name. " (".$conference_value->for_create_role_name." : ".$conference_value->for_create_employee_id.")";


                                                  
                                                    ?>
                                                </td>

                                                <td class="mailbox-name">
                                                     <?php

                                                          $name= ($conference_value->patient_name == "") ? $conference_value->patient_name : $conference_value->patient_name ;
        echo  $name. " (".$this->lang->line('patient')." : ".$conference_value->patientid.")";


                                                  
                                                    ?>

                                                </td>
                                              
                                               
                                            </tr>
                                            <?php
                                         }
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                            </div> 
                                         
                                        </div>


                                             
                                    </div><!--./col-lg-6-->
                            </div><!--./row-->  
                        </div><!--#/overview-->
                        <?php if ($this->rbac->hasPrivilege('checkup', 'can_view')) { ?>
                            <div class="tab-pane" id="activity">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('checkups'); ?></h3>
                                        <div class="box-tab-tools">
                                            <?php if ($this->rbac->hasPrivilege('checkup', 'can_add')) { if($is_discharge){ ?> 

                                        <a href="#"  onclick="getRevisitRecord('<?php echo $visitdata['visitid'] ?>')" class="btn btn-primary btn-sm revisitrecheckup"  data-toggle="modal" title=""><i class="fa fa-plus"></i> <?php echo $this->lang->line('new_checkup'); ?></a>
                                       <?php }} ?> 
                                         </div>    
                                   </div>

                               <div class="download_label"><?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?></div>
                                <div class="table-responsive">
                                    <h5><?php echo $opd_prefix.$result['id']; ?></h5> 
                                    <table class="table table-striped table-bordered table-hover ajaxlist" cellspacing="0" width="" data-export-title="<?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?>">
                                        <thead>
                                        <th><?php echo $this->lang->line('checkup_id'); ?></th>
                                        <th><?php echo $this->lang->line('appointment_date'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('reference'); ?></th>
                                        <th><?php echo $this->lang->line('symptoms'); ?></th>
                                        <?php 
                                            if (!empty($fields)) {
                                                foreach ($fields as $fields_key => $fields_value) {
                                                    ?>
                                                    <th><?php echo $fields_value->name; ?></th>
                                                    <?php
                                                } 
                                            } 
                                        ?> 
                                        <th class="text-right noExport"><?php echo $this->lang->line('action') ?></th>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                        <?php } ?>
                        

                        <div class="tab-pane" id="operationtheatre">
                            <div class="box-tab-header">
                                <h3 class="box-tab-title"><?php echo $this->lang->line("operations"); ?></h3>
                                <div class="box-tab-tools">
                                   <?php if($is_discharge){ 

                                    if ($this->rbac->hasPrivilege('opd_operation_theatre', 'can_add')) { ?>
                                    <a data-toggle="modal" onclick="holdModal('add_operationtheatre')" class="btn btn-primary btn-sm addoperationtheatre"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add_operation"); ?></a>
                                <?php }} ?>
                                </div>
                            </div>    
                            
                           <div class="download_label"><?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example" data-export-title="<?php echo $this->lang->line('operation_theatre'); ?>">
                                    <thead>
                                        <th><?php echo $this->lang->line("reference_no"); ?></th>
                                        <th><?php echo $this->lang->line("operation_date"); ?></th>
                                        <th><?php echo $this->lang->line("operation_name"); ?></th>
                                        <th><?php echo $this->lang->line("operation_category"); ?></th>
                                        <th><?php echo $this->lang->line("ot_technician"); ?></th>
                                        <?php 
                                            if (!empty($ot_fields)) {
                                                foreach ($ot_fields as $fields_key => $fields_value) {
                                                    ?>
                                                    <th class="white-space-nowrap"><?php echo $fields_value->name; ?></th>
                                                    <?php
                                                } 
                                            }
                                        ?> 
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody id="">
                                            <?php
                                        if (!empty($operation_theatre)) {
                                            foreach ($operation_theatre as $ot_key => $ot_value) {
                                                ?>  
                                                <tr>    
                                                    <td><?php echo $this->customlib->getSessionPrefixByType('operation_theater_reference_no'). $ot_value["id"] ?></td>
                                     <td><?php echo 
                                        $this->customlib->YYYYMMDDHisTodateFormat($ot_value["date"],$this->customlib->getHospitalTimeFormat());
                                        ?></td>
                                                    <td><?php echo $ot_value["operation"]; ?></td>
                                                    <td><?php echo $ot_value["category"] ?></td>
                                                    <td><?php echo $ot_value['ot_technician'] ?></td>
                                                    <?php
                                                    if (!empty($ot_fields)) {

                                                        foreach ($ot_fields as $fields_key => $fields_value) {
                                                            $display_field = $ot_value[$fields_value->name];
                                                            if ($fields_value->type == "link") {
                                                                $display_field = "<a href=" . $ot_value[$fields_value->name] . " target='_blank'>" . $ot_value[$fields_value->name] . "</a>";
                                                            }
                                                            ?>
                                                            <td>
                                                                <?php echo $display_field; ?>

                                                            </td>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <td class="text-right">
                                                        <a href='javascript:void(0);' class='btn btn-default btn-xs viewot' data-backdrop="static" data-keyboard="false" data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i>' data-toggle='tooltip' data-record-id='<?php echo $ot_value['id']; ?>'  title="<?php echo  $this->lang->line('show')?>"><i class='fa fa-reorder'></i></a>
                                                        <?php
                                                        if($is_discharge){
                                                            if ($this->rbac->hasPrivilege('opd_operation_theatre', 'can_edit')) { ?>
                                                          
                                                            <a data-record-id='<?php echo $ot_value['id']; ?>'class="btn btn-default btn-xs editot" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                                    <i class="fa fa-pencil"></i>
                                                            </a>   
                                                            <?php }
                                                            if ($this->rbac->hasPrivilege('opd_operation_theatre', 'can_delete')) { ?>

                                                            <a onclick="deleteot('<?php echo $ot_value['id']; ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                            </a> 
                                                            <?php
                                                        }
                                                        } 
                                                        ?>  
                                                    </td>
                                                </tr>
                                            
                                            <?php } }?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>   


                        <div class="tab-pane" id="medication">
                                    <div class="box-tab-header">
                                        <h3 class="box-tab-title"><?php echo $this->lang->line("medication"); ?></h3>
                                        <div class="box-tab-tools">
                                        <?php if ($this->rbac->hasPrivilege('opd_medication', 'can_add')) {   if($is_discharge){ ?>
                                            <a href="#" class="btn btn-sm btn-primary dropdown-toggle addmedication" onclick="addmedicationModal()" data-toggle='modal'><i class="fa fa-plus"></i> <?php echo $this->lang->line("add_medication_dose"); ?></a>
                                        <?php }} ?>
                                        </div>    
                                   </div><!--./box-tab-header-->  
           
                                    <div class="download_label"><?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?></div>
                                    <div class="table_inner"> 
                                        <table class="table table-striped table-bordered table-hover">
                                        <?php 
                                        if(!empty($medication)){ ?>
                                          <thead>
                                             <th class="hard_left"><?php echo $this->lang->line("date"); ?> </th>
                                             <th class="next_left"><?php echo $this->lang->line("medicine_name"); ?></th>
                                            <?php 
                                            if (!empty($max_dose)) {
                                                $dosage_count = $max_dose;
                                             } else{
                                                $dosage_count = 0;
                                             }
                                            
                                            for ($x = 1; $x <= $dosage_count; $x++) { ?>
                                              
                                              <th class="sticky-col" width="150"><?php echo $this->lang->line("dose").''.$x  ;?></th>
                                           <?php }
                                            ?> 
                                    </thead>
                                    <tbody> 
                                        <?php 
                                         $count = 1;
                                    foreach ($medication as $medication_key => $medication_value){
                                        
                                    $pharmacy_id = $medication_value['pharmacy_id'];
                                    $medicine_category_id = $medication_value['medicine_category_id'];
                                    $date = $medication_value['date']; ?>
                                    <tr>
                                        <?php $subcount = 1; foreach ($medication_value['dosage'][$date] as $mkey => $mvalue) { 
                                        $date = $this->customlib->YYYYMMDDTodateFormat($medication_value['date']);
                                            ?>
                                            <td class="hard_left"><?php if($subcount==1){ echo $date."<br>(".date('l', strtotime($medication_value['date'])).")"; }else{
                                                echo "<span class='fa-level-span'><i class='fa fa-level-up fa-level-roated' aria-hidden='true'></i></span>";
                                            } ?></td>
                                          <td class="next_left"><?php echo $mvalue['name'] ?></td>  
                                          <?php 
                                          for ($x = 0; $x <= $dosage_count; $x++){
                                            if (array_key_exists($x,$mvalue['dose_list']))
                                                  {
                                                    $medicine_id = $mvalue['dose_list'][$x]['pharmacy_id'];
                                                    $medicine_category_id = $mvalue['dose_list'][$x]['medicine_category_id'];
                                                    $add_index=$x;
                                                    if ($this->rbac->hasPrivilege('opd_medication', 'can_edit')) { 
                                                        $medication_edit = "<a href='#' class='btn btn-default btn-xs' data-toggle='tooltip' data-original-title='".$this->lang->line('edit')."' onclick='medicationDoseModal(" .$mvalue['dose_list'][$x]['id'].")'><i class='fa fa-pencil'></i></a>"; 
                                                    }else{
                                                        $medication_edit = "";
                                                    }
                                                    
                                                    if ($this->rbac->hasPrivilege('opd_medication', 'can_delete')) { 
                                                        $medication_delete = "<a  class='btn btn-default btn-xs delete_record_dosage' data-toggle='tooltip' data-original-title='".$this->lang->line('delete')."' data-record-id='".$mvalue['dose_list'][$x]['id']."'><i class='fa fa-trash'></i></a>"; 
                                                    }else{
                                                        $medication_delete = "";
                                                    }                                  
                                                    
                                                  ?>
                                                   <td class="dosehover"><?php echo $this->lang->line('time').": ".date('h:i A',strtotime($mvalue['dose_list'][$x]['time']))."</a><span>".$medication_edit."</span><span>".$medication_delete."</span></br>". $mvalue['dose_list'][$x]['medicine_dosage']." ".$mvalue['dose_list'][$x]['unit']; if($mvalue['dose_list'][$x]['remark']!=''){ echo " <br>".$this->lang->line('remark').": ".$mvalue['dose_list'][$x]['remark'] ;}?></td>
                                                  <?php
                                                  }
                                                else
                                                  {
                                                  ?>
                                                  <td class="dosehover"> <?php 
                                                  if($add_index+1==$x){
                                                    ?>
                                                <?php if ($this->rbac->hasPrivilege('opd_medication', 'can_add')) {
                                                    if($is_discharge){
                                                 ?>
                                                    <a href="#" class="btn btn-sm btn-primary dropdown-toggle addmedication" onclick="medicationModal('<?php echo $medicine_category_id;?>','<?php echo $medicine_id ;?>','<?php echo $date;?>')" data-toggle='modal'><i class="fa fa-plus"></i>
                                                    
                                                    </a>
                                                <?php }} ?>
                                                    <?php
                                                  } 
                                                  ?></td>
                                                  <?php
                                                  }
                                            ?>
                                       
                                           
                                        
                                       <?php }   ?>
                                        
                                   
                                    </tr>
                                <?php $subcount++; }
                                          }  ?>

                                    </tbody>
                                    <?php }else{ ?>

                                        <tr>
                                            <td><div class="alert alert-danger"><?php echo $this->lang->line('no_record_found'); ?></div></td>
                                        </tr>

                                     <?php   } ?>
                                    </table>
                                  
                                </div> 
                            </div> 

                        <!-- -->
                        <div class="tab-pane" id="labinvestigation">
                            <div class="box-tab-header">
                                <h3 class="box-tab-title">
                                  <?php echo $this->lang->line('lab_investigation'); ?></h3>

                           
                        </div>    
                            <div class="download_label"><?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example" data-export-title="<?php echo $this->lang->line('lab_investigation'); ?>">
                                    <thead>
                                        <th><?php echo $this->lang->line('test_name'); ?></th>
                                         <th><?php echo $this->lang->line('lab'); ?></th>
                                        <th><?php echo $this->lang->line('sample_collected'); ?></th>
                                        <td><strong><?php echo $this->lang->line('expected_date'); ?></strong></td>
                                         <th><?php echo $this->lang->line('approved_by'); ?></th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody id="">
                                        <?php foreach($investigations as $row ){ ?>
                                            <tr>
                                            <td><?php echo $row['test_name']; ?><br/>
                                           <?php echo "(".$row['short_name'].")"; ?></td>
                                            <td><?php echo $this->lang->line($row['type']); ?></td>
                                            <td><label>
                                 <?php echo composeStaffNameByString($row['collection_specialist_staff_name'],$row['collection_specialist_staff_surname'],$row['collection_specialist_staff_employee_id']); ?>
                                 </label>
                                    
                                     <br/>
                                     <label for=""><?php if($row['type']=='pathology'){ echo $this->lang->line('pathology');  }else{ echo $this->lang->line('radiology');

                                     }  ?> : </label>
                                    
                                        <?php
                                   echo $row['test_center']; 
                                    ?>
                                    <br/>
                                     <?php echo $this->customlib->YYYYMMDDTodateFormat($row['collection_date']); ?></td>
                                       
                                       <td>
                                    <?php
                                    
                                    echo  $this->customlib->YYYYMMDDTodateFormat($row['reporting_date']); ?>
                                        
                                    </td>
                                    <td class="text-left">
                                         <label for=""><?php echo $this->lang->line('approved_by'); ?> : </label>
                                        <?php      
                                    echo composeStaffNameByString($row['approved_by_staff_name'],$row['approved_by_staff_surname'],$row['approved_by_staff_employee_id']);
                                     ?>
                                     <br/>
                                    <?php                                
                                    echo  $this->customlib->YYYYMMDDTodateFormat($row['parameter_update']);
                                     ?>                                         
                                    </td>
                                    <td class="text-right"><a href='javascript:void(0)'  data-loading-text='<i class="fa fa-reorder"></i>' data-record-id='<?php echo $row['report_id'];?>' data-type-id='<?php echo $row['type'];?>'  class='btn btn-default btn-xs view_report' data-toggle='tooltip' title='<?php echo $this->lang->line("show"); ?>'><i class='fa fa-reorder'></i></a></td>
                                    </tr>
                                     <?php } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>     

                       

                        <!-- Charges -->
                            <?php if ($this->rbac->hasPrivilege('opd_charges', 'can_view')) { ?>
                            <div class="tab-pane" id="charges">
                                <div class="box-tab-header">
                                  <h3 class="box-tab-title"><?php echo $this->lang->line('charges'); ?></h3>

                                <div class="box-tab-tools">
                                    <?php if ($this->rbac->hasPrivilege('opd_charges', 'can_add')) { 
                                        if($is_discharge){ ?>
                                        <a data-toggle="modal" onclick="holdModal('add_chargeModal')" class="btn btn-primary btn-sm addcharges"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_charges') ?></a>
                                        <?php }
                                    } ?>
                                </div>
                            </div>     
                               <div class="download_label"><?php echo composePatientName($result['patient_name'],$result['patient_id']) . " " . $this->lang->line('opd_details'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('name'); ?></th>
                                            <th><?php echo $this->lang->line('charge_type'); ?></th>
                                            <th><?php echo $this->lang->line('charge_category'); ?></th>
                                            <th><?php echo $this->lang->line('qty'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('standard_charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                            <th class="text-right"><?php echo $this->lang->line('tpa_charge') . ' (' . $currency_symbol . ')';?></th>
                                            <th class="text-right"><?php echo $this->lang->line('tax'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('applied_charge') . ' (' . $currency_symbol . ')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?></th>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action') ?></th>
                                        </thead>
                                        <tbody>
                                         <?php 
                                            $total = 0; 
                                            if (!empty($charges_detail)) {
                                                foreach ($charges_detail as $charges_key => $charges_value) {
                                                    $tax_amount = ($charges_value['apply_charge']*$charges_value['tax']/100) ;
                                                    $taxamount = amountFormat($tax_amount);
                                                    $total += $charges_value["amount"];
                                                ?>  
                                                    <tr>
                                                        <td><?php echo $this->customlib->YYYYMMDDHisTodateFormat($charges_value['date'],$this->customlib->getHospitalTimeFormat()); ?></td>
                                                        <td class="">
                                                            <?php echo $charges_value["name"]; ?>
                                                             <div class="bill_item_footer text-muted"><label><?php if($charges_value["note"] !=''){ echo $this->lang->line('charge_note').': ';} ?></label> <?php echo $charges_value["note"]; ?></div>
                                                        </td>
                                                        <td style="text-transform: capitalize;"><?php echo $charges_value["charge_type"] ?></td>
                                                        <td style="text-transform: capitalize;"><?php echo $charges_value["charge_category_name"] ?></td>
                                                        <td style="text-transform: capitalize;"><?php echo $charges_value['qty']." ".$charges_value["unit"]; ?></td>
                                                        <td class="text-right"><?php echo $charges_value["standard_charge"] ?></td>
                                                        <td class="text-right"><?php echo $charges_value["org_charge"] ?></td>
                                                        <td class="text-right"><?php echo "(".$charges_value["tax"]."%) ".$taxamount ;?></td>
                                                        <td class="text-right"><?php echo $charges_value["apply_charge"] ?></td>
                                                        <td class="text-right"><?php echo $charges_value["amount"] ?></td>
                                                        <td class="text-right"> 
    <a href="javascript:void(0);" class="btn btn-default btn-xs print_charge" data-toggle="tooltip" title="" data-loading-text="<?php echo $this->lang->line('please_wait') ;?>" data-record-id="<?php echo $charges_value['id']; ?>"  data-original-title="<?php echo $this->lang->line('print');?>">
    <i class="fa fa-print"></i>
    </a> 
     <?php 
    if($is_discharge){
        if ($this->rbac->hasPrivilege('opd_charges', 'can_edit')) { 
    ?>
    <a href='javascript:void(0);' class='btn btn-default btn-xs edit_charge' data-loading-text='<?php echo $this->lang->line('please_wait') ;?>' data-toggle='tooltip' data-record-id='<?php echo $charges_value['id']; ?>'  title="<?php echo  $this->lang->line('edit')?>"><i class='fa fa-pencil'></i></a>

                                                            <?php } } if ($this->rbac->hasPrivilege('opd_charges', 'can_delete')) {
                                                            if($is_discharge){ ?>
                                                              
                        <a href="javascript:void(0);" onclick="deleteOpdPatientCharge('<?php echo $charges_value['id']; ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>

                                                    <?php } }?>   
                                                        </td>
                                                       
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>  

                                        </tbody>

                                        <tr class="box box-solid total-bg">

                                            <td colspan='10' class="text-right"><?php echo $this->lang->line('total') . " : " . $currency_symbol . "" . amountFormat($total); ?> 
                                            <input type="hidden" id="charge_total" name="charge_total" value="<?php echo $total ?>">
                                            </td>
                                             <td></td>
                                            
                                        </tr>
                                    </table>
                                </div> 
                            </div>    
                            <!-- -->   
                            <!--payment -->
                            <?php } if ($this->rbac->hasPrivilege('opd_payment', 'can_view')) {
                                ?>
                            <div class="tab-pane" id="payment">
                                <div class="box-tab-header">
                                  <h3 class="box-tab-title"><?php echo $this->lang->line('payments'); ?></h3>

                                <?php
                                if ($this->rbac->hasPrivilege('opd_payment', 'can_add')) {
                                      if($is_discharge){ ?>
                                 

                                    <div class="box-tab-tools">
                                     
                                        <a href="#" class="btn btn-sm btn-primary dropdown-toggle addpayment"  data-toggle='modal'><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_payment'); ?></a>
                                    </div><!--./impbtnview-->
                                    <?php
                                    }
                                }
                                ?>
                            </div>    
                            <div class="download_label"><?php echo $this->lang->line('payments'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                        <th><?php echo $this->lang->line('transaction_id'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('note'); ?></th>
                                        <th><?php echo $this->lang->line('payment_mode'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('paid_amount') . " (" . $currency_symbol . ")"; ?></th>

                                        <th class="text-right noExport"><?php echo $this->lang->line('action') ?></th>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $total_payment = 0;
                                            if (!empty($payment_details)) {
                                                $total_payment = 0;
                                                foreach ($payment_details as $payment) {
                                                    if (!empty($payment['amount'])) {
                                                        $total_payment += $payment['amount'];

                                                    }
                                                    ?> 
                                                    <tr>
                                                        <td><?php echo $this->customlib->getSessionPrefixByType('transaction_id').$payment['id']; ?></td>
                                                        <td><?php echo $this->customlib->YYYYMMDDHisTodateFormat($payment['payment_date'],$this->customlib->getHospitalTimeFormat()); ?></td>
                                                        <td><?php echo $payment["note"] ?></td>
                                                         <td ><?php echo $this->lang->line(strtolower($payment["payment_mode"]))."<br>";

                                                        if($payment['payment_mode'] == "Cheque"){
                                                             if($payment['cheque_no']!=''){
                                       echo $this->lang->line('cheque_no') . ": ".$payment['cheque_no'];
                                      
                                    echo "<br>";
                                }
                                    if($payment['cheque_date']!='' && $payment['cheque_date']!='0000-00-00'){
                                       echo $this->lang->line('cheque_date') .": ".$this->customlib->YYYYMMDDTodateFormat($payment['cheque_date']);
                                   }
                                       

                                     }
                                                        ?>
                                                            

                                                        </td>
                                                        <td class="text-right"><?php echo $payment["amount"] ?></td>
                                                      
                                                        <td class="text-right">
            <?php         if ($payment['payment_mode'] == "Cheque" && $payment['attachment'] != "")  {
    ?>
    <a href='<?php echo site_url('admin/transaction/download/'.$payment['id']);?>' class='btn btn-default btn-xs'  title='<?php echo $this->lang->line('download'); ?>'><i class='fa fa-download'></i></a>
    <?php
}
         ?>

 <a href="javascript:void(0);" class="btn btn-default btn-xs print_trans" data-toggle="tooltip" title="" data-loading-text="<?php echo $this->lang->line('please_wait') ;?>" data-record-id="<?php echo $payment['id']; ?>"  data-original-title="<?php echo $this->lang->line('print') ;?>">
                                                                    <i class="fa fa-print"></i>
                                                                </a>  
                                                            <?php if (!empty($payment["document"])) { ?>
                                                                <a href="<?php echo base_url(); ?>admin/payment/download/<?php echo $payment["document"]; ?>"  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                                <?php } ?>

                                                            <a href="javascript:void(0);"  class="btn btn-default btn-xs editpayment" data-toggle="tooltip" title="" data-payment-amount="<?php echo $payment["amount"] ?>" data-record-id="<?php echo $payment['id']; ?>" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                                            <?php
                                                             if($is_discharge){ 
                                                            if ($this->rbac->hasPrivilege('opd_payment', 'can_delete')) { ?>
                                                                <a href="javascript:void(0);"onclick="deletePayment('<?php echo $payment['id']; ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>   
                                                    <?php } } ?>
                                                        </td>
                                                    </tr>

                                        <?php } }?> 
                                        </tbody>
                                                <tr class="box box-solid total-bg">
                                                    <td></td> 
                                                    <td></td> 
                                                    <td></td> 
                                                    <td></td> 
                                                     <td  class="text-right"><?php echo $this->lang->line('total') . " : " . $currency_symbol . "" . number_format((float)$total_payment, 2, '.', ''); ?>
                                                    </td> 
                                                        <td></td>
                                                </tr>
                                    </table>
                                </div> 
                            </div> 
                            <!-- -->
                                <?php } ?>
                        <div class="tab-pane" id="timeline">
                            <div class="box-tab-header">
                                <h3 class="box-tab-title"><?php echo $this->lang->line('timeline'); ?></h3>
                            <div class="box-tab-tools"> 
<?php if ($this->rbac->hasPrivilege('opd_timeline', 'can_add')) { 
      if($is_discharge){ ?>
                                    <a data-toggle="modal" onclick="holdModal('myTimelineModal')" class="btn btn-primary btn-sm addtimeline"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add_timeline'); ?></a> 
<?php }
} ?>
                            </div>
                        </div>    
                            <div class="timeline-header no-border">

                                <div id="timeline_list">
<?php
if (empty($timeline_list)) {
    ?>
                                        <br/>
                                        <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                        <?php } else {
                                            ?>
                                        <ul class="timeline timeline-inverse">

    <?php
    foreach ($timeline_list as $key => $value) {
        ?>      
                                                <li class="time-label">
                                                    <span class="bg-blue">    <?php
                                                echo  date($this->customlib->getHospitalDateFormat(true, false), strtotime($value['timeline_date'])); 
                                                ?></span>
                                                </li> 
                                                <li>
                                                    <i class="fa fa-list-alt bg-blue"></i>
                                                    <div class="timeline-item">
                                                    <?php if ($this->rbac->hasPrivilege('opd_timeline', 'can_edit')) { 
                                                    if($is_discharge){ 
                                                        if ($value['generated_users_type'] != 'patient'  ) {

                                                        ?>
                                                            <span class="time">
                                                                <a 
                                                                    onclick="editTimeline('<?php echo $value['id']; ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a> 
                                                            </span>   
                                                        <?php } } } ?>
                                                        <?php if ($this->rbac->hasPrivilege('opd_timeline', 'can_delete')) { 
                                                             if ($value['generated_users_type'] != 'patient') {
                                                                if($is_discharge){
                                                            ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" onclick="delete_timeline('<?php echo $value['id']; ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a></span>
                                                        <?php }} } ?>
        <?php if (!empty($value["document"])) { ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" href="<?php echo base_url() . "admin/timeline/download_patient_timeline/" . $value["id"] . "/" . $value["document"] ?>" data-original-title="<?php echo $this->lang->line('download'); ?>"><i class="fa fa-download"></i></a></span>
                                                            <?php } ?>
                                                        <h3 class="timeline-header text-aqua"> <?php echo $value['title']; ?> </h3>
                                                        <div class="timeline-body">
        <?php echo $value['description']; ?> 

                                                        </div>

                                                    </div>
                                                </li>
    <?php } ?> 
                                            <li><i class="fa fa-clock-o bg-gray"></i></li> 
<?php } ?>  

                                    </ul>
                                </div>

                            </div>

                        </div>  
                        <!-- -->

                        <div class="tab-pane" id="live_consult">
                            <div class="box-tab-header">
                                <h3 class="box-tab-title"><?php echo $this->lang->line('live_consultation'); ?></h3>
                            </div>    
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th><?php echo $this->lang->line('consultation_title'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('created_by'); ?> </th>
                                        <th><?php echo $this->lang->line('created_for'); ?></th>
                                        <th><?php echo $this->lang->line('patient'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if (empty($visitconferences)) {
                                        ?>

                                        <?php
                                    } else {
                                        foreach ($visitconferences as $conference_key => $conference_value) {

                                            $return_response = json_decode($conference_value->return_response);
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $conference_value->title; ?></a>

                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($conference_value->description == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $conference_value->description; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>

                                                <td class="mailbox-name">
                                                <?php echo date($this->customlib->getHospitalDateFormat(true, true), strtotime($conference_value->date))?>
                                          
                                                <td class="mailbox-name">

                                                    <?php
                                                    if ($conference_value->created_id == $logged_staff_id) {
                                                        echo $this->lang->line('self');
                                                    } else {
                                                        $name= ($conference_value->create_by_surname == "") ? $conference_value->create_by_name : $conference_value->create_by_name . " " . $conference_value->create_by_surname;
        echo  $name. " (".$conference_value->for_create_role_name." : ".$conference_value->for_create_employee_id.")";
                                                    }
                                                    ?></td>

                                                <td class="mailbox-name">
                                                    <?php

                                                          $name= ($conference_value->create_for_surname == "") ? $conference_value->create_for_name : $conference_value->create_for_name . " " . $conference_value->create_for_surname;
        echo  $name. " (".$conference_value->for_create_role_name." : ".$conference_value->for_create_employee_id.")";


                                                  
                                                    ?>
                                                </td>

                                                <td class="mailbox-name">
                                                     <?php

                                                          $name= ($conference_value->patient_name == "") ? $conference_value->patient_name : $conference_value->patient_name ;
        echo  $name. " (".$this->lang->line('patient')." : ".$conference_value->patientid.")";


                                                  
                                                    ?>

                                                </td>
                                              <td class="mailbox-name">
                                                <form class="chgstatus_form" method="POST" action="<?php echo site_url('admin/zoom_conference/changeconsultation')?>">
                                                    <input type="hidden" name="conference_id" value="<?php echo $conference_value->id;?>">
                                                 <select class="form-control chgstatus_dropdown" name="chg_status">
                                                     <option value="0" <?php if($conference_value->status==0) echo "selected='selected'" ?>><?php echo $this->lang->line('awaited'); ?></option>
                                                     <option value="1" <?php if($conference_value->status==1) echo "selected='selected'" ?>><?php echo $this->lang->line('cancelled'); ?> </option>
                                                     <option value="2" <?php if($conference_value->status==2) echo "selected='selected'" ?>><?php echo $this->lang->line('finished'); ?> </option>
                                                 </select>
                                                </form>
                                                </td>
                                                <td class="mailbox-date pull-right relative">
                                                    <?php 
                                                if($conference_value->status == 0){
                                                ?>
                                                <a href="<?php echo $return_response->start_url; ?>" class="btn btn-default btn-xs starsuccessbtn"  target="_blank" >
                                                <i class="fa fa-sign-in"></i> <?php echo $this->lang->line('start'); ?> 
                                                </a>
                                                <?php
                                                }
                                                     ?>
                                                    
                                                    <?php
                                                    if ($conference_value->api_type != 'self') {
                                                        ?>
                                                        <?php 
                                                        if($this->rbac->hasPrivilege('live_classes','can_delete')){
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>admin/zoom_conference/delete_consult/<?php echo $conference_value->id . "/" . $return_response->id; ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                            <?php
                                                        }
                                                        ?>
                                                        
                                                        <?php
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div> 
                        </div> 

                        <div class="tab-pane" id="prescription">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">                       
                                    <thead>
                                    <th><?php echo $this->lang->line('opd') . " " . $this->lang->line('id'); ?></th>
                                    <th><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('note'); ?></th>
                                    <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($prescription_detail)) {
                                            foreach ($prescription_detail as $prescription_key => $prescription_value) {

                                                ?>  
                                                <tr>
                                                    <td><?php echo $prescription_value["opd_id"] ?></td>
                                                    <td><?php echo $prescription_value["appointment_date"] ?></td>
                                                    <td><?php echo $prescription_value["note"] ?></td>
                                                    <th class="pull-right"><a href="#" data-toggle='tooltip' title="<?php echo $this->lang->line('test_report_detail'); ?>" onclick="view_prescription('<?php echo $prescription_value["opd_id"] ?>')"><i class="fa fa-reorder"></i></a></th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div> 


                        </div>  
                        <!-- -->
                    </div>

                </div>
                </form>

            </div>
    </section>
</div> 



<!--new edit modal-->
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <form id="formedit"  accept-charset="utf-8" enctype="multipart/form-data" method="post" class="ptt10">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title"> <?php echo $this->lang->line('edit_visit_details'); ?></h4>
            </div>   
                               
            </div><!--./modal-header-->
                     
            <div class="pup-scroll-area">                    
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row row-eq">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div id="ajax_load"></div>
                                        

                                        <div class="row">
                                            <div class="col-md-12"> 
                                                <div class="dividerhr"></div>
                                            </div><!--./col-md-12-->
                                             <input type="hidden" name="visitid" id="visitid" class="form-control" />
                                             <input type="hidden" name="visit_transaction_id" id="visit_transaction_id" class="form-control" />
                                            <input type="hidden" name="type" id="type" value="visit" class="form-control" />
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('height'); ?></label> 
                                                    <input id="edit_height" name="height" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('weight'); ?></label> 
                                                    <input id="edit_weight" name="weight" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('bp'); ?></label> 
                                                    <input name="bp" type="text" name="bp" class="form-control" id="edit_bp"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('pulse'); ?></label> 
                                                    <input id="edit_pulse" name="pulse" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('temperature'); ?></label> 
                                                    <input id="edit_temperature" name="temperature" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('respiration'); ?></label> 
                                                    <input name="respiration" class="form-control" id="edit_respiration" type="text" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                 <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('symptoms_type'); ?></label>
                                                    <div><select  name='symptoms_type'  id="act"  class="form-control select2 act"  style="width:100%" >
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php foreach ($symptomsresulttype as $dkey => $dvalue) {
                                                                ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["symptoms_type"] ;?></option>

                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('symptoms_type'); ?></span>
                                                </div>
                                            </div>                                            
                                             <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exampleInputFile"> 
                                                        <?php echo $this->lang->line('symptoms') ; ?></label>
                                                    <div id="dd" class="wrapper-dropdown-3">
                                                        <input class="form-control filterinput" type="text">
                                                        <ul class="dropdown scroll150 section_ul">
                                                            <li><label class="checkbox"><?php echo $this->lang->line('select'); ?></label></li>
                                                        </ul>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('symptoms_description'); ?></label>
                                                    <textarea class="form-control" id="symptoms_description" name="symptoms" ></textarea> 
                                                </div> 
                                            </div>                                        
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                                    <textarea  rows="3" class="form-control" id="edit_revisit_note" name="revisit_note" ></textarea>
                                                </div> 
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label>
                                                    <textarea name="known_allergies"  rows="3" id="eknown_allergies" placeholder="" class="form-control"><?php echo set_value('address'); ?></textarea>
                                                </div> 
                                            </div>
                                            <div class="row">
                                             <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <div id="customfield" ></div>
                                                </div>
                                            </div>
                                        </div>      
                                        </div><!--./row--> 

                                    </div><!--./col-md-8--> 
<?php 
$role_array = $this->session->userdata['hospitaladmin']['roles'];
$role = array_values($role_array)[0];
 ?>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-eq ptt10 edit-visite-details-role-<?= $role ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('appointment_date'); ?></label>
                                                    <small class="req"> *</small>
                                                    <input  name="appointment_date" class="form-control datetime" id="appointmentdate"  placeholder="" type="text" class="form-control datetime" />
                                                    <span class="text-danger"><?php echo form_error('appointment_date'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('case'); ?></label>
                                                    <div><input class="form-control" type='text' name="case" id="edit_case"  />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('casualty'); ?></label>
                                                    <div>
                                                    <select name="casualty" id="edit_casualty" class="form-control">
                                                        <?php foreach ($yesno_condition as $yesno_key => $yesno_value) {
                                                            ?>
                                                            <option value="<?php echo $yesno_key ?>" <?php
                                                                    if ($yesno_key == 'no') {
                                                                        echo "selected";
                                                                    }
                                                                    ?> ><?php echo $yesno_value ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>
                                                        
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('old_patient'); ?></label>
                                                    <div>
                                                        <select name="old_patient" id="edit_oldpatient" class="form-control">
                                                            <?php foreach ($yesno_condition as $yesno_key => $yesno_value) { ?>
                                                                <option value="<?php echo $yesno_key ?>"  ><?php echo $yesno_value ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                            <?php echo $this->lang->line('tpa'); ?></label>
                                                    <div><select class="form-control" onchange="get_Charges(this.value)" id="edit_organisation" name='organisation' >
                                                            <option value="0"><?php echo $this->lang->line('select'); ?></option>
                                                            <?php foreach ($organisation as $orgkey => $orgvalue) {
                                                                ?>
                                                                <option value="<?php echo $orgvalue["id"]; ?>"><?php echo $orgvalue["organisation_name"] ?></option>   
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                            </div>  

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('reference'); ?></label>
                                                    <div><input type="text" name="refference" class="form-control" id="edit_refference" />  
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                   <label><?php echo $this->lang->line('consultant_doctor'); ?></label><small class="req"> *</small> 
                                                        <select  onchange="" name="consultant_doctor" <?php
                                                            if ($disable_option == true) {
                                                                echo "disabled";
                                                            }
                                                            ?> style="width:100%" class="form-control select2" id="edit_consdoctor">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>

                                                            <?php foreach ($doctors as $dkey => $dvvalue) { ?>
                                                                <option value="<?php echo $dvvalue["id"] ?>"><?php echo composeStaffNameByString($dvvalue["name"] , $dvvalue["surname"],$dvvalue["employee_id"]); ?></option>
                                                            <?php } ?>
                                                        </select>   
                                                        <?php if ($disable_option == true) { ?>
                                                            <input type="hidden" name="consultant_doctor"  value="<?php echo $doctor_select ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                           

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                   <label><?php echo $this->lang->line('payment_date'); ?></label><small class="req"> *</small> 
                                        
                                            <input type="text" name="payment_date" id="edit_visit_payment_date" class="form-control datetime" autocomplete="off">
                                             <input type="hidden" class="form-control" id="edit_visit_payment_id" name="edit_payment_id" >
                                            <span class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('amount'). " (" . $currency_symbol . ")" ?></label><small class="req"> *</small> <input type="text" name="amount" id="edit_visit_payment" class="form-control" value="">   
                                                    
                                                </div>
                                                </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('payment_mode'); ?></label>
                                                        <select class="form-control visit_payment_mode" name="payment_mode" id="visit_payment_mode">

                                                            <?php foreach ($payment_mode as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $key ?>" <?php
                                                                if ($key == 'cash') {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $value ?></option>
                                                            <?php } ?>
                                                    </select>    
                                                </div>
                                           </div>
                                       <!--  <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('paid_amount') . " (" . $currency_symbol . ")" ; ?></label><small class="req"> *</small> 
                                                <input type="text" name="paid_amount" id="paid_amount" class="form-control">    
                                                <span class="text-danger"><?php echo form_error('paid_amount'); ?></span>
                                            </div>
                                        </div> -->
                                        <div class="cheque_div" style="display: none;">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req"> *</small> 
                                                    <input type="text" name="cheque_no" id="edit_visit_cheque_no" class="form-control">
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('cheque_date'); ?></label><small class="req"> *</small> 
                                                    <input type="text" name="cheque_date" id="edit_visit_cheque_date" class="form-control date">
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('attach_document'); ?></label>
                                                    <input type="file" class="filestyle form-control"   name="document">
                                                    <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('payment_note'); ?></label> 
                                                <input type="text" name="note" id="edit_visit_payment_note" class="form-control"/>
                                            </div>
                                        </div>
                                        </div><!--./row-->    
                                    </div><!--./col-md-4-->
                                </div><!--./row-->        
                        </div><!--./col-md-12-->       
                    </div><!--./row--> 
                </div>
            </div>  

                <div class="box-footer sticky-footer">
                    <div class="pull-right">
                    <button type="submit" id="formeditbtn" name="save" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle" ></i> <span><?php echo $this->lang->line('save'); ?></span></button>
                    </div>
                </div>
            </form>                
        </div>
    </div>    
</div>


<!-- end new added modal-->


<!-- Add Charges -->
<div class="modal fade" id="edit_chargeModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_charge'); ?></h4> 
            </div>
             <form id="edit_charges" accept-charset="utf-8"  method="post" class="ptt10">
            <div class="scroll-area">
                <div class="modal-body pt0">
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                           
                            <input type="hidden" name="opd_id" value="<?php echo $result['id'] ?>" >
                            <input type="hidden" name="patient_charge_id" id="editpatient_charge_id" value="0">
                            <input type="hidden" name="organisation_id" id="editorganisation_id" value="<?php echo $visitdata['organisation_id'] ?>" >
                                
                                <div class="row">
                                    
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_type'); ?></label><small class="req"> *</small> 

                                            <select name="charge_type" id="editcharge_type" class="form-control editcharge_type select2" style="width:100%">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php foreach ($charge_type as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value->id; ?>">
                                                    <?php echo $value->charge_type; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_category'); ?></label><small class="req"> *</small> 

                                            <select name="charge_category" id="editcharge_category" style="width: 100%" class="form-control select2 editcharge_category" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_name'); ?></label><small class="req"> *</small>
                                                <select name="charge_id" id="editcharge_id" style="width: 100%" class="form-control editcharge select2 " >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('code'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('standard_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="standard_charge" id="editstandard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 
                                        
                                            <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                        </div>
                                    </div>
                            
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('tpa_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="schedule_charge" id="editscd_charge" placeholder="" class="form-control" value="<?php echo set_value('schedule_charge'); ?>">    
                                            <span class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('qty'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="qty" id="editqty" class="form-control" value="1"> 
                                            <span class="text-danger"><?php echo form_error('qty'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            
                                    <div class="divider"></div>

                                        <div class="row">
                                            <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label> <small class="req"> *</small> 
                                            
                                            <input id="editcharge_date" name="date" placeholder="" type="text" class="form-control datetime" />
                                        </div>
                                    </div>
                                            <div class="col-sm-3">
                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line('charge_note'); ?></label>
                                                            <textarea name="note" id="edit_note" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--./col-sm-6-->


                                            <div class="col-sm-6">

                                                <table class="printablea4">


                                                    <tr>
                                                        <th width="40%"><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th>
                                                        <td width="60%" colspan="2" class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Total" value="0" name="apply_charge" id="editapply_charge" style="width: 30%; float: right" class="form-control total" readonly /></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th>
                                                        <td class="text-right ipdbilltable">
                                                            <h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4>
                                                    <input type="text" placeholder="<?php echo $this->lang->line('tax'); ?>" name="charge_tax" id="editcharge_tax" class="form-control charge_tax" readonly style="width: 70%; float: right;font-size: 12px;"/></td>

                                                        <td class="text-right ipdbilltable">
                                                            <input type="text" placeholder="<?php echo $this->lang->line('tax'); ?>" name="tax" value="0" id="edittax" style="width: 50%; float: right" class="form-control tax" readonly/>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?></th>
                                                        <td colspan="2" class="text-right ipdbilltable">
                                                            <input type="text" placeholder="Net Amount" value="0" name="amount" id="editfinal_amount" style="width: 30%; float: right" class="form-control net_amount" readonly/></td>
                                                    </tr>
                                                </table>


                                            </div>

                                        </div><!--./row-->
                        </div>

                    </div>
                </div>

            </div> <!-- scroll-area -->
               <div class="modal-footer"> 

                <button type="submit"  data-loading-text="<?php echo $this->lang->line('processing') ?>"  name="charge_data" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save') ?></button>

            </div> 
            </form>                        
           
        </div>
    </div>  
     
</div>
<div class="modal fade" id="add_chargeModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100  " role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_charges'); ?></h4> 
            </div>
            <form id="add_charges" accept-charset="utf-8"  method="post" class="ptt10">
                <div class="pup-scroll-area">
                    <div class="modal-body pt0">                    
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">                           
                                <input type="hidden" name="opd_id" value="<?php echo $result['id'] ?>" >
                                <input type="hidden" name="patient_charge_id" id="patient_charge_id" value="0">
                                <input type="hidden" name="organisation_id" id="organisation_id" value="<?php echo $visitdata['organisation_id'] ?>" >                                
                                <div class="row">                                    
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="displayblock"><?php echo $this->lang->line('charge_type'); ?><small class="req"> *</small></label>     
                                            <select name="charge_type" id="add_charge_type" class="form-control charge_type select2" style="width: 100%">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php foreach ($charge_type as $key => $value) { ?>
                                                <option value="<?php echo $value->id; ?>">
                                                <?php echo $value->charge_type; ?>
                                                </option>
                                                <?php } ?>
                                            </select>                                                
                                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_category'); ?></label><small class="req"> *</small> 
                                            <select name="charge_category" id="charge_category" style="width: 100%" class="form-control select2 charge_category" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_name'); ?></label><small class="req"> *</small>
                                                <select name="charge_id" id="charge_id" style="width: 100%" class="form-control addcharge select2 " >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                </select>
                                            <span class="text-danger"><?php echo form_error('code'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('standard_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="standard_charge" id="addstandard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>">                                        
                                            <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                        </div>
                                    </div>                            
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('tpa_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="schedule_charge" id="addscd_charge" placeholder="" class="form-control" value="<?php echo set_value('schedule_charge'); ?>">    
                                            <span class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('qty'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="qty" id="qty" class="form-control" value="1"> 
                                            <span class="text-danger"><?php echo form_error('qty'); ?></span>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="divider"></div>
                                    <div class="row">                                            
                                        <div class="col-sm-5">
                                            <table class="printablea4">
                                                <tr>
                                                    <th width="40%"><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td width="60%" colspan="2" class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Total" value="0" name="apply_charge" id="apply_charge" style="width: 30%; float: right" class="form-control total" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable"><h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4>
                                                    <input type="text" placeholder="<?php echo $this->lang->line('tax'); ?>" name="charge_tax" id="charge_tax" class="form-control charge_tax" readonly style="width: 70%; float: right;font-size: 12px;"/></td>
                                                    <td class="text-right ipdbilltable"><input type="text" placeholder="<?php echo $this->lang->line('tax'); ?>" name="tax" value="0" id="tax" style="width: 50%; float: right" class="form-control tax" readonly/></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td colspan="2" class="text-right ipdbilltable"><input type="text" placeholder="Net Amount" value="0" name="amount" id="final_amount" style="width: 30%; float: right" class="form-control net_amount" readonly/></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('charge_note'); ?></label>
                                                        <textarea name="note" id="edit_note" rows="3" class="form-control edit_charge_note"  ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--./col-sm-6-->
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('date'); ?></label> <small class="req"> *</small>                                            
                                                <input id="charge_date" name="date" placeholder="" type="text" class="form-control datetime" />
                                            </div>
                                            <button type="submit"  data-loading-text="<?php echo $this->lang->line('processing') ?>" name="charge_data" value="add" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('add') ?></button>
                                        </div>                                   
                                    </div><!--./row-->
                                    <hr>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12" class="table-responsive ptt10">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th><?php echo $this->lang->line('date')?></th>
                                            <th><?php echo $this->lang->line('charge_type')?></th>
                                            <th><?php echo $this->lang->line('charge_category')?></th>
                                            <th><?php echo $this->lang->line('charge_name')?></th>
                                            <th class="text-right"><?php echo $this->lang->line('standard_charge').' ('. $currency_symbol .')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('tpa_charge').' ('. $currency_symbol .')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('qty')?></th>
                                            <th class="text-right"><?php echo $this->lang->line('total').' ('. $currency_symbol .')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('tax').' ('. $currency_symbol .')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('net_amount').' ('. $currency_symbol .')'; ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('action')?></th>
                                        </tr>
                                        <tbody id="preview_charges">                                 
                                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- scroll-area -->
                    <div class="modal-footer sticky-footer"> 
                        <div class="pull-right">                        
                            <button type="submit"  data-loading-text="<?php echo $this->lang->line('processing') ?>" value="save" name="charge_data" class="btn btn-info"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save') ?></button>
                        </div>
                    </div> 
                </form>   
        </div>
    </div>     
</div>
<!-- -->

<!-- Add Diagnosis -->
<div class="modal fade" id="add_operationtheatre" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_button" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_operation"); ?></h4> 
            </div>
            <div class="scroll-area"> 
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="form_operationtheatre"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                                <div class="row">
                                      <input type="hidden" value="<?php echo $opdid ?>" name="opdid" class="form-control" id="opdid" /> 
                                      <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_category'); ?></label><small class="req"> *</small>
                                                <select name="operation_category" id="operation_category" class="form-control select2" onchange="getcategory(this.value)" style="width:100%">
                                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                                    <?php foreach($categorylist as $operation){ ?>
                                                    <option value="<?php echo $operation['id']; ?>"><?php echo $operation['category']; ?></option>
                                                <?php } ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('operation_category'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_name'); ?></label>
                                                <small class="req"> *</small> 
                                                <div>
                                                    <select name="operation_name" id="operation_name" class="form-control select2 " style="width:100%">
                                                </select>
                                                </div>
                                                
                                                <span class="text-danger"><?php echo form_error('operation_name'); ?></span>
                                            </div>
                                        </div>

                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_date'); ?></label>
                                                <small class="req"> *</small> 
                                                <input type="text" value="<?php //echo set_value('email');     ?>" id="date" name="date" class="form-control datetime">
                                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('consultant_doctor'); ?></label>
                                                <small class="req"> *</small> 
                                                <div><select class="form-control select2"  <?php
                                                    if ($disable_option == true) {
                                                        echo "disabled";
                                                    }
                                                    ?> style="width:100%" id='consultant_doctorid' name='consultant_doctor' >
                                                        <option value="<?php echo set_value('consultant_doctor'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                        <?php foreach ($doctors as $dkey => $dvalue) {
                                                            ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                    if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo composeStaffNameByString($dvalue["name"] , $dvalue["surname"],$dvalue["employee_id"]); ?></option>   
                                                                    <?php } ?>
                                                    </select>
                                                    <input type="hidden" id="consultant_doctorname" name="consultant_doctor">
                                                </div>
                                                <span class="text-danger"><?php echo form_error('consultant_doctor'); ?></span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('assistant_consultant') . " " . '1'; ?></label>
                                                <input type="text" name="ass_consultant_1" class="form-control">                     
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('assistant_consultant') . " " . '2'; ?></label>
                                                <input type="text" name="ass_consultant_2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('anesthetist'); ?></label>
                                                <input type="text" name="anesthetist" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('anesthesia_type'); ?></label>
                                                <input type="text" name="anaethesia_type" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('ot_technician'); ?></label>
                                                <input type="text" name="ot_technician" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('ot_assistant'); ?></label>
                                                <input type="text" value="<?php //echo set_value('email');     ?>" name="ot_assistant" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('remark'); ?></label>
                                                <textarea name="ot_remark" id="ot_remark" class="form-control" ></textarea> 
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('result'); ?></label>
                                                <textarea name="ot_result" id="ot_result" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="">
                                            <?php echo display_custom_fields('operationtheatre'); ?>
                                        </div>

                                      
                                </div>
                        </div>
                    </div>
                </div>    
            </div> <!-- scroll-area -->
            <div class="modal-footer">
                    <div class="pull-right">
                    <button type="submit" id="form_operationtheatrebtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>
                </div>
            </form>
        </div>
    </div> 
</div>


<!-- Edit Operation Theatre -->

<div class="modal fade" id="edit_operationtheatre"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("edit_operation"); ?></h4> 
            </div>
            <div class="scroll-area"> 
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="form_editoperationtheatre" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="ptt10">
                                <div class="row">
                                      <input type="hidden" value="<?php echo $opdid ?>" name="opdid" class="form-control" id="opdid" /> 
                                    <input type="hidden" value="" name="otid" class="form-control" id="otid" /> 
                                     

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_category'); ?></label>
                                                   <small class="req"> *</small>
                                                <select name="eoperation_category" id="eoperation_category" class="form-control select2" onchange="getcategory(this.value)" style="width:100%">
                                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                                    <?php foreach($categorylist as $operation){ ?>
                                                    <option value="<?php echo $operation['id']; ?>"><?php echo $operation['category']; ?></option>
                                                <?php } ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('operation_category'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_name'); ?></label>
                                                <small class="req"> *</small> 

                                                <div>
                                                    <select name="eoperation_name" id="eoperation_name" class="form-control select2" style="width:100%" >
                                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                                    <?php foreach($operationlist as $operation){ ?>
                                                    <option value="<?php echo $operation['id']; ?>"><?php echo $operation['operation']; ?></option>
                                                <?php } ?>
                                                </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('operation_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('operation_date'); ?></label>
                                                <small class="req"> *</small> 
                                                <input type="text" value="" id="edate" name="date" class="form-control datetime">
                                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('consultant_doctor'); ?></label>  <small class="req"> *</small> 
                                                <div>
                                                    <select class="form-control select2"  <?php
                                                    if ($disable_option == true) {
                                                        echo "disabled";
                                                    }
                                                    ?> style="width:100%" id='econsultant_doctorid' name='consultant_doctor' >
                                                        <option value="<?php echo set_value('consultant_doctor'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                        <?php foreach ($doctors as $dkey => $dvalue) {
                                                            ?>
                                            <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                    if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo composeStaffNameByString($dvalue["name"] , $dvalue["surname"],$dvalue["employee_id"]); ?></option>   
                                                                    <?php } ?>
                                                    </select>
                                                    <input type="hidden" id="econsultant_doctorname" name="consultant_doctor">
                                                </div>
                                                <span class="text-danger"><?php echo form_error('consultant_doctor'); ?></span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('assistant_consultant') . " " . '1'; ?></label>
                                                <input type="text" name="ass_consultant_1" id="eass_consultant_1" class="form-control">                     
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('assistant_consultant') . " " . '2'; ?></label>
                                                <input type="text" name="ass_consultant_2"  id="eass_consultant_2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('anesthetist'); ?></label>
                                                <input type="text" name="anesthetist" id="eanesthetist" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('anesthesia_type'); ?></label>
                                                <input type="text" name="anaethesia_type" id="eanaethesia_type" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('ot_technician'); ?></label>
                                                <input type="text" name="ot_technician" id="eot_technician" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('ot_assistant'); ?></label>
                                                <input type="text" value="" name="ot_assistant"  id="eot_assistant"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('remark'); ?></label>
                                                <textarea name="eot_remark" id="eot_remark" class="form-control" ></textarea> 
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('result'); ?></label>
                                                <textarea name="eot_result" id="eot_result" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div id="custom_fields_ot">
                                            
                                        </div>                                       
                                </div>
                        </div>
                    </div>
                </div>    
            </div> <!-- scroll-area -->
            <div class="modal-footer">
                    <div class="pull-right">
                    <button type="submit" id="form_editoperationtheatrebtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>
                </div>
            </form>
        </div>
    </div> 
</div>

<div class="modal fade" id="myaddMedicationModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_medication_dose"); ?></h4> 
            </div>
                <form id="add_medication" accept-charset="utf-8" method="post" class="ptt10">
                    <div class="modal-body pt0 pb0">
                                <div class="row">
                                     <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                            <input type="text" name="date" id="date" class="form-control date">
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                        <input type="hidden" name="opdid" value="<?php echo $opdid ?>" >
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line("time"); ?></label><small class="req"> *</small>
                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" name="time" class="form-control timepicker" id="mtime" value="<?php echo set_value('time'); ?>">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('time'); ?></span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                       
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("medicine_category"); ?></label><small class="req"> *</small>
                                            <select class="form-control medicine_category_medication select2" style="width:100%" id="mmedicine_category_id" name='medicine_category_id'>
                                                <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                </option>
                                                    <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                    </option>
                                                            <?php }?>
                                                </select>   
                                            <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                        </div>
                                    </div> 
                                     <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("medicine_name"); ?></label><small class="req"> *</small> 
                                        <select class="form-control select2 medicine_name_medication" style="width:100%"  id="mmedicine_id" name='medicine_name_id'>
                                                <option value=""><?php echo $this->lang->line('select') ?>
                                                    </option>
                                                </select>
                                            <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                                        </div>
                                    </div> 
                                     <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("dosage"); ?></label><small class="req"> *</small> 
                                        <select class="form-control select2 dosage_medication" style="width:100%"  id="dosage" onchange="get_dosagename(this.value)" name='dosage'>
                                                <option value=""><?php echo $this->lang->line('select') ?>
                                                    </option>
                                                </select>
                                            <span class="text-danger"><?php echo form_error('dosage'); ?></span>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("remarks"); ?></label> 
                                            <textarea  name="remark" id="remark" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                </div>
            
            <div class="modal-footer">
                        <button type="submit" id="add_medicationbtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                    </div>  
            </form>
        </div>
    </div> 
</div>
<!-- -->
<!-- -->
<div class="modal fade" id="myMedicationModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_medication_dose"); ?></h4>
            </div>
            <form id="add_medicationdose" accept-charset="utf-8" method="post" class="ptt10">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                <input type="text" name="date" id="add_dose_date" class="form-control date">
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                                <input type="hidden" name="opdid" value="<?php echo $opdid ?>" >
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pwd"><?php echo $this->lang->line("time"); ?></label><small class="req"> *</small> 
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="time" class="form-control timepicker" id="add_dose_time" value="<?php echo set_value('time'); ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('time'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("medicine_category"); ?></label><small class="req"> *</small>
                                <select class="form-control medicine_category_medication select2" style="width:100%" id="add_dose_medicine_category" name='medicine_category_id'>
                                    <option value=""><?php echo $this->lang->line('select') ?>
                                    </option>
                                        <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                        ?>
                                        <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                        </option>
                                                <?php }?>
                                    </select>   
                                <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("medicine_name"); ?></label><small class="req"> *</small> 
                            <select class="form-control select2 medicine_name_medication" style="width:100%"  id="add_dose_medicine_id" name='medicine_name_id'>
                                    <option value=""><?php echo $this->lang->line('select') ?>
                                        </option>
                                    </select>
                                <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("dosage"); ?></label> <small class="req"> *</small> 
                            <select class="form-control select2 dosage_medication" style="width:100%"  id="mdosage" onchange="" name='dosage'>
                                    <option value=""><?php echo $this->lang->line('select'); ?>
                                        </option>
                                    </select>
                                <span class="text-danger"><?php echo form_error('dosage'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("remarks"); ?></label> 
                                <textarea  name="remark" id="remark" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="add_medicationdosebtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>  
            </form>  
        </div>
    </div> 
</div>
<!-- -->
<!-- -->
<div class="modal fade" id="myMedicationDoseModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modalicon"> 
                    <?php if ($this->rbac->hasPrivilege('opd_medication', 'can_delete')) { ?>
                        <div id='edit_delete_medication'></div>
                    <?php } ?>
                    </div>   
                <h4 class="modal-title"><?php echo  $this->lang->line("edit_medication_dose"); ?></h4> 
            </div>
            <form id="update_medication" accept-charset="utf-8" method="post" class="ptt10">
                   <div class="modal-body pt0 pb0">
                        <input type="hidden" name="medication_id" id="medication_id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="date" id="date_edit_medication" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    <input type="hidden" name="opdid" value="<?php echo $opdid ?>" >
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line("time"); ?></label><small class="req"> *</small>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="time" class="form-control timepicker" id="dosagetime" value="<?php echo set_value('time'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <span class="text-danger"><?php echo form_error('time'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("medicine_category"); ?></label><small class="req"> *</small>
                                        <select class="form-control medicine_category_medication select2" style="width:100%" id="mmedicine_category_edit_id" name='medicine_category_id'>
                                            <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                            </option>
                                                <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                ?>
                                                <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                </option>
                                                        <?php }?>
                                            </select>   
                                        <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("medicine_name"); ?></label><small class="req"> *</small> 
                                    <select class="form-control select2 medicine_name_medication" style="width:100%"  id="mmedicine_edit_id" name='medicine_name_id'>
                                            <option value=""><?php echo $this->lang->line('select') ?>
                                                </option>
                                            </select>
                                        <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("dosage"); ?></label><small class="req"> *</small>
                                        <select class="form-control  select2" style="width:100%" id="medicine_dose_edit_id" name='dosage_id'>
                                        <option value="<?php echo set_value('dosage_id'); ?>"><?php echo $this->lang->line('select'); ?>
                                        </option>
                                        <?php foreach ($dosage as $key => $value) { ?>
                                        <option value="<?php echo $value["id"]; ?>"><?php echo $value["dosage"]." ".$value['unit'] ; ?>
                                                </option>
                                        
                                        <?php } ?>
                                        </select>   
                                        <span class="text-danger"><?php echo form_error('dosage_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("remarks"); ?></label> 
                                        <textarea  name="remark" id="medicine_dosage_remark" class="form-control"></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>        
 
                        <div class="modal-footer">
                            <button type="submit" id="update_medicationbtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                        </div>  
 
                </form>
        </div>
    </div> 
</div>
<!-- -->


<!--lab investigation modal-->
<div class="modal fade" id="viewDetailReportModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='action_detail_report_modal'>

                   </div>
                </div>
                <h4 class="modal-title" id="modal_head"></h4> 
            </div>
            <div class="modal-body ptt10 pb0">
                <div id="reportbilldata"></div>
            </div>
        </div>
    </div>    
</div>
<!-- end lab investigation modal-->


<!-- Timeline -->
<div class="modal fade" id="myTimelineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_timeline'); ?></h4> 
            </div>
            <div class="scroll-area">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="add_timeline" accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                                <div class="row">
                                    <div class=" col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('title'); ?></label><small class="req"> *</small>
                                            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $id ?>">
                                            <input id="timeline_title" name="timeline_title" placeholder="" type="text" class="form-control"  />
                                            <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                            <input id="timeline_date" name="timeline_date" value="<?php echo set_value('timeline_date', date($this->customlib->getHospitalDateFormat())); ?>" placeholder="" type="text" class="form-control date"  />
                                            <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('description'); ?></label>
                                            <textarea id="timeline_desc" name="timeline_desc" placeholder=""  class="form-control"></textarea>
                                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('attach_document'); ?></label>
                                            <div><input id="timeline_doc_id" name="timeline_doc" placeholder="" type="file"  class="filestyle form-control" data-height="40"  value="<?php echo set_value('timeline_doc'); ?>" />
                                                <span class="text-danger"><?php echo form_error('timeline_doc'); ?></span></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="vertical-align-middle"><?php echo $this->lang->line('visible_to_this_person'); ?></label>
                                            <input id="visible_check" checked="checked" name="visible_check" value="yes" placeholder="" type="checkbox" />

                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="add_timelinebtn" class="btn btn-info"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>

                </div>
                </form>
            </div>
        </div>
    </div> 
</div>

<!-- -->

<!-- Edit Timeline -->
<div class="modal fade" id="myTimelineEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_timeline'); ?></h4> 
            </div>
            <div class="scroll-area">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="edit_timeline"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                                <div class="row">


                                    <div class=" col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('title'); ?></label><small class="req"> *</small>
                                            <input type="hidden" name="patient_id" id="epatientid" value="">
                                            <input type="hidden" name="timeline_id" id="etimelineid" value="">
                                            <input id="etimelinetitle" name="timeline_title" placeholder="" type="text" class="form-control"  />
                                            <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                        <!-- <input id="etimelinedate" name="timeline_date" value="<?php echo set_value('timeline_date', date($this->customlib->getHospitalDateFormat())); ?>" placeholder="" type="text" class="form-control date"  />-->
                                            <input type="text" name="timeline_date" class="form-control date" id="etimelinedate"/>
                                            <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('description'); ?></label>
                                            <textarea id="timelineedesc" name="timeline_desc" placeholder=""  class="form-control"></textarea>
                                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('attach_document'); ?></label>
                                            <div><input id="etimeline_doc_id" name="timeline_doc" placeholder="" type="file"  class="filestyle form-control" data-height="40"  value="<?php echo set_value('timeline_doc'); ?>" />
                                                <span class="text-danger"><?php echo form_error('timeline_doc'); ?></span></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="vertical-align-middle"><?php echo $this->lang->line('visible_to_this_person'); ?></label>
                                            <input id="evisible_check"  name="visible_check" value="yes" placeholder="" type="checkbox" />

                                        </div>
                                    </div>


                                </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="edit_timelinebtn" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div> 
</div>

<div class="modal fade" id="edit_prescription"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('prescription'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0" id="editdetails_prescription">
            </div>    

        </div>
    </div> 
</div>
 
<div class="modal fade" id="add_prescription" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form_prescription" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="">
                <div class="pup-scroll-area"> 
                    <div class="modal-body pt0 pb0">

                    </div><!--./modal-body-->
                </div>    
                <div class="modal-footer sticky-footer">
                    <div class="pull-right">
                         <button type="submit" name="save_print" value="save_print" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info  btn-sm"><i class="fa fa-print"></i> <?php echo $this->lang->line('save_print'); ?>

                      <button type="submit" name="save" value="save" class="btn btn-primary btn-sm" id="form_prescriptionbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?> </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" data-toggle="tooltip" data-original-title="Close" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>
                        <?php if ($this->rbac->hasPrivilege('revisit', 'can_edit')) { ?>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" ><i class="fa fa-pencil"></i></a>
                            <?php
                        }

                        if ($this->rbac->hasPrivilege('revisit', 'can_delete')) {
                            ?>
                            <a href="#" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                    </div>
                </div>
                <h4 class="modal-title"> <?php echo $this->lang->line('visit_details'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
              
            </div>    

        </div>
    </div> 
</div>



<!-- -->
<div class="modal fade" id="prescriptionview" tabindex="-1" role="dialog" aria-labelledby="follow_up">   
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deleteprescription'>
                
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('prescription'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescription">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prescriptionviewmanual" tabindex="-1" role="dialog" aria-labelledby="follow_up">   
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deleteprescriptionmanual'>
                 
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('prescription'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescriptionmanual">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModaledit"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('patient_details'); ?></h4> 
            </div><!--./modal-header-->
                <form id="formeditpa" accept-charset="utf-8" action="" enctype="multipart/form-data" method="post">
                    <div class="modal-body pt0 pb0">
                        <input id="eupdateid" name="updateid" placeholder="" type="hidden" class="form-control"  value="" />
                            <div class="row row-eq">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row ptt10">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                                <input id="ename" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('guardian_name') ?></label>
                                                <input type="text" name="guardian_name"  id="eguardian_name"placeholder="" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">  
                                            <div class="row">  
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label> <?php echo $this->lang->line('gender'); ?></label>
                                                        <select class="form-control" name="gender" id="egenders">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php
                                                            foreach ($genderList as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                 <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="dob"><?php echo $this->lang->line('date_of_birth'); ?></label> 
                                                        <input type="text" name="dob" id="birth_date" placeholder=""  class="form-control date patient_dob" /><?php echo set_value('dob'); ?>
                                                    </div>
                                                </div>
 
                                                <div class="col-sm-5" id="calculate">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('age').' ('.$this->lang->line('yy_mm_dd').')'; ?> </label><small class="req"> *</small> 
                                                        <div style="clear: both;overflow: hidden;">
                                                            <input type="text" placeholder="<?php echo $this->lang->line('year'); ?>" name="age[year]" id="age_year" value="" class="form-control patient_age_year" style="width: 30%; float: left;">

                                                            <input type="text" id="age_month" placeholder="<?php echo $this->lang->line('month'); ?>" name="age[month]" value="" class="form-control patient_age_month" style="width: 36%;float: left; margin-left: 4px;">
                                                             <input type="text" id="age_day" placeholder="<?php echo $this->lang->line('day'); ?>" name="age[day]" value="" class="form-control patient_age_day" style="width: 26%;float: left; margin-left: 4px;">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>  
                                        </div><!--./col-md-6-->  
                                        <div class="col-md-6 col-sm-12"> 
                                            <div class="row"> 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> <?php echo $this->lang->line('blood_group'); ?></label>
                                                        <select class="form-control" id="blood_groups" name="blood_group">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php
                                                                foreach ($bloodgroup as $key => $value) {
                                                                    ?>
                                                                  <option value="<?php echo $key; ?>" <?php if (set_value('blood_group') == $key) {
                                                                    echo "selected";
                                                                   }
                                                                ?>><?php echo $value; ?></option>
                                                                <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="pwd"><?php echo $this->lang->line('marital_status'); ?></label>
                                                        <select name="marital_status" id="marital_statuss" class="form-control">
                                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($marital_status as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value; ?>" <?php if (set_value('marital_status') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">
                                                            <?php echo $this->lang->line('patient') . " " . $this->lang->line('photo'); ?>
                                                        </label>
                                                        <div>
                                                            <input class="filestyle form-control-file" type='file' name='file' id="exampleInputFile" size='20' data-height="26" data-default-file="<?php echo base_url() ?>uploads/patient_images/no_image.png" >
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div><!--./col-md-6-->
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                                <input id="emobileno" autocomplete="off" name="contact"  type="text" placeholder="" class="form-control"  value="<?php echo set_value('mobileno'); ?>" />
                                            </div>
                                        </div> 
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('email'); ?></label>
                                                <input type="text" placeholder="" id="eemail" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="address"><?php echo $this->lang->line('address'); ?></label> 
                                                <input name="address" id="eaddress" placeholder="" class="form-control" /><?php echo set_value('address'); ?>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('remarks'); ?></label> 
                                                <textarea name="note" id="enote" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> 
                                                <textarea name="known_allergies" id="eknown_allergies" placeholder="" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div> 
                                    <div class="" id="customfieldpatient" >
                                        
                                    </div> 
                                    </div><!--./row--> 
                                </div><!--./col-md-8--> 
                            </div><!--./row--> 
                         </div>   
         
                                <div class="modal-footer">
                                    <div class="pull-right">
                                        <button type="submit" id="formeditpabtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                                    </div>
                                </div> 
                        </form>                       
                   
            
        </div>
    </div>    
</div>
<!-- discharged summary   -->
<div class="modal fade" id="myModaldischarged"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <div class="modalicon"> 
                     <div id='summary_print'>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('discharged') . " " . $this->lang->line('summary') ?></h4> 
                <div class="row">
                </div><!--./row--> 
            </div>
            <form id="formdishrecord" accept-charset="utf-8"  enctype="multipart/form-data" method="post" >
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div class="row row-eq">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="ptt10">
                                        <div id="evajax_load"></div>
                                        <div class="row" id="" >
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <ul class="multilinelist">                                                 
                                                      <li>  <label for="pwd"><?php echo $this->lang->line('name'); ?></label>                                  
                                                        <span id="disevlistname"></span>
                                                    </li>
                                                     <li>
                                                        <label for="pwd"><?php echo $this->lang->line('age'); ?></label>
                                                        <span id="disevage"></span>
                                                    </li> 
                                                     <li>
                                                        <label for="pwd"><?php echo $this->lang->line('gender'); ?></label>
                                                        <span id="disevgenders" ></span>
                                                    </li>
                                                </ul>   
                                                <ul class="multilinelist">                                                    
                                                    <li>
                                                         <label><?php echo $this->lang->line('admission') . " " . $this->lang->line('date') ?></label>
                                                        <span id="disedit_admission_date"></span>
                                                    </li> 
                                                    <li>
                                                         <label><?php echo $this->lang->line('discharged') . " " . $this->lang->line('date') ?></label>
                                                        <span id="disedit_discharge_date"></span>
                                                    </li> 
                                                </ul>  
                                            <ul class="singlelist">  
                                                    <li>
                                                        <label><?php echo $this->lang->line('address')?></label>
                                                        <span id="disevaddress"></span>
                                                    </li>
                                            </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('diagnosis'); ?></label>
                                                    <input name="diagnosis" id='disdiagnosis' rows="3" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('operation'); ?></label>
                                                    <input name="operation" id='disoperation'  class="form-control" >
                                                </div>
                                            </div> 
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                                    <textarea name="note" id='disevnoteipd' rows="3" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>                                          
                                            <div class="col-md-12"> 
                                                <div class="dividerhr"></div>
                                            </div><!--./col-md-12-->                                         
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('investigations'); ?></label> 
                                                    <textarea name="investigations" id='disinvestigations' rows="3" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('treatment_at_home'); ?></label> 
                                                    <textarea name="treatment_at_home" id='distreatment_at_home' rows="3" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>     
                                        </div>
                                        <input name="patient_id" id="disevpatients_id" type="hidden">
                                        <input type="hidden" id="disupdateid" name="updateid">
                                        <input type="hidden" id="disopdid" name="opdid">
                                        </div>
                                </div>                               
                            </div><!--./row-->   
                        </div><!--./col-md-12-->       
                    </div><!--./row--> 
                </div>             
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="formdishrecordbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"> <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>  
        </div>
    </div>    
</div>

 <div class="modal fade" id="patient_discharge" tabindex="-1" role="dialog" aria-labelledby="follow_up">   
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               <div class="modalicon"> 
                     <div id='allpayments_print'>
                    </div>
                     <div id='deathdoc_download'>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('patient_discharge'); ?></h4>
            </div>
            <div class="modal-body pb0" id="patient_discharge_result">

            </div>
        </div>
    </div>
</div>
<!-- discharged summary   -->
<div class="modal fade" id="revisitModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100 " role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('patient_details'); ?></h4> 
            </div>
        <form id="formrevisit" accept-charset="utf-8" enctype="multipart/form-data" method="post">     
            <div class="pup-scroll-area">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            
                                <input type="hidden" name="id" id="pid">
                                <input type="hidden" name="password" id="revisit_password">
                                <input type="hidden" name="opd_id"  class="form-control" value="<?php echo $result['id']; ?>">
                                <input type="hidden" name="case_reference_id"  class="form-control" value="<?php echo $result['case_reference_id']; ?>">
                                <input type="hidden" name="email" id="revisit_email">
                                <input type="hidden" name="contact" id="revisit_contact">
                                <input id="revisit_name" name="name" placeholder="" type="hidden" class="form-control"  value="" />
                                <div class="row row-eq">
                                    <div class="col-lg-8 col-md-8 col-sm-8 ptt10">
                                        <div class="row">
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <ul class="singlelist">
                                                        <li class="singlelist24bold">
                                                            <span id="patientname"></span></li>
                                                        <li>
                                                            <i class="fas fa-user-secret" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('guardian'); ?>"></i>
                                                            <span id="guardian"></span>
                                                        </li>
                                                    </ul>   
                                                    <ul class="multilinelist">   
                                                        <li>
                                                            <i class="fas fa-venus-mars" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('gender'); ?>"></i>
                                                            <span id="rgender" ></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-tint" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('blood_group'); ?>"></i>
                                                            <span id="rblood_group"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-ring" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('marital_status'); ?>"></i>
                                                            <span id="rmarital_status"></span>
                                                        </li> 
                                                    </ul>  
                                                    <ul class="singlelist">  
                                                        <li>
                                                            <i class="fas fa-hourglass-half" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('age'); ?>"></i>
                                                            <span id="rage"></span>
                                                        </li>    

                                                        <li>
                                                            <i class="fa fa-phone-square" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('phone'); ?>"></i> 
                                                            <span id="listnumber"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('email'); ?>"></i>
                                                            <span id="remail"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-street-view" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('address'); ?>"></i>
                                                            <span id="raddress"></span>
                                                        </li>
                                                         <li>
                                                            <b><?php echo $this->lang->line('any_known_allergies') ?> </b> 
                                                            <span id="rallergies" ></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('remarks') ?> </b> 
                                                            <span id="rnote"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('tpa_id') ?> </b> 
                                                            <span id="rtpa_id"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('tpa_validity') ?> </b> 
                                                            <span id="rtpa_validity"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('national_identification_number') ?> </b> 
                                                            <span id="ridentification_number"></span>
                                                        </li>
                                                    </ul> 
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <img id="patient_image" class="profile-user-img img-responsive" alt="User profile picture">
                                                </div>
                                        </div>        
                                        <div class="row">        
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('height'); ?></label> 
                                                    <input name="height" id="revisit_height" type="text" class="form-control"  value="<?php echo set_value('height'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('weight'); ?></label> 
                                                    <input name="weight" id="revisit_weight" type="text" class="form-control"  value="<?php echo set_value('weight'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('bp'); ?></label> 
                                                    <input name="bp" type="text" id="revisit_bp" class="form-control"  value="<?php echo set_value('bp'); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('pulse'); ?></label> 
                                                    <input name="pulse" id="revisit_pulse" type="text" class="form-control"  value="<?php echo set_value('pulse'); ?>" />
                                                </div>
                                            </div>
                                        

                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('temperature'); ?></label> 
                                                    <input name="temperature" id="revisit_temperature" type="text" class="form-control"  value="<?php echo set_value('temperature'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('respiration'); ?></label> 
                                                    <input name="respiration" type="text" id="revisit_respiration" class="form-control"  value="<?php echo set_value('bp'); ?>"/>
                                                </div>
                                            </div>
                                        </div><!--./row-->    
                                    <div class="row">        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                    <label >
                                                        <?php echo $this->lang->line('symptoms_type'); ?></label>
                                                    <div><select  name='symptoms_type'  id="act"  class="form-control select2 act"  style="width:100%" >
                                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($symptomsresulttype as $dkey => $dvalue) {
                                                                ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["symptoms_type"] ;?></option>

                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('symptoms_type'); ?></span>
                                                </div>
                                            </div>
                                            
                                            
                                                <div class="col-sm-3">
                                                    <label > 
                                                        <?php echo $this->lang->line('symptoms_title') ; ?></label>
                                                    <div id="dd" class="wrapper-dropdown-3">
                                                        <input class="form-control filterinput" type="text">
                                                        <ul class="dropdown scroll150 section_ul">
                                                            <li><label class="checkbox"><?php echo $this->lang->line('select'); ?></label></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email"><?php echo $this->lang->line('symptoms'); ?></label> 
                                                    <textarea name="symptoms" id="esymptoms" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                                </div> 
                                            </div>
                                        
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                                    <textarea name="note_remark" id="revisit_note" class="form-control" ><?php echo set_value('note_remark'); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
    <div class="form-group">
        <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> 
        <textarea name="known_allergies" id="eknown_allergies" placeholder="" class="form-control" ><?php echo set_value('address'); ?></textarea>
    </div> 
</div>
                                            <div class="">
                                                <?php
                                                echo display_custom_fields('opdrecheckup');
                                                ?>
                                            </div>    
                                        </div>
                                    </div><!--./col-md-8--> 

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-eq ptt10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('appointment_date'); ?></label>
                                                    <small class="req">*</small>
                                                    <input id="revisit_date" name="appointment_date" placeholder="" type="text" class="form-control datetime"   />
                                                    <span class="text-danger"><?php echo form_error('appointment_date'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label >
                                                        <?php echo $this->lang->line('case'); ?></label>
                                                    <div><input class="form-control" type='text' id="revisit_case" name='revisit_case' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label >
                                                        <?php echo $this->lang->line('casualty'); ?></label>
                                                    <div>
                                                    <select name="casualty" id="revisit_casualty" class="form-control">
                                                        <?php foreach ($yesno_condition as $yesno_key => $yesno_value) {
                                                            ?>
                                                            <option value="<?php echo $yesno_key ?>" <?php
                                                                    if ($yesno_key == 'no') {
                                                                        echo "selected";
                                                                    }
                                                                    ?> ><?php echo $yesno_value ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>

                                                    
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('casualty'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label >
                                                    <?php echo $this->lang->line('old_patient'); ?></label>
                                                    <div>
                                                        <select name="old_patient" id="revisit_old_patient" class="form-control">
                                                        <?php foreach ($yesno_condition as $yesno_key => $yesno_value) {
                                                            ?>
                                                            <option value="<?php echo $yesno_key ?>" <?php
                                                                    if ($yesno_key == 'no') {
                                                                        echo "selected";
                                                                    }
                                                                    ?> ><?php echo $yesno_value ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                       
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('old_patient'); ?></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label >
                                                        <?php echo $this->lang->line('tpa'); ?></label>
                                                    <div>
                                                    <select class="form-control" name='organisation_name' onchange="" id="revisit_organisation" >
                                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($organisation as $orgkey => $orgvalue) {
                                                                ?>
                                                                <option value="<?php echo $orgvalue["id"]; ?>" <?php
                                                                        if ((isset($org_select)) && ($org_select == $orgvalue["id"])) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $orgvalue["organisation_name"]  ;?></option>   
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('organisation_name'); ?></span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label >
                                                        <?php echo $this->lang->line('reference'); ?></label>
                                                    <div><input class="form-control" id="revisit_refference" type='text' name='refference' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label >
                                                            <?php echo $this->lang->line('consultant_doctor'); ?></label>
                                                    <div><select  onchange="" class="form-control" style="width: 100%"  <?php
                                                            if ($disable_option == true) {
                                                                echo "disabled";
                                                            }
                                                            ?> name='consultant_doctor' id="revisit_doctor">
                                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($doctors as $dkey => $dvalue) {
                                                                ?><option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo composeStaffNameByString($dvalue["name"] , $dvalue["surname"],$dvalue["employee_id"]); ?></option>   
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('charge_category'); ?></label>
                                            <select name="charge_category" style="width: 100%" class="form-control charge_category select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php foreach ($charge_category as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id']; ?>">
                                                    <?php echo $value['name']; ?>
                                                    </option>
                                                            <?php } ?>
                                            </select>

                                                    <span class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                                </div>
                                            </div> 

                                            <div class="col-md-6">
                                                <div class="form-group">
                                            <label><?php echo $this->lang->line('charge'); ?></label><small class="req"> *</small>
                                            <select name="charge_id" style="width: 100%" class="form-control charge select2">
                                            <option value=""><?php echo $this->lang->line('select')?></option>
                                            </select>
                                                    <span class="text-danger"><?php echo form_error('charge_id'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group"> 
                                                    <label><?php echo $this->lang->line('tax'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control right-border-none" name="percentage" id="percentage" readonly autocomplete="off">
                                                        <span class="input-group-addon "> %</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('standard_charge') . " (" . $currency_symbol . ")" ?></label>
                                                    <input type="text" readonly name="standard_charge" id="standard_chargevisit" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 

                                                    <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('applied_charge') . " (" . $currency_symbol . ")" ?></label><small class="req"> *</small><input type="text" name="amount" id="apply_chargevisit" onkeyup="update_amount(this.value)" class="form-control">    
                                                    <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('amount'); ?> <?php echo '(' . $currency_symbol . ')'; ?></label><small class="req"> *</small> 
                                                    <input name="apply_amount" readonly type="text" class="form-control" id="revisit_amount" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('payment_mode'); ?></label> 
                                                    <select name="payment_mode" id="revisit_payment" class="form-control revisit_payment_mode">

                                                        <?php foreach ($payment_mode as $payment_key => $payment_value) {
                                                            ?>
                                                            <option value="<?php echo $payment_key ?>" <?php
                                                            if ($payment_key == 'cash') {
                                                                echo "selected";
                                                            }
                                                            ?> ><?php echo $payment_value ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="revisit_cheque_div" style="display:none;">
                                
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req"> *</small> 
                                                    <input type="text" name="cheque_no" id="cheque_no" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('cheque_no'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('cheque_date'); ?></label><small class="req"> *</small> 
                                                    <input type="text" name="cheque_date" id="cheque_date" class="form-control date">
                                                    <span class="text-danger"><?php echo form_error('cheque_date'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('attach_document'); ?></label>
                                                    <input type="file" class="filestyle form-control"   name="document">
                                                    <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                                </div>
                                            </div>
                                        </div>


                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('paid_amount'); ?></label><small class="req"> *</small>
                                                    <input name="paid_amount" type="text" class="form-control" id="paid_amount" />
                                                </div>
                                            </div>
                                            <?php if ($this->module_lib->hasActive('live_consultation')) { ?>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label >
                                                        <?php echo $this->lang->line('live_consultation'); ?></label>
                                                        <div>
                                                        <select name="live_consult" id="live_consultvisit" class="form-control">
                                                        <?php foreach ($yesno_condition as $yesno_key => $yesno_value) {
                                                            ?>
                                                            <option value="<?php echo $yesno_key ?>" <?php
                                                                    if ($yesno_key == 'no') {
                                                                        echo "selected";
                                                                    }
                                                                    ?> ><?php echo $yesno_value ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('live_consult'); ?></span>
                                                    </div>
                                                </div> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div><!--./row--> 

                                               
                        </div><!--./col-md-12-->       

                    </div><!--./row--> 

                </div>
            </div> <!-- scroll area -->
            <div class="modal-footer sticky-footer">
                <div class="pull-right">
                    <button type="submit" id="formrevisitbtn"  data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
        </form>   
        </div>
    </div>    
</div>

<!-- -->
<div class="modal fade" id="myPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_payment'); ?></h4> 
            </div>
                        <form id="add_payment" accept-charset="utf-8" method="post" class="ptt10" >
                <div class="">
                    <div class="modal-body pt0 pb0">
                            <input type="hidden" name="opd_id" id="payment_opd_id" class="form-control" value="<?php echo $result['id']; ?>">
                                                <input type="hidden" name="case_reference_id" id="payment_opd_id" class="form-control" value="<?php echo $result['case_reference_id']; ?>">
                                                <input type="hidden" name="patient_id"value="<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                                
                                                <input type="text" name="payment_date" id="date" class="form-control datetime" autocomplete="off">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small class="req"> *</small> 
                                        
                                                <input type="text" name="amount" id="amount" class="form-control" value="<?php echo number_format((float)($total-$total_payment), 2, '.', ''); ?>">  
                                                 <input type="hidden" name="net_amount"  class="form-control" value="<?php echo $total-$total_payment ; ?>">  
                                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('payment_mode'); ?></label> 
                                                <select class="form-control payment_mode" name="payment_mode">

                                                <?php foreach ($payment_mode as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key ?>" <?php
                                                    if ($key == 'cash') {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $value ?></option>
                                                <?php } ?>
                                                </select>    
                                                <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row cheque_div" style="display: none;">
                                
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req"> *</small> 
                                                <input type="text" name="cheque_no" id="cheque_no" class="form-control">
                                                <span class="text-danger"><?php echo form_error('cheque_no'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('cheque_date'); ?></label><small class="req"> *</small> 
                                                <input type="text" name="cheque_date" id="cheque_date" class="form-control date">
                                                <span class="text-danger"><?php echo form_error('cheque_date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('attach_document'); ?></label>
                                                <input type="file" class="filestyle form-control"   name="document">
                                                <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('note'); ?></label> 
                                                <input type="text" name="note" id="note" class="form-control"/>
                                            </div>
                                        </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div><!-- scroll-area -->  
                <div class="modal-footer">
                <button type="submit" id="add_paymentbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </form>  
                </div>
        </div>
    </div> 
</div>
<!-- -->
<div class="modal fade" id="view_ot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
         <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    

                    <div id='action_detail_modal'>

                   </div>


                </div>

                <h4 class="modal-title"><?php echo $this->lang->line('operation_details'); ?></h4>
            </div>
            <div class="modal-body min-h-3">
               <div id="show_ot_data"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editpayment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <form id="editpaymentform" accept-charset="utf-8" method="post">
             <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modalicon">
                    </div>

                    <h4 class="modal-title"><?php echo $this->lang->line('payment_details'); ?></h4>
                </div>
                <div class="modal-body ">
                   <!-- <div clas="row">
                     <div clas="col-md-12">
                        <label><?php echo $this->lang->line('amount'); ?></label> <span class="req">*</span>
                         <input type="text" class="form-control" id="edit_payment" name="edit_payment" >
                         <input type="hidden" class="form-control" id="edit_payment_id" name="edit_payment_id" >
                     </div>

                   </div> -->
                   <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 

                                                
                                                <input type="text" name="payment_date" id="payment_date" class="form-control datetime" autocomplete="off">
                                                 <input type="hidden" class="form-control" id="edit_payment_id" name="edit_payment_id" >
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small class="req"> *</small> 
                                        
                                                <input type="text" name="amount" id="edit_payment" class="form-control" value="">  
                                                
                                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('payment_mode'); ?></label> 
                                                <select class="form-control payment_mode" name="payment_mode" id="payment_mode">

                                                <?php foreach ($payment_mode as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key ?>" <?php
                                                    if ($key == 'cash') {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $value ?></option>
                                                <?php } ?>
                                                </select>    
                                                <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row cheque_div" style="display: none;">
                                
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req"> *</small> 
                                                <input type="text" name="cheque_no" id="edit_cheque_no" class="form-control">
                                                <span class="text-danger"><?php echo form_error('cheque_no'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('cheque_date'); ?></label><small class="req"> *</small> 
                                                <input type="text" name="cheque_date" id="edit_cheque_date" class="form-control date">
                                                <span class="text-danger"><?php echo form_error('cheque_date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('attach_document'); ?></label>
                                                <input type="file" class="filestyle form-control"   name="document">
                                                <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('note'); ?></label> 
                                                <input type="text" name="note" id="edit_payment_note" class="form-control"/>
                                            </div>
                                        </div>

                                    </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editpaymentbtn" data-loading-text="Processing..." class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- //========datatable start===== -->
<script type="text/javascript">
    $(document).on('click','.print_ot_bill',function(){
         var $this = $(this);
         var record_id=$this.data('recordId');
       $this.button('loading');
      $.ajax({
          url: '<?php echo base_url(); ?>admin/operationtheatre/print_otdetails',
          type: "POST",
          data:{'id':record_id},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(res) {
           popup(res.page);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
              complete: function() {
                   $this.button('reset');
                 
             }
      });
    });

  
</script>


<script type="text/javascript">

( function ( $ ) {
     var opdid = "<?php echo $this->uri->segment(5); ?>"; 
     var patient_id = "<?php echo $this->uri->segment(4); ?>";
    'use strict';
    $(document).ready(function () {
        $('#view_ot_modal,#myPaymentModal,#viewModal,#add_chargeModal').modal({
    backdrop: 'static',
    keyboard: false,
    show:false
})
        initDatatable('ajaxlist','admin/patient/getvisitdatatable/'+ opdid);

        
    }); 

} ( jQuery ) )


</script>

<!-- //========datatable end===== -->

<script type="text/javascript">
   
 var datetime_format = '<?php echo strtr($this->customlib->getHospitalDateFormat(true, true), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY', 'H' => 'hh', 'i' => 'mm']) ?>';


    $(document).on('click', '.add-btn', function () {
        var s = "";
        s += "<div class='row'>";
        s += "<input name='rows[]' type='hidden' value='" + rows + "'>";
        s += "<div class='col-md-6'>";
        s += "<div class='form-group'>";
        s += "<label for='act'>Act</label>";
        s += "<select class='form-control act select2' id='act' name='act" + rows + "' data-row_id='" + rows + "'>";
        s += "<option value=''>--Select--</option>";
        s += $('#act-template').html();
        s += "</select>";
        s += "<small class='text text-danger help-inline'></small>";
        s += "</div>";
        s += "</div>";
        s += "<div class='col-md-5'>";
        s += "<label for='validationDefault02'>Section</label>";
        s += "<div id='dd' class='wrapper-dropdown-3'>";
        s += "<input class='form-control filterinput' type='text'>";
        s += "<ul class='dropdown scroll150 section_ul'>";
        s += "<li><label class='checkbox'>--Select--</label></li>";
        s += "</ul>";
        s += "</div>";
        s += "</div>";
        s += "<div class='col-md-1'>";
        s += "<div class='form-group'>";
        s += "<label for='removebtn'>&nbsp;</label>";
        s += "<button type='button' class='form-control btn btn-sm btn-danger remove_row'><i class='fa fa-remove'></i></button>";
        s += "</div>";
        s += "</div>";
        s += "</div>";
        $(".multirow").append(s);
        $('.select2').select2();
        link = 2;
        rows++;
    });
</script>

<script type="text/html" id="act-template">

    
   <?php foreach ($symptomsresulttype as $dkey => $dvalue) {
                                                            ?>
        <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["symptoms_type"] ;?></option> 
        <?php
    }
    ?>
</script>  

<script>
    $(document).on('change', '.act', function () {
        $this = $(this);
        var sys_val = $(this).val();
       
        var row_id = $this.data('row_id');
        var section_ul = $(this).closest('div.row').find('ul.section_ul');

        var sel_option = "";
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/getPartialsymptoms',
            data: {'sys_id': sys_val, 'row_id': row_id},
            dataType: 'JSON',
            beforeSend: function () {
                
                $('ul.section_ul').find('li:not(:first-child)').remove();
                $("div.wrapper-dropdown-3").removeClass('active');

            },
            success: function (data) {
           
                section_ul.append(data.record);

            },
            error: function (xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

            },
            complete: function () {

            }
        });

    });
</script>
<script type="text/javascript">

    $(function () {

        $(".timepicker").timepicker({defaultTime: '12:00 PM'});
    });


     $(document).on('select2:select','.medicine_category_medication',function(){

       var medicine_category=$(this).val();
      
      $('.medicine_name_medication').html("<option value=''><?php echo $this->lang->line('loading'); ?></option>");
     getMedicineForMedication(medicine_category,"");
     getMedicineDosageForMedication(medicine_category);
    });

    function getMedicineForMedication(medicine_category,medicine_id) {

      var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
      if(medicine_category != ""){
          $.ajax({
            url: base_url+'admin/pharmacy/get_medicine_name',
            type: "POST",
            data: {medicine_category_id: medicine_category},
            dataType: 'json',
            success: function (res) {
              
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.medicine_name + "</option>";

                });
                $('.medicine_name_medication').html(div_data);
                $(".medicine_name_medication").select2("val", medicine_id);
                $("#mmedicine_edit_id").val(medicine_id).trigger("change");
                $("#add_dose_medicine_id").val(medicine_id).trigger("change");
            }
        });
      }
    }

    function getMedicineDosageForMedication(medicine_category) {
        var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
        if(medicine_category != ""){
          $.ajax({
            url: base_url+'admin/pharmacy/get_medicine_dosage',
            type: "POST",
            data: {medicine_category_id: medicine_category},
            dataType: 'json',
            success: function (res) {
              
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.dosage + " " + obj.unit + "</option>";

                });
                $('.dosage_medication').html(div_data);
                $(".dosage_medication").select2("val", '');
             
            }
        });
      }
    }

    function get_dosagename(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/get_dosagename',
            type: "POST",
            data: {dosage_id: id},
            dataType: 'json',
            success: function (res) {
                if (res) {
                    //console.log(res.dosage_unit);
                    $('#medicine_dosage_medication').val(res.dosage_unit);
                } else {

                }
            }
        });
    }


    $(document).ready(function (e) {
        $("#add_medication").on('submit', (function (e) {
            e.preventDefault();
            $("#add_medicationbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addmedicationdoseopd',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                 beforeSend: function(){
                $("#add_medicationbtn").button('loading');
                 },
                success: function (data) {
                    if (data.status == "fail") {
                        var message = data.message;
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#add_medicationbtn").button('reset');
                },
                error: function () {
                 $("#add_medicationbtn").button('reset');
                },
  
                complete: function(){
                $("#add_medicationbtn").button('reset');
                }
            });
        }));
    });



    $(document).on('click', '.remove_row', function () {
        $this = $(this);
        $this.closest('.row').remove();

    });
    $(document).mouseup(function (e)
    {
        var container = $(".wrapper-dropdown-3"); // YOUR CONTAINER SELECTOR

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $("div.wrapper-dropdown-3").removeClass('active');
        }
    });

    $(document).on('click', '.filterinput', function () {

        if (!$(this).closest('.wrapper-dropdown-3').hasClass("active")) {
            $(".wrapper-dropdown-3").not($(this)).removeClass('active');
            $(this).closest("div.wrapper-dropdown-3").addClass('active');
        }


    });

    $(document).on('click', 'input[name="section[]"]', function () {
        $(this).closest('label').toggleClass('active_section');
    });
 
    $(document).on('keyup', '.filterinput', function () {

        var valThis = $(this).val().toLowerCase();
        var closer_section = $(this).closest('div').find('.section_ul > li');

        var noresult = 0;
        if (valThis == "") {
            closer_section.show();
            noresult = 1;
            $('.no-results-found').remove();
        } else {
            closer_section.each(function () {
                var text = $(this).text().toLowerCase();
                var match = text.indexOf(valThis);
                if (match >= 0) {
                    $(this).show();
                    noresult = 1;
                    $('.no-results-found').remove();
                } else {
                    $(this).hide();
                }
            });
        }
        ;
        if (noresult == 0) {
            closer_section.append('<li class="no-results-found">No results found.</li>');
        }
    });
</script>
<script type="text/javascript">
    function holdModal(modalId) {
        $("#report_document").dropify();
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }


     function addmedicationModal() {
        document.querySelector("#add_medication").reset();
        $("#mmedicine_id").val("").trigger("change");
        holdModal('myaddMedicationModal');
    }


   $('#myaddMedicationModal').on('hidden.bs.modal', function () {
    $('#add_medication').find('input:text, input:password, input:file, textarea').val('');
    $('#add_medication').find('select option:selected').removeAttr('selected');
    $('#add_medication').find('input:checkbox, input:radio').removeAttr('checked');
    $('.medicine_category_medication').val("").trigger("change");
    $('.medicine_name_medication').val("").trigger("change");
    $('.dosage_medication').val("").trigger("change");
     $('#mtime').val('12:00 PM');
   });


    function medicationModal(medicine_category_id,pharmacy_id,date) {

        var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
        if(medicine_category_id != ""){
          $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getMedicineDoseDetails',
            type: "POST",
            data: {medicine_category_id: medicine_category_id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.dosage +" "+ obj.unit + "</option>";

                });

                $("#mdosage").html(div_data);

                $("#add_dose_medicine_category").select2("val",medicine_category_id);
                $("#mdosage").select2("val", '');
                 getMedicineForMedication(medicine_category_id,pharmacy_id);
              
                $("#add_dose_date").val(date);

                holdModal('myMedicationModal');
            },
        });
      }

    }


     function medicationDoseModal(medication_id) {
        
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getMedicationDoseDetails',
            type: "POST",
            data: {medication_id: medication_id},
            dataType: 'json',
            success: function (data) {
                $("#date_edit_medication").val(data.date);
               
                  $('#dosagetime').timepicker('setTime', timeConvert(data.time));

                $('select[id="medicine_dose_id"] option[value="' + data.medicine_dosage_id + '"]').attr("selected", "selected");
                $("#medicine_dose_edit_id").select2().select2('val', data.medicine_dosage_id);
                $("#mmedicine_category_edit_id ").val(data.medicine_category_id).trigger('change');
                getMedicineForMedication(data.medicine_category_id,data.pharmacy_id);
                $("#medicine_dosage_remark").val(data.remark);
                $("#medication_id").val(data.id);
                $('#edit_delete_medication').html("<a href='#' class='delete_record_dosage' data-record-id='"+ medication_id + "' data-toggle='tooltip' title='<?php echo $this->lang->line('delete'); ?>' data-target='' data-toggle='modal'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a>");

                holdModal('myMedicationDoseModal');
            },
        });
    }

    $(document).ready(function (e) {

    $(document).on('click','.delete_record_dosage',function(){
         if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
     var id=$(this).data('recordId');

    $.ajax({
                url: base_url+'admin/patient/deletemedication',
                type: "POST",
                data: {'id':id},
                dataType: 'json',
                 beforeSend: function(){
              
                 },
                success: function (data) {
                  successMsg(data.message);
                  window.location.reload(true); 
                },
                error: function () {
                 alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                },
  
                complete: function(){

                }
            });
}
    });

        $("#add_medicationdose").on('submit', (function (e) {
            e.preventDefault();
            $("#add_medicationdosebtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addmedicationdoseopd',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                 beforeSend: function(){
                $("#add_medicationdosebtn").button('loading');
                 },
                success: function (data) {
                    if (data.status == "fail") {
                        var message = data.message;
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#add_medicationdosebtn").button('reset');
                },
                error: function () {
                 $("#add_medicationdosebtn").button('reset');
                },
  
                complete: function(){
                $("#add_medicationdosebtn").button('reset');
                }
            });
        }));
    });

     $(document).ready(function (e) {
        $("#update_medication").on('submit', (function (e) {
            e.preventDefault();
            $("#update_medicationbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/updatemedication',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                 beforeSend: function(){
                $("#update_medicationbtn").button('loading');
                 },
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#update_medicationbtn").button('reset');
                },
                error: function () {
                 $("#update_medicationbtn").button('reset');
                },
  
                complete: function(){
                $("#update_medicationbtn").button('reset');
                }
            });
        }));
    });


    $(function () {
        //Initialize Select2 Elements
        $(function () {
            var hash = window.location.hash;
            hash && $('ul.nav-tabs a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
                   var pid = $("#result_pid").val();
                   var opdid = $("#result_opdid").val();
                 if (this.hash == '#charges') {
                   
                 }else if(this.hash == '#payment') {

                 }else if(this.hash == '#diagnosis'){
                   
                 }
            });
        });
    });


    function getdatavalue(dataurl) {
       
        var pid = $("#result_pid").val();
        var opdid = $("#result_opdid").val();
        var base_url = '<?php echo base_url(); ?>';
        var url = base_url+dataurl;
        $.ajax({
            url: url,
            type: 'POST',
            data: {pid: pid, opdid: opdid},
            success: function (result) {
             
              $('#datadiganosis').html(result);
            }
        });
    }
 
    $(function () {
        $("#compose-textareas,#compose-textareanew").wysihtml5({
            toolbar: {
                "image": false,
            }
        });
    });
    function edit_prescription(id) {
//console.log(id);
        $.ajax({
            url: base_url+'admin/prescription/editopdPrescription',
            dataType:'JSON',
            data:{'prescription_id':id} ,
            type:"POST",
             beforeSend: function() {
    $('.modal-title',"#add_prescription").html('');

              },
               success: function (res) {
     $('.modal-title',"#add_prescription").html('<?php echo $this->lang->line('edit_prescription'); ?>');

                $('#prescriptionview').modal('hide');
                $('.modal-body',"#add_prescription").html(res.page);
                var medicineTable= $('.modal-body',"#add_prescription").find('table#tableID');
        medicineTable.find('.select2').select2();
        $('.modal-body',"#add_prescription").find('.multiselect2').select2({   
            placeholder: 'Select',
            allowClear: false,
            minimumResultsForSearch: 2
        });

 
    medicineTable.find("tbody tr").each(function() {

    var medicine_category_obj = $(this).find("td select.medicine_category");
    var post_medicine_category_id = $(this).find("td input.post_medicine_category_id").val();
    var post_medicine_id = $(this).find("td input.post_medicine_id").val();
    var dosage_id = $(this).find("td input.post_dosage_id").val();
    var medicine_dosage=getDosages(post_medicine_category_id,dosage_id);

    $(this).find('.medicine_dosage').html(medicine_dosage);
    $(this).find('.medicine_dosage').select2().select2('val', dosage_id);
    
    getMedicine(medicine_category_obj,post_medicine_category_id,post_medicine_id);

     });
                $('#add_prescription').modal('show');
             },

              complete: function() {
                 $(function () {
                    $("#compose-textareas,#compose-textareanew").wysihtml5({
                        toolbar: {
                            "image": false,
                        }
                    });
                }); 
                 
             },
             error: function(xhr) { // if error occured
              alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

              
         }                                                                                    
        });
    }

    function editDiagnosis(id) {
        //alert(patient_id);
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editDiagnosis',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
               // console.log(data);
                $("#eid").val(data.id);
                $("#epatient_id").val(data.patient_id);
                $("#ereporttype").val(data.report_type);
                $("#ereportdate").val(data.report_date);
                $("#edescription").val(data.description);
                $("#ereportcenter").val(data.report_center);
                holdModal('edit_diagnosis');

            },
        });
    }
$(document).on('click','.editot',function(){
    let id=$(this).data('recordId');
       $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/getotDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#otid").val(data.id);
                
                 $('#eoperation_category').select2().select2('val',data.category_id);
                
                 getcategory(data.category_id,data.operation_id);
                  $('#edate').datetimepicker({
                 format: datetime_format,

            });
                  
               $('#edate').data("DateTimePicker").date(new Date(data.date));

                
                $("#eass_consultant_1").val(data.ass_consultant_1);
                $("#eass_consultant_2").val(data.ass_consultant_2);
                $("#eanesthetist").val(data.anesthetist);
                $("#eanaethesia_type").val(data.anaethesia_type);
                $("#eot_technician").val(data.ot_technician);
                $("#eot_assistant").val(data.ot_assistant);
                $("#eot_remark").val(data.remark);
                $("#eot_result").val(data.result);
                
                $('#econsultant_doctorid').select2().select2('val',data.consultant_doctor);
                $('#custom_fields_ot').html(data.custom_fields_value);
                 $('#eoperation_name').select2().select2('val',data.operation_id);
                holdModal('edit_operationtheatre');

            },
        });
});
  
    
    $(document).ready(function (e) {
        $("#form_editoperationtheatre").on('submit', (function (e) {
            $("#form_editoperationtheatrebtn").button('loading');
            var cons = $("#cons_doctor").val();
            $("#cons_name").val(cons);
            e.preventDefault();
             var did = $("#econsultant_doctorid").val();
            
            $("#econsultant_doctorname").val(did);

            $.ajax({
                url: '<?php echo base_url(); ?>admin/operationtheatre/update',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#form_editoperationtheatrebtn").button('reset');
                },
                error: function () {
                    
                }
            });
        }));
    });

    

    function getchargecode(charge_category) {
        var div_data = "";
        $('#code').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $("#code").select2("val", 'l');


        $.ajax({
            url: '<?php echo base_url(); ?>admin/charges/getchargeDetails',
            type: "POST",
            data: {charge_category: charge_category},
            dataType: 'json',
            success: function (res) {
                
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.code + " - " + obj.description + "</option>";

                });

                $('#code').html("<option value=''><?php echo $this->lang->line('select'); ?></option>");

                $('#code').append(div_data);
                $("#code").select2("val", '');

                $('#standard_charge').val('');
                $('#apply_charge').val('');
            }
        });
    }

    $(document).ready(function (e) {
        $("#form_editdiagnosis").on('submit', (function (e) {
           
            $("#form_editdiagnosisbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update_diagnosis',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                     
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#form_editdiagnosisbtn").button('reset');
                },
                error: function () {
                  
                }
            });
        }));
    });

    $(document).on('click','.get_opd_detail',function(){
       var visitid=$(this).data('recordId');
       var $this = $(this);
   
        $.ajax({
            url: base_url+'admin/patient/getopdrecheckupDetails',
            type: "POST",
            data: {visit_id: visitid},
            dataType: 'json',
               beforeSend: function() {
              $this.button('loading');
               
               },
            success: function (data) {
                var can_delete = data.can_delete;
                if(can_delete == 'yes'){
                    var delete_action = "<a href='#' data-toggle='tooltip'  onclick='delete_record(" + visitid + ")' data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a>";
                }else{
                    var delete_action = '';
                }
                var patient_id = "<?php echo $result["id"] ?>";
                $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('revisit', 'can_edit')) { ?><a href='#'' onclick='editRecord(" + visitid + ")' data-target='#editModal' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('revisit', 'can_delete')) { ?>"+delete_action+"<?php } ?>" );
                $('#viewModal .modal-body').html(data.page);
              $('#viewModal').modal('show');

            },

             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
             $this.button('reset');
               
          },
          complete: function() {
                $this.button('reset');
         
          }
        });


});

$(document).on('click','#add_newcharge',function(){ 

});

   
    function editRecord(visitid) {
      
        var $exampleDestroy = $('#edit_consdoctor').select2();
        $.ajax({
            //url: '<?php //echo base_url(); ?>admin/patient/getopdvisitdetails',
            url: '<?php echo base_url(); ?>admin/patient/getvisitdetailsdata',
            type: "GET",
            data: {visitid: visitid},
            dataType: 'json',
            success: function (data) {
    
                $exampleDestroy.val(data.cons_doctor).select2('destroy').select2()
                $('#customfield').html(data.custom_fields_value);
                $("#appointmentdate").val(data.appointment_date);
                $('#visitid').val(visitid);
                $('#visit_transaction_id').val(data.transaction_id);
                $("#edit_case").val(data.case_type);
                $("#symptoms_description").val(data.symptoms);
                $("#edit_casualty").val(data.casualty);
                $("#edit_oldpatient").val(data.patient_old);
                $("#edit_refference").val(data.refference);
                $("#edit_revisit_note").val(data.note);
                $('select[id="edit_organisation"] option[value="'+data.organisation_id+'"]').attr("selected","selected");
/*var opd_symptoms_data_view = 'height : ' + data.height + '<br>Weight: '+ data.weight; 
$(".opd_symptoms_data_view").html(opd_symptoms_data_view);*/
                $("#edit_height").val(data.height);
                $("#edit_weight").val(data.weight);
                $("#edit_bp").val(data.bp);
                $("#edit_pulse").val(data.pulse);
                $("#edit_temperature").val(data.temperature);
                $("#edit_respiration").val(data.respiration);
                $("#edit_paymentmode").val(data.payment_mode);
                $("#edit_opdid").val(data.opdid);
                $("#eknown_allergies").val(data.visit_known_allergies);
                 $("#edit_visit_payment_date").val(data.payment_date);
                 $("#edit_visit_payment").val(data.amount);
                 $("#visit_payment_mode").val(data.payment_mode).prop('selected');
                 $(".visit_payment_mode").trigger('change');
                 $("#edit_visit_cheque_no").val(data.cheque_no);
                 $("#edit_visit_cheque_date").val(data.cheque_date);
                 $("#edit_visit_payment_note").val(data.payment_note);
                 $("#viewModal").modal('hide');
                 holdModal('editModal');
            },
        });
    }
    
    function delete_record(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteVisit/'+id,
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function deleteot(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/operationtheatre/delete/'+id,
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function delete_patient(id, patient_id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteOPDPatient',
                type: "POST",
                data: {'id': id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.href = '<?php echo base_url() ?>admin/patient/profile/'+patient_id;
                }
            })
        }
    }

    function getEditRecord(id) {
       
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getpatientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
               $("#eupdateid").val(data.id);
                $('#customfieldpatient').html(data.custom_fields_value);
                $("#ename").val(data.patient_name);
                $("#eguardian_name").val(data.guardian_name);
                $("#emobileno").val(data.mobileno);
                $("#eemail").val(data.email);
                $("#eaddress").val(data.address);
                $("#age_year").val(data.age);
                $("#age_month").val(data.month);
                $("#age_day").val(data.day);
                $("#birth_date").val(data.dob);
                $("#enote").val(data.note);
                $("#exampleInputFile").attr("data-default-file", '<?php echo base_url() ?>' + data.image);
                $(".dropify-render").find("img").attr("src", '<?php echo base_url() ?>' + data.image);
                $("#eknown_allergies").val(data.known_allergies);
                $('select[id="blood_groups"] option[value="' + data.blood_bank_product_id + '"]').attr("selected", "selected");
                $('select[id="egenders"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_statuss"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                $("#myModal").modal('hide');
                holdModal('myModaledit');
            },
        });
    }

    function editTimeline(id) {        
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editTimeline',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                var date_format = '<?php echo $results = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
                var dt = new Date(data.timeline_date).toString(date_format);
                $("#etimelineid").val(data.id);
                $("#epatientid").val(data.patient_id);
                $("#etimelinetitle").val(data.title);
                $("#etimelinedate").val(dt);
               
                $("#timelineedesc").val(data.description);
                if (data.status == '') {
                
                } else
                {
                    $("#evisible_check").attr('checked', true);
                }
               
                holdModal('myTimelineEditModal');

            },
        });
    }

    function getRecordDischarged(id, opdid) {     
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getopdDetailsSummary',
            type: "POST",
            data: {patient_id: id, opd_id: opdid},
            dataType: 'json',
            success: function (data) {
               
                $('#disevlistname').html(data.patient_name);
                $('#disevguardian').html(data.guardian_name);
                $('#disevlistnumber').html(data.mobileno);
                $('#disevemail').html(data.email);
                if (data.age == "") {
                    $("#disevage").html("");
                } else {
                    if (data.age) {
                        var age = data.age + " " + "Years";
                    } else {
                        var age = '';
                    }
                    if (data.month) {
                        var month = data.month + " " + "Month";
                    } else {
                        var month = '';
                    }
                    if (data.dob) {
                        var dob = "(" + data.dob + ")";
                    } else {
                        var dob = '';
                    }

                    $("#disevage").html(age + "," + month + " " + dob);
                }
                $("#disevaddress").html(data.address);
                $("#disenote").html(data.note);
                $("#disevgenders").html(data.gender);
                $("#disevmarital_status").html(data.marital_status);
                $("#disedit_admission_date").html(data.appointment_date);
                $("#disedit_discharge_date").html(data.discharge_date);
                $("#disopdid").val(data.opdid);
                $("#disupdateid").val(data.summary_id);
                $("#disevpatients_id").val(data.pid);
                $("#disinvestigations").val(data.summary_investigations);
                $("#disevnoteipd").val(data.summary_note);
                $("#disdiagnosis").val(data.disdiagnosis);
                $("#disoperation").val(data.disoperation);
                $("#distreatment_at_home").val(data.summary_treatment_home);
                 $('#summary_print').html("<?php if ($this->rbac->hasPrivilege('discharged_summary', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + data.summary_id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?>");               
                holdModal('myModaldischarged');
            },
        });
    }

    function printData(insert_id) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/patient/getopdsummaryDetails/' + insert_id,
            type: 'POST',
            data: {id: insert_id, print: 'yes'},
            success: function (result) {
                popup(result);
            }
        });
    }
   
    $(document).ready(function (e) {
        $("#formeditpa").on('submit', (function (e) {           
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#formeditpabtn").button('reset');
                },
                error: function () {
                    
                }
            });
        }));
    }); 

    function getRecord_id(visitid) {    
       
        $.ajax({
            url: base_url+'admin/prescription/addopdPrescription',
            dataType:'JSON',
            data:{'visit_detail_id':visitid},
            type:"POST",
             beforeSend: function() {
                  $('.modal-title',"#add_prescription").html('');
              },
               success: function (res) {
                
                $('.modal-title',"#add_prescription").html('<?php echo $this->lang->line('add_prescription'); ?>');
                $('.modal-body',"#add_prescription").html(res.page);
                $('.modal-body',"#add_prescription").find('table').find('.select2').select2();
                $('.modal-body',"#add_prescription").find('.multiselect2').select2({   
                        placeholder: 'Select',
                        allowClear: false,
                        minimumResultsForSearch: 2
                    });

                $('#add_prescription').modal('show');
             },

            complete: function() {
                $("#compose-textareass,#compose-textareaneww").wysihtml5({
                        toolbar: {
                            "image": false,
                        }
                    });  
                 
             },
             error: function(xhr) { 
              alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");              
         }                                                                                    
        });
    }

    $(document).ready(function (e) {
        $("#formedit").on('submit', (function (e) {
            $("#formeditbtn").button("loading");
            e.preventDefault();
            
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/opd_detail_update',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#formeditbtn").button("reset");
                },
                error: function () {
                    
                }
            });
        }));
    });
    
$(document).ready(function (e) {
               $("form#form_prescription button[type=submit]").click(function() {            
         $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

        $("#form_prescription").on('submit', (function (e) {          
           
             var sub_btn_clicked = $("button[type=submit][clicked=true]");   
            var sub_btn_clicked_name=sub_btn_clicked.attr('name');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_opd_prescription',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "0") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);           

                        if(sub_btn_clicked_name === "save_print") {                                      
                            printprescription(data.visitid,true);
                        }
                        $('#add_prescription').modal('hide');
                        $('.ajaxlist').DataTable().ajax.reload();
                      
                    }                   
                    sub_btn_clicked.button('reset')  ;
                },
                error: function () {
                       $("#form_prescriptionbtn").button('reset');
                },
                complete: function () {
                       $("#form_prescriptionbtn").button('reset');
                }
            });
        }));
    });

    $(document).ready(function (e) {
        $("#form_operationtheatre").on('submit', (function (e) {
             var did = $("#consultant_doctorid").val();
            $("#consultant_doctorname").val(did);
            $("#form_operationtheatrebtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/operationtheatre/add',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#form_operationtheatrebtn").button('reset');
                },
                error: function () {
                   
                }
            });
        }));
    });

    var prescription_rows=2;
        $(document).on('click','.add-record',function(){
         
        var table = document.getElementById("tableID");
        var table_len = (table.rows.length);

        var id = parseInt(table_len);

        var rowCount = $('#tableID tr').length;
        var cat_row="" ;
        var medicine_row="";
        var dose_row="";
        var dose_interval_row="" ;
        var dose_duration_row="";
        var instruction_row="" ;
            if(table_len==0)
            {
               cat_row ="<label><?php echo $this->lang->line('medicine_category'); ?></label>";
               medicine_row ="<label><?php echo $this->lang->line('medicine'); ?></label>";
               dose_row =" <label><?php echo $this->lang->line("dose"); ?></label>";
               dose_interval_row =" <label><?php echo $this->lang->line("dose_interval"); ?></label>";
               dose_duration_row =" <label><?php echo $this->lang->line("dose_duration"); ?></label>";
               instruction_row =" <label><?php echo $this->lang->line("instruction"); ?></label>";
            }
        
        var div = "<input type='hidden' name='rows[]' value='"+prescription_rows+"' autocomplete='off'><div id=row1><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div '>"+cat_row+"<select class='form-control select2 medicine_category'  name='medicine_cat_"+prescription_rows+"'  id='medicine_cat" + prescription_rows + "'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+medicine_row+"<select class='form-control select2 medicine_name' data-rowId='"+prescription_rows+"'  name='medicine_"+prescription_rows+"' id='search-query" + prescription_rows + "'><option value='l'><?php echo $this->lang->line('select') ?></option></select><small id='stock_info_"+prescription_rows+"''> </small></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_row+"<select  class='form-control select2 medicine_dosage' name='dosage_"+prescription_rows+"' id='search-dosage" + prescription_rows + "'><option value='l'><?php echo $this->lang->line('select'); ?></option></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_interval_row+" <select  class='form-control select2 interval_dosage' name='interval_dosage_"+prescription_rows+"' id='search-interval-dosage" + prescription_rows + "'><option value='<?php echo set_value('interval_dosage_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($intervaldosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_duration_row+"<select class='form-control select2 duration_dosage' name='duration_dosage_"+prescription_rows+"' id='search-duration-dosage" + prescription_rows + "'><option value='<?php echo set_value('duration_dosage_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($durationdosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+instruction_row+"<textarea style='height:28px' name='instruction_"+prescription_rows+"' class=form-control id=description></textarea></div></div></div>";

      var table_row= "<tr id='row" + prescription_rows + "'><td>" + div + "</td><td><button type='button' onclick='delete_row("+prescription_rows+")' data-row-id='"+prescription_rows+"' class='closebtn delete_row'><i class='fa fa-remove'></i></button></td></tr>";
        //$(table).find('tbody').append(table_row);
        $('#tableID').append(table_row).find('.select2').select2();
      
 $('.modal-body',"#add_prescription").find('table#tableID').find('.select2').select2();
        prescription_rows++;
    });     

    function delete_row(id) {        
        var table = document.getElementById("tableID");
        var rowCount = table.rows.length;
        $("#row" + id).html("");       
    }

    $(document).ready(function (e) {
        $("#add_timeline").on('submit', (function (e) {
            $("#add_timelinebtn").button('loading');
            var patient_id = $("#patient_id").val();
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/timeline/add_patient_timeline") ?>",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/timeline/patient_timeline/' + patient_id,
                            success: function (res) {
                                $('#timeline_list').html(res);
                                $('#myTimelineModal').modal('toggle');
                            },
                            error: function () {
                                alert("Fail")
                            }
                        });
                    window.location.reload(true);
                    }
                    $("#add_timelinebtn").button('reset');
                },
                error: function (e) {
                    alert("Fail");                   
                }
            });
        }));
    });

    $(document).ready(function (e) {
        $("#edit_timeline").on('submit', (function (e) {
            $("#edit_timelinebtn").button('loading');
            var patient_id = $("#patient_id").val();
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/timeline/edit_patient_timeline") ?>",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#edit_timelinebtn").button('reset');
                },
                error: function (e) {
                    alert("Fail");
                    console.log(e);
                }
            });
        }));
    });

    function delete_timeline(id) {
        var patient_id = $("#patient_id").val();
        if (confirm('<?php echo $this->lang->line("delete_confirm") ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/timeline/delete_patient_timeline/' + id,
                success: function (res) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/timeline/patient_timeline/' + patient_id,
                        success: function (res) {

                            $('#timeline_list').html(res);
                            successMsg('<?php echo $this->lang->line('delete_message') ?>');
                        },
                        error: function () {
                            alert("Fail")
                        }
                    });
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }

    function view_prescription(visitid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/prescription/getPrescription/' + visitid,
            success: function (res) {
                $("#getdetails_prescription").html(res);
            },
            error: function () {
                alert("Fail")
            }
        });
        holdModal('prescriptionview');
    }

     function viewmanual_prescription(visitid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/prescription/getPrescriptionmanual/' + visitid ,
            success: function (res) {
                $("#getdetails_prescriptionmanual").html(res);
                $('#edit_deleteprescriptionmanual').html("<?php if ($this->rbac->hasPrivilege('prescription', 'can_view')) { ?><a href='#'' onclick='printprescriptionmanual(" + visitid + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>' title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a><?php } ?>");
            },
            error: function () {
                alert("Fail")
            }
        });
        holdModal('prescriptionviewmanual');
    }
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/animate.min.css">
<script type="text/javascript">
    $(document).ready(function () {
        $(".dshow").click(function () {
            $('.sidebarlists').fadeIn(1000);
            $('.sidebarlists').show();
            $('.dshow').hide();
            $('.sidebarlists').removeClass('animated slideInRight faster').addClass('animated slideInLeft faster');
            $('.dhide').show();
            $('.itemcol').removeClass('col-md-12').addClass('col-md-9');
        });

        $(".dhide").click(function () {
            $('.sidebarlists').fadeOut(1000);
            $('.sidebarlists').hide();
            $('.dshow').show();
            $('.dhide').hide();
            $('.sidebarlists').addClass('animated slideInLeft faster').removeClass('animated slideInRight faster');
            $('.itemcol').addClass('col-md-12').removeClass('col-md-9');
          
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('.select2').select2();
    });    

    $(document).ready(function (e) {
        $("#formrevisit").on('submit', (function (e) {
            $("#formrevisitbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addvisitDetails',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,               
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);                  
                    }

                    $("#formrevisitbtn").button('reset');
                },
                error: function () {
                    
                }
            });
        }));
    });

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function getRevisitRecord(visitid) 
    {      
        $('.select2-selection__rendered').html("");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getvisitDetails',
            type: "POST",
            data: {visitid: visitid},
            dataType: 'json',
            success: function (data) {               
                $("#patientname").html(data.patients_name);
                $('#guardian').html(data.guardian_name);
                $('#rgender').html(data.gender);
                $("#listnumber").html(data.mobileno);
                $("#remail").html(data.email);
                $("#rblood_group").html(data.blood_group_name);
                $("#raddress").html(data.address);
                $("#rmarital_status").html(data.marital_status);
                $("#rtpa_id").html(data.insurance_id);
                $("#rtpa_validity").html(data.tpa_validity);
                $("#ridentification_number").html(data.identification_number);
                $("#rallergies").html(data.any_known_allergies);
                $("#rnote").html(data.note);

                if(data.image !=null){
                    $("#patient_image").attr("src","<?php echo base_url(); ?>" +data.image+"<?php echo img_time(); ?>");
                }else{
                    $("#patient_image").attr("src","<?php echo base_url(); ?>uploads/patient_images/no_image.png");
                }

                var date_format = '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
                var dob_format = new Date(data.dob).toString(date_format);
                
                $("#rage").html(data.patient_age);
                $("#revisit_id").val(data.id);               
                $("#revisit_name").val(data.patient_name);                
                $('#revisit_guardian').val(data.guardian_name);
                $("#revisit_contact").val(data.mobileno);
                $("#revisit_date").val(data.appointment_date);
                $("#revisit_case").val(data.case_type);                
                $("#pid").val(data.patientid);
                $("#revisit_refference").val(data.refference);
                $("#revisit_email").val(data.email);               
                if (data.live_consult) {
                $("#live_consultvisit").val(data.live_consult);
                }             
                $("#esymptoms").val(data.symptoms);
                $("#revisit_age").val(data.age);
                $("#revisit_month").val(data.month);
                $("#revisit_height").val(data.height);
                $("#revisit_weight").val(data.weight);
                $("#revisit_bp").val(data.bp);
                $("#revisit_pulse").val(data.pulse);
                $("#revisit_temperature").val(data.temperature);
                $("#revisit_respiration").val(data.respiration);
                $("#revisit_blood_group").val(data.blood_group);
                $("#revisi_tax").val(data.tax);
                $("#revisit_address").val(data.address);
                $("#revisit_note").val(data.note);              
                $('select[id="revisit_old_patient"] option[value="' + data.old_patient + '"]').attr("selected", "selected");
                $('select[id="revisit_doctor"] option[value="' + data.cons_doctor + '"]').attr("selected", "selected");
                $('select[id="revisit_organisation"] option[value="' + data.organisation_id + '"]').attr("selected", "selected");

                $('select[id="revisit_organisation"]').attr("disabled", true);               
                holdModal('revisitModal');
            },
        })
    }

    function printprescription(visitid) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/prescription/printPrescription',
            type: 'GET',
            data: { visitid: visitid },
            dataType: "json",
            success: function (result) {               
                popup(result.page);
            }
        });
    }

    function printprescriptionmanual(visitid) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/prescription/getPrescriptionmanual/' + visitid,
            type: 'POST',
            data: {payslipid: visitid, print: 'yes'},           
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }
    function popup(data) {
        var base_url = '<?php echo base_url() ?>';
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');       
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }

    function deleteOpdPatientDiagnosis(patient_id, id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteOpdPatientDiagnosis/' + patient_id + '/' + id,
                success: function (res) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function deleteOpdPatientCharge(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteOpdPatientCharge/'+ id,
                success: function (res) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function deletePayment(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deletePayment/'+ id,
                success: function (res) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    var attr = {};

    $(document).ready(function (e) {
        $("#formdishrecord").on('submit', (function (e) {
            $("#formdishrecordbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_opddischarged_summary',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#formdishrecordbtn").button('reset');
                },
                error: function () {

                }
            });
        }));
    });

     function getMedicineName(id) {
        console.log(id);
        var category_selected = $("#medicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];
        div_data = '';
        $("#search-query" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#search-query' + id).select2("val", +id);
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_name",
            data: {'medicine_category_id': category_selected},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.medicine_name + "'>" + obj.medicine_name + "</option>";
                });
             
                $("#search-query" + id).html("<option value=''><?php echo $this->lang->line('select'); ?></option>");
                $('#search-query' + id).append(div_data);
                $('#search-query' + id).select2("val", '');
                getMedicineDosage(id);
            }
        });
    }
    ;

    function getMedicineDosage(id) {
        var category_selected = $("#medicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];
        div_data = '';
        $("#search-dosage" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_dosage",
            data: {'medicine_category_id': category_selected},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.dosage + "'>" + obj.dosage + "</option>";
                });
                $("#search-dosage" + id).html("<option value=''><?php echo $this->lang->line('select'); ?></option>");
                $('#search-dosage' + id).append(div_data);
            }
        });
    }

    function getcharge_category(id) {
        var div_data = "";
        $('#charge_category').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $("#charge_category").select2("val", 'l');

        $.ajax({
            url: '<?php echo base_url(); ?>admin/charges/get_charge_category',
            type: "POST",
            data: {charge_type: id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.name + "'>" + obj.name + "</option>";
                });
                $('#charge_category').html("<option value=''><?php echo $this->lang->line('select'); ?></option>");
                $('#charge_category').append(div_data);
                $("#charge_category").select2("val", '');
            }
        });
    }  

    function update_amount(apply_charge){
        var apply_amount=apply_charge;
        var tax_percentage=$('#percentage').val();
        if(tax_percentage !='' && tax_percentage !=0){
            apply_amount=(parseFloat(apply_charge) * tax_percentage/100)+(parseFloat(apply_charge));
                 $('#revisit_amount').val(apply_amount);
            }else{
                $('#revisit_amount').val(apply_amount);
            }
    }

    $(document).on('select2:select','.charge',function(){
        var charge=$(this).val();
        var orgid = $("#revisit_organisation").val();

      $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getChargeById',
            type: "POST",
            data: {charge_id: charge, organisation_id: orgid},
            dataType: 'json',
            success: function (res) {
                 if (res) { 
                    var tax=res.percentage;
                    var quantity=$('#qty').val();
                    $('#percentage').val(tax);
                    $('#apply_chargevisit').val(parseFloat(res.standard_charge) * quantity);
                    $('#standard_chargevisit').val(res.standard_charge);
                  
                    if (res.org_charge == null) {
                        if(res.percentage ==null){
                            apply_amount=parseFloat(res.standard_charge);
                        }else{
                            apply_amount=(parseFloat(res.standard_charge) * res.percentage/100)+(parseFloat(res.standard_charge));
                        }
                        
                        $('#apply_chargevisit').val(res.standard_charge);
                        $('#revisit_amount').val(apply_amount.toFixed(2));
                        $('#paid_amount').val(apply_amount.toFixed(2));
                       
                    } else {
                         if(res.percentage ==null){
                            apply_amount=parseFloat(res.org_charge);
                        }else{
                            apply_amount=(parseFloat(res.org_charge) * res.percentage/100)+(parseFloat(res.org_charge));
                        }
                       
                        $('#apply_chargevisit').val(res.org_charge);
                        $('#revisit_amount').val(apply_amount.toFixed(2));
                        $('#paid_amount').val(apply_amount.toFixed(2));
                      
                    }
                } else {
                   
                }
            }
        });
 });

    $(document).on('change','.charge_type',function(){
        var charge_type=$(this).val();     
        $('.charge_category').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
     getcharge_category(charge_type,"");
    });

    function getcharge_category(charge_type,charge_category) {
           var div_data = "";
           if(charge_type != ""){

        $.ajax({
            url: base_url+'admin/charges/get_charge_category',
            type: "POST",
            data: {charge_type: charge_type},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";
                });
                $('.charge_category').html("<option value=''><?php echo $this->lang->line('select'); ?></option>");
                $('.charge_category').append(div_data);
                $('.charge_category').select2("val", charge_category);
            }
        });
         }
    }
    
    $(document).on('change','.editcharge_type',function(){
        var charge_type=$(this).val();     
        $('.editcharge_category').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
     geteditcharge_category(charge_type,"");
    });

    function geteditcharge_category(charge_type,charge_category) {
           var div_data = "";
           if(charge_type != ""){

        $.ajax({
            url: base_url+'admin/charges/get_charge_category',
            type: "POST",
            data: {charge_type: charge_type},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";
                });
                $('.editcharge_category').html("<option value=''><?php echo $this->lang->line('select'); ?></option>");
                $('.editcharge_category').append(div_data);
                $('.editcharge_category').select2("val", charge_category);
            }
        });
         }
    }

 $(document).on('select2:select','.charge_category',function(){
        var charge_category=$(this).val();      
        $('.charge').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");   
        $('.addcharge').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
        getchargecode(charge_category,"");
 });

    function getchargecode(charge_category,charge_id) {      
      var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
      if(charge_category != ""){
          $.ajax({
            url: base_url+'admin/charges/getchargeDetails',
            type: "POST",
            data: {charge_category: charge_category},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";
                });
                $('.charge').html(div_data);
                $(".charge").select2("val", charge_id);
                $('.addcharge').html(div_data);
                $(".addcharge").select2("val", charge_id);             
            }
        });
      }
    }
    
$(document).on('select2:select','.editcharge_category',function(){
        var charge_category=$(this).val();      
        $('.charge').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");   
        $('.editcharge').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
        geteditchargecode(charge_category,"");
 });

    function geteditchargecode(charge_category,charge_id) {      
      var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
      if(charge_category != ""){
          $.ajax({
            url: base_url+'admin/charges/getchargeDetails',
            type: "POST",
            data: {charge_category: charge_category},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";
                });
                $('.charge').html(div_data);
                $(".charge").select2("val", charge_id);
                $('.editcharge').html(div_data);
                $(".editcharge").select2("val", charge_id);             
            }
        });
      }
    }

    $(document).ready(function (e) {
        $("#add_bill").on('submit', (function (e) {
            if (confirm('<?php echo $this->lang->line('are_you_sure')?>')) {
                $("#save_button").button('loading');
                e.preventDefault();
                $.ajax({
                    url: "<?php echo site_url("admin/payment/addopdbill") ?>",
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status == "fail") {
                            var message = "";
                            $.each(data.error, function (index, value) {
                                message += value;
                            });
                            errorMsg(message);
                        } else {
                            successMsg(data.message);
                            window.location.reload = true;
                        }
                        $("#save_button").button('reset');
                         location.reload();
                    },
                    error: function (e) {
                        alert("Fail");
                        console.log(e);
                    }
                });
            } else {
                return false;
            }

        }));
    });
 
    $(document).ready(function (e) {
        $("#add_charges button[type=submit]").click(function() {
        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

        $("#add_charges").on('submit', (function (e) {
            e.preventDefault();
            var $this = $("button[type=submit][clicked=true]");
            var form = $(this);
            var form_data = form.serializeArray();
            var button_val=$this.attr('value');
            form_data.push({name: "add_type", value: button_val});
            $.ajax({ 
                url: '<?php echo base_url(); ?>admin/charges/add_opdcharges',
                type: "post", 
                data: form_data,
                dataType: 'json',
                beforeSend: function () {
             $("#add_chargesbtn").button('loading');
               
            },
                success: function (res) {
                    if (res.status == "fail") {
                        var message = "";
                        $.each(res.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else if(res.status == "new_charge") {
                        var data=res.data;
                        var row_id=makeid(8);
                
                
                        var charge='<tr id="'+row_id+'"><td>'+data.date+'<input type="hidden" name="pre_date[]" value="'+data.date+'"></td><td>'+data.charge_type_name+'</td><td>'+data.charge_category+'</td><td>'+data.charge_name+'<input type="hidden" name="pre_charge_id[]" value="'+data.charge_id+'"><br><h6>'+data.note+'<input type="hidden" name="pre_note[]" value="'+data.note+'"></h6></td><td class="text-right">'+data.standard_charge+'<input type="hidden" name="pre_standard_charge[]" value="'+data.standard_charge+'"><input type="hidden" name="pre_tax_percentage[]" value="'+data.tax_percentage+'"></td><td class="text-right">'+data.tpa_charge+'<input type="hidden" name="pre_tpa_charges[]" value="'+data.tpa_charge+'"></td><td class="text-right">'+data.qty+'<input type="hidden" name="pre_qty[]" value="'+data.qty+'"></td><td class="text-right">'+data.amount+'<input type="hidden" name="pre_total[]" value="'+data.amount+'"></td><td class="text-right">'+data.tax+'<input type="hidden" name="pre_tax[]" value="'+data.tax+'"><input type="hidden" name="pre_apply_charge[]" value="'+data.apply_charge+'"></td><td class="text-right">'+data.net_amount+'<input type="hidden" name="pre_net_amount[]" value="'+data.net_amount+'"></td><td><button type="button" class="closebtn delete_row" data-row-id="'+row_id+'" data-record-id="'+data.charge_id+'" autocomplete="off"><i class="fa fa-remove"></i></button></td></tr>';
                        $('#preview_charges').append(charge);
                        
                       charge_reset();
                    }else{
                         successMsg(res.message);
                        window.location.reload(true);
                    }
                   
                },
                error: function () {
                    $("#add_chargesbtn").button('reset');
                },
                complete: function () {
                    $("#add_chargesbtn").button('reset');
                }
            });
        }));
    });

    $(document).on('click','.delete_row',function(e){       
        var del_row_id=$(this).data('rowId');
        var del_record_id=$(this).data('recordId');
        var result = confirm("<?php echo $this->lang->line('delete_confirm')?>");
        if (result) {
            $('#row'+del_row_id).remove();
        }

        if(del_record_id > 0){

                $.ajax({
                    url: "<?php echo site_url("admin/patient/deletemedicine"); ?>",
                        type: "POST",
                        data: {prescription_detail_id:del_record_id},
                        success:function(data)
                        {  }
                });
            }
  });

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   return result;
}

    function charge_reset(){
        $("#charge_category").select2("val", '');
        $("#add_charge_type").select2("val", '');
        $("#charge_id").select2("val", '');
        $("#addstandard_charge").val('');
        $("#addscd_charge").val('');
        $("#qty").val('');       
        $("#standard_charge").val('');
        $("#schedule_charge").val('');       
        $("#charge_date").val('');    
        $("#edit_note").val('');    
        $("#charge_tax").val('');    
        $("#tax").val('');    
        $("#final_amount").val('');    
        $("#apply_charge").val('');
        
    }
    
    $(document).ready(function (e) {
        $("#edit_charges").on('submit', (function (e) {
            e.preventDefault();
          let button_clicked = $("button[type=submit]",this);         
            $.ajax({
                url: base_url+'admin/charges/edit_opdcharges',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                 beforeSend: function(){
                 button_clicked.button("loading");
                 },
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                   button_clicked.button("reset");
                },
                 error: function () {
                button_clicked.button('reset');
                },
  
                complete: function(){
                button_clicked.button('reset');
                }
            });
        }));
    });
    
    $(document).ready(function (e) {
        $("#add_payment").on('submit', (function (e) {
            e.preventDefault();         
            $.ajax({
                url: base_url+'admin/payment/addOPDPayment',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                 beforeSend: function(){
                  $("#add_paymentbtn").button("loading");
                 },
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#add_paymentbtn").button("reset");
                },
                 error: function () {
                 $("#add_paymentbtn").button('reset');
                },
  
                complete: function(){
                 $("#add_paymentbtn").button('reset');
                }
            });
        }));
    });

    function calculate() {
        var discount_percent = $("#discount_percent").val();
        var tax_percent = $("#tax_percent").val();
        var other_charge = $("#other_charge").val();
        var paid_amount = $("#paid_amountpa").val();
        var total_amount = $("#total_amount").val();
        var subtotal_amount = parseFloat(total_amount) + parseFloat(other_charge);       

        if (discount_percent != '') {
            var discount = (subtotal_amount * discount_percent) / 100;
            $("#discount").val(discount.toFixed(2));
        } else {
            var discount = $("#discount").val();
        }

        if (tax_percent != '') {
            var tax = ((subtotal_amount - discount) * tax_percent) / 100;
            $("#tax").val(tax.toFixed(2));
        } else {
            var tax = $("#tax").val();
        }

        var gross_total = parseFloat(total_amount) + parseFloat(other_charge) + parseFloat(tax) - parseFloat(discount);
        var net_amount = parseFloat(total_amount) + parseFloat(other_charge) + parseFloat(tax) - parseFloat(discount);
        var net_amount_payble = parseFloat(net_amount) - parseFloat(paid_amount);
        $("#gross_total").val(gross_total.toFixed(2));
        $("#net_amount").val(net_amount.toFixed(2));
        $("#grass_amount").val(net_amount.toFixed(2));
        $("#grass_amount_span").html(net_amount.toFixed(2));
        $("#net_amount_span").html(net_amount_payble.toFixed(2));
        $("#net_amount_payble").val(net_amount_payble.toFixed(2));
        $("#save_button").show();
        $("#printBill").show();
    }

    function printBill(patientid, opdid) {
        var total_amount = $("#total_amount").val();
        var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        var gross_total = $("#gross_total").val();
        var tax = $("#tax").val();
        var net_amount = $("#net_amount").val();
        var status = $("#status").val();
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/payment/getOPDBill/',
            type: 'POST',
            data: {patient_id: patientid, opdid: opdid, total_amount: total_amount, discount: discount, other_charge: other_charge, gross_total: gross_total, tax: tax, net_amount: net_amount, status: status},
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }

</script>
<script type="text/javascript">
    $(document).on('change','.chgstatus_dropdown',function(){
        $(this).parent('form.chgstatus_form').submit()

    });

    $("form.chgstatus_form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           dataType:"JSON",
           success: function(data)
           {
               if (data.status == 0) {
                    var message = "";
                    $.each(data.error, function (index, value) {
                        message += value;
                    });
                    errorMsg(message);
                } else {
                    successMsg(data.message);
                    window.location.reload(true);
                }               
           }
         });
}); 

$(".addcharges").click(function(){  
    $('#add_charges').trigger("reset");     
    $('#select2-charge_category-container').html("");       
    $('#select2-code-container').html("");      
});

$(".revisitrecheckup").click(function(){    
    $('#formrevisit').trigger("reset");         
});

 $("#myPaymentModal").on('hidden.bs.modal', function (e) {
     $(".filestyle").next(".dropify-clear").trigger("click");    
     $('.cheque_div').css("display", "none");
     $('form#add_payment').find('input:text, input:password, input:file, textarea').val('');
     $('form#add_payment').find('select option:selected').removeAttr('selected');
     $('form#add_payment').find('input:checkbox, input:radio').removeAttr('checked');
 });

$(document).on('click','.addpayment',function(){     
       $('#myPaymentModal').modal('show');
});

$(".adddiagnosis").click(function(){    
    $('#form_diagnosis').trigger("reset");  
    $(".dropify-clear").trigger("click");
});

$(".addtimeline").click(function(){ 
    $('#add_timeline').trigger("reset");    
    $(".dropify-clear").trigger("click");
});

$(".prescription").click(function(){    
    $('#form_prescription').trigger("reset");
    $('#select2-medicine_cat0-container').html('');
    $('#select2-search-query0-container').html('');
    $('#select2-search-dosage0-container').html('');
    var table = document.getElementById("tableID");
    var table_len = (table.rows.length);    
    for (i = 1; i < table_len; i++) {           
        delete_row(i);
    }
});
</script>

<script type="text/javascript">
        $(document).ready(function(){
$("#radiologyOpt").select2({
   
    placeholder: 'Select',
    allowClear: false,
    minimumResultsForSearch: 2
});
$("#pathologyOpt").select2({
   
    placeholder: 'Select',
    allowClear: false,
    minimumResultsForSearch: 2
});
});     
</script>
<script type="text/javascript">
    $(document).on('change','.payment_mode',function(){
      var mode=$(this).val();

      if(mode == "Cheque"){
       
         $('.filestyle','#myPaymentModal').dropify();
       $(".date").trigger("change");
        $('.cheque_div').css("display", "block");
       
      }else{

        $('.cheque_div').css("display", "none");
      }
    });

    $(document).on('change','.visit_payment_mode',function(){
      var mode=$(this).val();

      if(mode == "Cheque"){
       
         $('.filestyle','#myPaymentModal').dropify();
       $(".date").trigger("change");
        $('.cheque_div').css("display", "block");
       
      }else{

        $('.cheque_div').css("display", "none");
      }
    });
       
     $(document).on('select2:select','.medicine_category',function(){      
      getMedicine($(this),$(this).val(),0);
       selected_medicine_category_id =$(this).val();   
       var medicine_dosage=getDosages(selected_medicine_category_id);
       $(this).closest('tr').find('.medicine_dosage').html(medicine_dosage);
    });

     function getMedicine(med_cat_obj,val,medicine_id){
      var medicine_colomn=med_cat_obj.closest('tr').find('.medicine_name');
        medicine_colomn.html("");    
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/get_medicine_name',
            type: "POST",
            data: {medicine_category_id: val},
            dataType: 'json',
              beforeSend: function() {
              medicine_colomn.html("<option value=''><?php echo $this->lang->line('loading') ?></option>");

            },
            success: function (res) {
                var div_data="<option value=''><?php echo $this->lang->line('select'); ?></option>";
                $.each(res, function (i, obj)
                {
                    var sel = "";
                            if (medicine_id == obj.id) {
                                sel = "selected";
                            }
                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.medicine_name + "</option>";

                });
           
                medicine_colomn.html(div_data);
                medicine_colomn.select2("val", medicine_id);
               
            }
        });
}
</script>

<script type="text/javascript">
   function getDosages(medicine_category_id){
    var dosage_opt="<option value=''><?php echo $this->lang->line('select') ?></option>";  
   var sss='<?php echo json_encode($category_dosage); ?>';
   var aaa=JSON.parse(sss);  
   if (aaa[medicine_category_id]){
    $.each(aaa[medicine_category_id], function(key, item) 
    {
      dosage_opt+="<option value='"+item.id+"'>"+item.dosage+"</option>";
    });
}
return dosage_opt;
   }
</script>

<script type="text/javascript">
           $(document).on('click','.print_visit',function(){
      var $this = $(this);
         var record_id=$this.data('recordId')
       $this.button('loading');
      $.ajax({
          url: '<?php echo base_url(); ?>admin/patient/printVisit',
          type: "POST",
          data:{'visit_detail_id':record_id},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(res) {
           popup(res.page);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
         complete: function() {
               $this.button('reset');
                 
         }
      });
  });

         $(document).on('click','.print_trans',function(){
      var $this = $(this);
         var record_id=$this.data('recordId')
       $this.button('loading');
      $.ajax({
          url: '<?php echo base_url(); ?>admin/transaction/printTransaction',
          type: "POST",
          data:{'id':record_id},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(res) {
           popup(res.page);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
              complete: function() {
                   $this.button('reset');                 
             }
      });
  });

         $(document).on('click','.print_charge',function(){    

      var $this = $(this);
         var record_id=$this.data('recordId')
       $this.button('loading');
      $.ajax({
          url: '<?php echo base_url(); ?>admin/patient/printCharge',
          type: "POST",
          data:{'id':record_id,'type':'opd'},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(res) {
           popup(res.page);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
              complete: function() {
                   $this.button('reset');
                 
             }
      });
  });

    $(document).on('change keyup input paste','#qty',function(){
        var quantity=$(this).val();
        var standard_charge=  $('#addstandard_charge').val();
        var schedule_charge= $('#addscd_charge').val();
        var tax_percent=$('#charge_tax').val();
        var total_charge=(schedule_charge == "" )? standard_charge:schedule_charge;
        var apply_charge=isNaN(parseFloat(total_charge)*parseFloat(quantity))?0 : parseFloat(total_charge)*parseFloat(quantity); 
        $('#apply_charge').val(apply_charge.toFixed(2));       
        var discount_percent= 0;
        var discount_amount= isNaN((apply_charge*discount_percent)/100) ? 0 : (apply_charge*discount_percent)/100;
        var final_amount=apply_charge-discount_amount;
        $('#discount').val(discount_amount);
        $('#tax').val(((final_amount*tax_percent)/100).toFixed(2));
        $('#final_amount').val((final_amount+((final_amount*tax_percent)/100)).toFixed(2));
    });

    $(document).on('change keyup input paste','#editqty',function(){
        var quantity=$(this).val();
        var standard_charge=  $('#editstandard_charge').val();
        var schedule_charge= $('#editscd_charge').val();      
        var tax_percent=$('#editcharge_tax').val();
        var total_charge=(schedule_charge == "" )? standard_charge:schedule_charge;
        var apply_charge=isNaN(parseFloat(total_charge)*parseFloat(quantity))?0 : parseFloat(total_charge)*parseFloat(quantity); 
        $('#editapply_charge').val(apply_charge.toFixed(2));       
        var discount_percent= 0;
        var discount_amount= isNaN((apply_charge*discount_percent)/100) ? 0 : (apply_charge*discount_percent)/100;
        var final_amount=apply_charge-discount_amount;
        $('#editdiscount').val(discount_amount);
        $('#edittax').val(((final_amount*tax_percent)/100).toFixed(2));
        $('#editfinal_amount').val((final_amount+((final_amount*tax_percent)/100)).toFixed(2));
    });
</script>

<script type="text/javascript">
  $(document).on('click','.edit_charge',function(){
        var edit_charge_id=$(this).data('recordId');
       var createModal=$('#edit_chargeModal');
       var $this = $(this);
       $this.button('loading');
      $.ajax({
          url: base_url+'admin/patient/getCharge',
          type: "POST",
          data:{'id':edit_charge_id},
          dataType: 'json',
           beforeSend: function() {
              $this.button('loading');
          },
          success: function(res) {     
         console.log(res.result);
        $('#editstandard_charge').val(res.result.standard_charge);
        if(res.result.tpa_charge>0){
        $('#editscd_charge').val(res.result.tpa_charge);
        }
        $('#editqty').val(res.result.qty);
        $('#editcharge_tax').val(res.result.percentage);
        $('#editapply_charge').val(res.result.apply_charge);
        $('#editfinal_amount').val(res.result.amount);
        $('#editcharge_date').val(res.result.charge_date);
        $('#editorg_id').val(res.result.org_charge_id);
        $('#editpatient_charge_id').val(res.result.id);
        var tax_charge=(res.result.apply_charge*res.result.percentage)/100;
        $('#edittax').val(tax_charge.toFixed(2));
        $('#edit_note').val(res.result.note);       
        $('#editcharge_type').select2('val',res.result.charge_type_master_id);
        $('#edit_chargeModal').modal({backdrop:'static'});
        geteditcharge_category(res.result.charge_type_master_id,res.result.charge_category_id);
        geteditchargecode(res.result.charge_category_id,res.result.charge_id);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
             $this.button('reset');
               
      },
      complete: function() {
            $this.button('reset');
     
      }
      });
  });
 
   $(document).on('select2:select','.addcharge',function(){
        var charge=$(this).val();
        var orgid=$('#editorganisation_id').val();
        $('#qty').val('1');
      $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getChargeById',
            type: "POST",
            data: {charge_id: charge, organisation_id: orgid},
            dataType: 'json',
            success: function (res) {
                if (res) {
                    var quantity=$('#qty').val();
                    $('#apply_charge').val(parseFloat(res.standard_charge) * quantity);
                    $('#addstandard_charge').val(res.standard_charge);
                    $('#addscd_charge').val(res.org_charge);
                    $('#charge_tax').val(res.percentage);
                    var standard_charge= res.standard_charge;
                    var schedule_charge= res.org_charge;
                    var discount_percent= 0;
                    var total_charge=(schedule_charge == null )? standard_charge:schedule_charge;
                    var apply_charge=isNaN(parseFloat(total_charge)*parseFloat(quantity))?0 : parseFloat(total_charge)*parseFloat(quantity);
                    var discount_amount= (apply_charge*discount_percent)/100;
                    $('#apply_charge').val(apply_charge.toFixed(2));
                    var final_amount=apply_charge-discount_amount;
                    $('#tax').val(((final_amount*res.percentage)/100).toFixed(2));
                    $('#final_amount').val((final_amount+((final_amount*res.percentage)/100)).toFixed(2));
                }
            }
        });
 });
 
 $(document).on('select2:select','.editcharge',function(){
        var charge=$(this).val();
        var orgid=$('#organisation_id').val();
        
      $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getChargeById',
            type: "POST",
            data: {charge_id: charge, organisation_id: orgid},
            dataType: 'json',
            success: function (res) {
                if (res) {
                    var quantity=$('#editqty').val();
                    $('#editapply_charge').val(parseFloat(res.standard_charge) * quantity);
                    $('#editstandard_charge').val(res.standard_charge);
                    $('#editscd_charge').val(res.org_charge);
                    $('#editcharge_tax').val(res.percentage);
                    var standard_charge= res.standard_charge;
                    var schedule_charge= res.org_charge;
                    var discount_percent= 0;
                    var total_charge=(schedule_charge == null )? standard_charge:schedule_charge;
                    var apply_charge=isNaN(parseFloat(total_charge)*parseFloat(quantity))?0 : parseFloat(total_charge)*parseFloat(quantity);
                    var discount_amount= (apply_charge*discount_percent)/100;
                    $('#editapply_charge').val(apply_charge.toFixed(2));
                    var final_amount=apply_charge-discount_amount;
                    $('#edittax').val(((final_amount*res.percentage)/100).toFixed(2));
                    $('#editfinal_amount').val((final_amount+((final_amount*res.percentage)/100)).toFixed(2));
                }
            }
        });
 });

   $(document).on('change','.death_status',function(){
      var status=$(this).val();
      if(status == "1"){
         $('.filestyle','#addPaymentModal').dropify();
          $('.filestyle','#add_refund').dropify();
        $('.death_status_div').css("display", "block");
        $('.reffer_div').css("display", "none");
      }else if(status == "2"){
        $('.reffer_div').css("display", "block");
         $('.death_status_div').css("display", "none");
      }else{
        $('.reffer_div').css("display", "none");
         $('.death_status_div').css("display", "none");
      }
    });

    $(document).on('click','.patient_discharge',function(){             
            var case_reference_id="<?php echo $case_reference_id;?>";
            var payment_modal=$('#patient_discharge');
            payment_modal.addClass('modal_loading'); 
            payment_modal.modal('show'); 
            $.ajax({
            url: base_url+'admin/bill/patient_discharge/'+case_reference_id,
            type: "POST",
            data:{'module_type':'opd'},
            dataType: 'json',
               beforeSend: function() {
               
               }, 
            success: function (data) {              
                
           $('.modal-body',payment_modal).html(data.page);
           $('.filestyle','#patient_discharge').dropify();
           $('.date','#patient_discharge').trigger("change");
              payment_modal.removeClass('modal_loading'); 
            },

             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");            
               
      },
      complete: function() {
            payment_modal.removeClass('modal_loading'); 
     
      }
        });        
    });

    $(document).on('submit','#patient_discharge', function(e){
            e.preventDefault();
            var clicked_btn = $("button[type=submit]");           

            var form = $(this);    
            var btn = clicked_btn;
            btn.button('loading');
            $.ajax({
                url: form.attr('action'),
                 type: "POST",                   
                data: new FormData(this),
                dataType: 'json',
                contentType: false,              
                processData: false,            
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                        }
                     btn.button('reset');
                },
                error: function () {

                },
                complete: function(){
                 btn.button('reset');
   }
            }); 
        });

    $(document).on('click','.print_dischargecard',function(){
         var $this = $(this);
         var record_id=$this.data('recordId');
         var case_id=$this.data('case_id');   
       $this.button('loading');
      $.ajax({
          url: '<?php echo base_url(); ?>admin/bill/print_dischargecard',
          type: "POST",
          data:{'id':record_id,'case_id':case_id,'module_type':'opd'},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(res) {
           popup(res.page);
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
              complete: function() {
                   $this.button('reset');                 
             }
      });
  }); 

    $(document).on('click','.viewot',function(){
         var $this = $(this);
         var record_id=$this.data('recordId');          
       $this.button('loading');
      $.ajax({
              url: base_url+'admin/operationtheatre/otdetails',
          type: "POST",
           data: {ot_id: record_id},
          dataType: 'json',
           beforeSend: function() {
                 $this.button('loading');
      
          },
          success: function(data) {
               $('#view_ot_modal').modal('show');
               $('#show_ot_data').html(data.page);     
               $('#action_detail_modal').html(data.actions); 
          },
             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                  $this.button('reset');
              
         },
              complete: function() {
                   $this.button('reset');                 
             }
      });
  });
    
    $(document).ready(function (e) {
        $('#patient_discharge').modal({
            backdrop: 'static',
            keyboard: false,
            show:false
        });
    }); 
</script>
<script>
    function getcategory(id,operation=null) {       
        var div_data = "";
        $('#operation_name').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/getoperationbycategory',
            type: "POST",
            data: {id:id},
            dataType: 'json',
            async: false,
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    if ((operation != '') && (operation == obj.id)) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.operation + "</option>";
                });
                $("#operation_name").html("<option value=''>Select</option>");
                $('#operation_name').append(div_data);
                $("#operation_name").select2().select2('val', operation);
                if(operation!=""){
                    $("#eoperation_name").html("<option value=''>Select</option>");
                    $('#eoperation_name').append(div_data);
                    $("#eoperation_name").select2().select2('val', operation);
                }
            }
        });
    }
</script>

<script>
     $(document).on('click','.view_report',function(){
         var id=$(this).data('recordId');
         var lab=$(this).data('typeId');
         getinvestigationparameter(id,$(this),lab);
       });

        function getinvestigationparameter(id,btn_obj,lab){
         var modal_view=$('#viewDetailReportModal');
         var $this = btn_obj;   
        $.ajax({
            url: base_url+'admin/patient/getinvestigationparameter',
            type: "POST",
            data: {'id': id,'lab':lab},
            dataType: 'json',
            beforeSend: function() {
              $this.button('loading');
                modal_view.addClass('modal_loading');
                
               },
            success: function (data) {                      
             $('#viewDetailReportModal .modal-body').html(data.page);  
             $('#viewDetailReportModal #action_detail_report_modal').html(data.actions);
             $('#viewDetailReportModal').modal('show');
              modal_view.removeClass('modal_loading');
            },

             error: function(xhr) { // if error occured
             alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
             $this.button('reset');
                modal_view.removeClass('modal_loading');
           },
           complete: function() {
            $this.button('reset');
                modal_view.removeClass('modal_loading');
          
           }
        });  
        }
</script>

<script type="text/javascript">
    $(document).on('click','.print_bill',function(){
    var id=$(this).data('recordId');
      
        var $this = $(this);
        var lab   = $(this).data('typeId');
        $.ajax({
            url: base_url+'admin/patient/printpathoparameter',
            type: "POST",
            data: {'id': id,'lab':lab},
            dataType: 'json',
               beforeSend: function() {
              $this.button('loading');               
               },
            success: function (data) {      
           popup(data.page);
            },

             error: function(xhr) { // if error occured
          alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
             $this.button('reset');
               
      },
      complete: function() {
            $this.button('reset');
     
      }
        });
    });
</script>

<script>    
    $(document).on('change', '.findingtype', function () {
        $this = $(this);
       
        var section_ul = $(this).closest('div.row').find('ul.section_ul');
        var finding_id = $(this).val();
        div_data="";
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/findingbycategory',
            data: {'finding_id': finding_id},
            dataType: 'JSON',
            
            beforeSend: function () {
                // setting a timeout
                $('ul.section_ul').find('li:not(:first-child)').remove();
            },
            success: function (data) {
                section_ul.append(data.record);

            },
            error: function (xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

            },
            complete: function () {

            }            
        });
    });
   
    $(document).on('change', '.findinghead', function () {

        $this = $(this);
        var head_id = $(this).val();
        div_data="";
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/getfinding',
            data: {'head_id': head_id},            
            success: function (res) {              
                $("#finding_description").val(res);
               
            },            
        });
    });

    $('.close_button').click(function(){
        $('#form_operationtheatre')[0].reset();
        $("#operation_category").select2().select2('val', '');
        $("#operation_name").select2().select2('val', '');
        $("#consultant_doctorid").select2().select2('val', '');
    })
</script> 

<script type="text/javascript">
    function delete_prescription(visitid) {   
        if (confirm('Are you sure')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/prescription/deletePrescription/'+visitid,
                success: function (res) {
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }

    $(document).ready(function (e) {
        $('#viewDetailReportModal').modal({
        backdrop: 'static',
        keyboard: false,
        show:false
        });
    });
 
    function discharge_revert(case_id){
        var base_url = '<?php echo base_url() ?>';      
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/bill/discharge_revert',
            data: {'module_type': 'opd','case_id':case_id},
            dataType: 'json',
            
            success: function (res) {              
             if(res.status=='success'){
                successMsg(res.message);
                window.location.reload(true);
             }else{
                errorMsg(res.message);
             }
            },            
        });
    } 

    $(document).on('change','.revisit_payment_mode',function(){
      var mode=$(this).val();
      if(mode == "Cheque"){
         $('.filestyle','#revisitModal').dropify();
       $(".date").trigger("change");
        $('.revisit_cheque_div').css("display", "block");
       
      }else{
        $('.revisit_cheque_div').css("display", "none");
      }
    }); 
</script>

<script type="text/javascript">    

       $(".patient_dob").on('changeDate', function(event, date) {          
           var birth_date = $(".patient_dob").val();
           
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/getpatientage',
                type: "POST",
                dataType: "json",
                data: {birth_date:birth_date},
                success: function (data) {
                  $('.patient_age_year').val(data.year); 
                  $('.patient_age_month').val(data.month);
                  $('.patient_age_day').val(data.day);
                }
           });
});     
   
</script> 
<script>
    $(document).on('click','.editpayment',function(){
         var $this = $(this);
         var record_id = $this.data('recordId'); 
         var amount    =  $this.data('paymentAmount'); 
         $("#edit_payment").val(amount);
          $("#edit_payment_id").val(record_id);
          $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/getopdpaymentdetails',
                type: 'post',
                data: {'payment_id':record_id},
                dataType: 'json',
                success: function (data) {
                    $("#payment_mode").val(data.payment_mode).prop('selected');

                      $(".payment_mode").trigger('change');
                      $("#edit_cheque_no").val(data.cheque_no);
                      $("#edit_cheque_date").val(data.cheque_date);
                      $("#payment_date").val(data.payment_date);
                      $("#edit_payment_note").val(data.note);
                }
           });
            
         $('#editpayment_modal').modal('show');
       //$this.button('loading');
     
  });
</script>
<script>

    
    $(document).ready(function (e) {
        $("#editpaymentform").on('submit', (function (e) {
            e.preventDefault();
            $("#editpaymentbtn").button('loading');
            var payment_id = $("#edit_payment_id").val();
            var payment = $("#edit_payment").val();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/editpayment',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                 beforeSend: function(){
                  $("#editpaymentbtn").button('loading');
                 },
                success: function (data) {
                    if (data.status == 0) {
                        var message = data.message;
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#editpaymentbtn").button('reset');
                },
                error: function () {
                 $("#editpaymentbtn").button('reset');
                },
  
                complete: function(){
                $("#editpaymentbtn").button('reset');
                }
            });
        }));
    });
    
</script>
<!-- //========datatable end===== -->
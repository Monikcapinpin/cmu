<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3 bgv">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Instructor Information</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="student_info-teacheradding-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-vertical needs-validation" action="<?php print_link("student_info/teacheradding?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <label class="control-label" for="Inst_id">Instructor ID (Auto Generated) <span class="text-danger">*</span></label>
                                    <div id="ctrl-Inst_id-holder" class=""> 
                                        <input id="ctrl-Inst_id"  value="<?php  echo $this->set_field_value('Inst_id',random_num(10)); ?>" type="number" placeholder="Enter Instructor ID (Auto Generated)" step="1"  readonly required="" name="Inst_id"  class="form-control " />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label class="control-label" for="Firstname">Firstname <span class="text-danger">*</span></label>
                                            <div id="ctrl-Firstname-holder" class=""> 
                                                <input id="ctrl-Firstname"  value="<?php  echo $this->set_field_value('Firstname',""); ?>" type="text" placeholder="Enter Firstname"  required="" name="Firstname"  class="form-control " />
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label" for="Middlename">Middlename <span class="text-danger">*</span></label>
                                                <div id="ctrl-Middlename-holder" class=""> 
                                                    <input id="ctrl-Middlename"  value="<?php  echo $this->set_field_value('Middlename',""); ?>" type="text" placeholder="Enter Middlename"  required="" name="Middlename"  class="form-control " />
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="control-label" for="Lastname">Lastname <span class="text-danger">*</span></label>
                                                    <div id="ctrl-Lastname-holder" class=""> 
                                                        <input id="ctrl-Lastname"  value="<?php  echo $this->set_field_value('Lastname',""); ?>" type="text" placeholder="Enter Lastname"  required="" name="Lastname"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label class="control-label" for="Email">Email Address <span class="text-danger">*</span></label>
                                                    <div id="ctrl-Email-holder" class=""> 
                                                        <input id="ctrl-Email"  value="<?php  echo $this->set_field_value('Email',""); ?>" type="email" placeholder="Enter Email Address"  required="" name="Email"  data-url="api/json/student_info_Email_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                            <div class="check-status"></div> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="control-label" for="Username">Username <span class="text-danger">*</span></label>
                                                        <div id="ctrl-Username-holder" class=""> 
                                                            <input id="ctrl-Username"  value="<?php  echo $this->set_field_value('Username',""); ?>" type="text" placeholder="Enter Username"  required="" name="Username"  data-url="api/json/student_info_Username_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                                <div class="check-status"></div> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label class="control-label" for="Password">Password <span class="text-danger">*</span></label>
                                                            <div id="ctrl-Password-holder" class="input-group"> 
                                                                <input id="ctrl-Password"  value="<?php  echo $this->set_field_value('Password',""); ?>" type="password" placeholder="Enter Password"  required="" name="Password"  class="form-control  password password-strength" />
                                                                    <div class="input-group-append cursor-pointer btn-toggle-password">
                                                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="password-strength-msg">
                                                                    <small class="font-weight-bold">Should contain</small>
                                                                    <small class="length chip">6 Characters minimum</small>
                                                                    <small class="caps chip">Capital Letter</small>
                                                                    <small class="number chip">Number</small>
                                                                    <small class="special chip">Symbol</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label class="control-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                                                <div id="ctrl-confirm_password-holder" class="input-group"> 
                                                                    <input id="ctrl-Password-confirm" data-match="#ctrl-Password"  class="form-control password-confirm " type="password" name="confirm_password" required placeholder="Confirm Password" />
                                                                    <div class="input-group-append cursor-pointer btn-toggle-password">
                                                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Password does not match
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label class="control-label" for="Photo">Profile Picture <span class="text-danger">*</span></label>
                                                                <div id="ctrl-Photo-holder" class=""> 
                                                                    <div class="dropzone required" input="#ctrl-Photo" fieldname="Photo"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                                        <input name="Photo" id="ctrl-Photo" required="" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('Photo',""); ?>" type="text"  />
                                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label class="control-label" for="Roles">Roles <span class="text-danger">*</span></label>
                                                                    <div id="ctrl-Roles-holder" class=""> 
                                                                        <select required=""  id="ctrl-Roles" name="Roles"  placeholder="Select a value ..."    class="custom-select" >
                                                                            <option value="">Select a value ...</option>
                                                                            <?php
                                                                            $Roles_options = Menu :: $Roles;
                                                                            if(!empty($Roles_options)){
                                                                            foreach($Roles_options as $option){
                                                                            $value = $option['value'];
                                                                            $label = $option['label'];
                                                                            $selected = $this->set_field_selected('Roles', $value, "Teacher");
                                                                            ?>
                                                                            <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                                <?php echo $label ?>
                                                                            </option>                                   
                                                                            <?php
                                                                            }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <input id="ctrl-Name"  value="<?php  echo $this->set_field_value('Name',""); ?>" type="hidden" placeholder="Enter Name"  required="" name="Name"  class="form-control " />
                                                                </div>
                                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                    <div class="form-ajax-status"></div>
                                                                    <button class="btn btn-primary" type="submit">
                                                                        Submit
                                                                        <i class="fa fa-send"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

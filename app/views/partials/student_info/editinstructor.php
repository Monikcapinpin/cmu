<?php
$comp_model = new SharedController;
$page_element_id = "edit-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="edit"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-vertical needs-validation" action="<?php print_link("student_info/editinstructor/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label class="control-label" for="Firstname">Firstname <span class="text-danger">*</span></label>
                                        <div id="ctrl-Firstname-holder" class=""> 
                                            <input id="ctrl-Firstname"  value="<?php  echo $data['Firstname']; ?>" type="text" placeholder="Enter Firstname"  required="" name="Firstname"  class="form-control " />
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label class="control-label" for="Middlename">Middlename <span class="text-danger">*</span></label>
                                            <div id="ctrl-Middlename-holder" class=""> 
                                                <input id="ctrl-Middlename"  value="<?php  echo $data['Middlename']; ?>" type="text" placeholder="Enter Middlename"  required="" name="Middlename"  class="form-control " />
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label" for="Lastname">Lastname <span class="text-danger">*</span></label>
                                                <div id="ctrl-Lastname-holder" class=""> 
                                                    <input id="ctrl-Lastname"  value="<?php  echo $data['Lastname']; ?>" type="text" placeholder="Enter Lastname"  required="" name="Lastname"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="control-label" for="Photo">Profile Picture <span class="text-danger">*</span></label>
                                                <div id="ctrl-Photo-holder" class=""> 
                                                    <div class="dropzone required" input="#ctrl-Photo" fieldname="Photo"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                        <input name="Photo" id="ctrl-Photo" required="" class="dropzone-input form-control" value="<?php  echo $data['Photo']; ?>" type="text"  />
                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <?php Html :: uploaded_files_list($data['Photo'], '#ctrl-Photo'); ?>
                                                </div>
                                                <div class="form-group ">
                                                    <label class="control-label" for="Name">Name <span class="text-danger">*</span></label>
                                                    <div id="ctrl-Name-holder" class=""> 
                                                        <input id="ctrl-Name"  value="<?php  echo $data['Name']; ?>" type="text" placeholder="Enter Name"  required="" name="Name"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-ajax-status"></div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-primary" type="submit">
                                                        Update
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

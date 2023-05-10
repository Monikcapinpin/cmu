    <?php
    $comp_model = new SharedController;
    $view_data = $this->view_data; //array of all  data passed from controller
    $field_name = $view_data['field_name'];
    $field_value = $view_data['field_value'];
    $form_data = $this->form_data; //request pass to the page as form fields values
    $can_list = ACL::is_allowed("attendance_record/list/Student_Name/$field_value");$can_list_att = ACL::is_allowed("attendance_record/list_att/Student_Name/$field_value");
    $page_id = random_str(6);
    ?>
    <div class="master-detail-page">
        <div class="card-header p-0 pt-2 px-2">
            <ul class="nav nav-tabs">
                <?php if($can_list){ ?>
                <li class="nav-item">
                    <a data-toggle="tab" href="#attendance_record_attendance_record_List_<?php echo $page_id ?>" class="nav-link active">
                        List
                    </a>
                </li>
                <?php } ?>
                <?php if($can_list_att){ ?>
                <li class="nav-item">
                    <a data-toggle="tab" href="#attendance_record_attendance_record_list_att_<?php echo $page_id ?>" class="nav-link ">
                        List Att
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php if($can_list){ ?>
            <div class="tab-pane fade show active show" id="attendance_record_attendance_record_List_<?php echo $page_id ?>" role="tabpanel">
                <?php $this->render_page("attendance_record/list/Student_Name/$field_value"); ?>
            </div>
            <?php } ?>
            <?php if($can_list_att){ ?>
            <div class="tab-pane fade show " id="attendance_record_attendance_record_list_att_<?php echo $page_id ?>" role="tabpanel">
                <?php $this->render_page("attendance_record/list_att/Student_Name/$field_value"); ?>
            </div>
            <?php } ?>
        </div>
    </div>
    
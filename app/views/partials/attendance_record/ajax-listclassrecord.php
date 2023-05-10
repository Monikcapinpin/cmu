<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("attendance_record/add");
$can_edit = ACL::is_allowed("attendance_record/edit");
$can_view = ACL::is_allowed("attendance_record/view");
$can_delete = ACL::is_allowed("attendance_record/delete");
?>
<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
<!--record-->
<?php
$counter = 0;
foreach($records as $data){
$rec_id = (!empty($data['ID']) ? urlencode($data['ID']) : null);
$counter++;
?>
<tr>
    <?php if($can_delete){ ?>
    <th class=" td-checkbox">
        <label class="custom-control custom-checkbox custom-control-inline">
            <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['ID'] ?>" type="checkbox" />
                <span class="custom-control-label"></span>
            </label>
        </th>
        <?php } ?>
        <th class="td-sno"><?php echo $counter; ?></th>
        <td class="td-student_info_Inst_id">
            <span <?php if($can_edit){ ?> data-value="<?php echo $data['student_info_Inst_id']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Inst_id" 
                data-title="Enter Student ID" 
                data-placement="left" 
                data-toggle="click" 
                data-type="number" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['student_info_Inst_id']; ?> 
            </span>
        </td>
        <td class="td-Student_Name">
            <a size="sm" class="btn btn-white page-modal" href="<?php print_link("attendance_record/history/Student_Name/" . urlencode($data['Student_Name'])) ?>">
                <i class="fa fa-eye"></i> <?php echo $data['Student_Name'] ?>
            </a>
        </td>
        <td class="td-Att_Date">
            <span <?php if($can_edit){ ?> data-flatpickr="{altFormat: 'F j, Y', enableTime: false, minDate: '', maxDate: ''}" 
                data-value="<?php echo $data['Att_Date']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Att_Date" 
                data-title="Enter Attendance Date" 
                data-placement="left" 
                data-toggle="click" 
                data-type="flatdatetimepicker" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Att_Date']; ?> 
            </span>
        </td>
        <td class="td-Att_Time">
            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Att_Time']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Att_Time" 
                data-title="Enter Attendance Time" 
                data-placement="left" 
                data-toggle="click" 
                data-type="time" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Att_Time']; ?> 
            </span>
        </td>
        <td class="td-Instructor">
            <span <?php if($can_edit){ ?> data-source='<?php print_link('api/json/attendance_record_Instructor_option_list'); ?>' 
                data-value="<?php echo $data['Instructor']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Instructor" 
                data-title="Enter Instructor" 
                data-placement="left" 
                data-toggle="click" 
                data-type="text" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Instructor']; ?> 
            </span>
        </td>
        <td class="td-Subject">
            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Subject']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Subject" 
                data-title="Enter Subject" 
                data-placement="left" 
                data-toggle="click" 
                data-type="text" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Subject']; ?> 
            </span>
        </td>
        <td class="td-Status"><?php $ins = $data['Status']; 
            if($ins == "Late"){
            ?>
            <span style="color: red;"> <?php echo $data['Status']; ?> </span>
            <?php
            }else{
            ?>
            <span style="color: blue;"> <?php echo $data['Status']; ?> </span>
            <?php
            }
        ?></td>
        <td class="td-Semester">
            <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $Semester); ?>' 
                data-value="<?php echo $data['Semester']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Semester" 
                data-title="Select a value ..." 
                data-placement="left" 
                data-toggle="click" 
                data-type="select" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Semester']; ?> 
            </span>
        </td>
        <th class="td-btn">
            <?php if($can_view){ ?>
            <a class="btn btn-sm btn-success has-tooltip page-modal" title="View Record" href="<?php print_link("attendance_record/view/$rec_id"); ?>">
                <i class="fa fa-eye"></i> View
            </a>
            <?php } ?>
            <?php if($can_delete){ ?>
            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("attendance_record/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                <i class="fa fa-times"></i>
                Delete
            </a>
            <?php } ?>
        </th>
    </tr>
    <?php 
    }
    ?>
    <?php
    } else {
    ?>
    <td class="no-record-found col-12" colspan="100">
        <h4 class="text-muted text-center ">
            No Record Found
        </h4>
    </td>
    <?php
    }
    ?>
    
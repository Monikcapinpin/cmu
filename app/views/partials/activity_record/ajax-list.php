<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("activity_record/add");
$can_edit = ACL::is_allowed("activity_record/edit");
$can_view = ACL::is_allowed("activity_record/view");
$can_delete = ACL::is_allowed("activity_record/delete");
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
        <td class="td-Student_Name">
            <span <?php if($can_edit){ ?> data-source='<?php print_link('api/json/activity_record_Student_Name_option_list'); ?>' 
                data-value="<?php echo $data['Student_Name']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Student_Name" 
                data-title="Enter Student Name" 
                data-placement="left" 
                data-toggle="click" 
                data-type="text" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Student_Name']; ?> 
            </span>
        </td>
        <td class="td-Att_Date">
            <span <?php if($can_edit){ ?> data-flatpickr="{altFormat: 'M-d-Y', enableTime: false, minDate: '', maxDate: ''}" 
                data-value="<?php echo $data['Att_Date']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
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
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
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
        <td class="td-Activity">
            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Activity']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Activity" 
                data-title="Enter Activity" 
                data-placement="left" 
                data-toggle="click" 
                data-type="text" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Activity']; ?> 
            </span>
        </td>
        <td class="td-Organization">
            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Organization']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
                data-name="Organization" 
                data-title="Enter Organization" 
                data-placement="left" 
                data-toggle="click" 
                data-type="text" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" <?php } ?>>
                <?php echo $data['Organization']; ?> 
            </span>
        </td>
        <td class="td-Semester">
            <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $Semester); ?>' 
                data-value="<?php echo $data['Semester']; ?>" 
                data-pk="<?php echo $data['ID'] ?>" 
                data-url="<?php print_link("activity_record/editfield/" . urlencode($data['ID'])); ?>" 
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
            <a class="btn btn-sm btn-success has-tooltip page-modal" title="View Record" href="<?php print_link("activity_record/view/$rec_id"); ?>">
                <i class="fa fa-eye"></i> 
            </a>
            <?php } ?>
            <?php if($can_edit){ ?>
            <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("activity_record/edit/$rec_id"); ?>">
                <i class="fa fa-edit"></i> 
            </a>
            <?php } ?>
            <?php if($can_delete){ ?>
            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("activity_record/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                <i class="fa fa-times"></i>
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
    
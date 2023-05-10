<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("student_info/add");
$can_edit = ACL::is_allowed("student_info/edit");
$can_view = ACL::is_allowed("student_info/view");
$can_delete = ACL::is_allowed("student_info/delete");
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
        <td class="td-Inst_id"> <?php echo $data['Inst_id']; ?></td>
        <td class="td-Name"> <?php echo $data['Name']; ?></td>
        <td class="td-Program"> <?php echo $data['Program']; ?></td>
        <td class="td-Block"> <?php echo $data['Block']; ?></td>
        <td class="td-Year"> <?php echo $data['Year']; ?></td>
        <td class="td-Roles"> <?php echo $data['Roles']; ?></td>
        <td class="td-Email"><a href="<?php print_link("mailto:$data[Email]") ?>"><?php echo $data['Email']; ?></a></td>
        <th class="td-btn">
            <?php if($can_view){ ?>
            <a class="btn btn-sm btn-success has-tooltip page-modal" title="View Record" href="<?php print_link("student_info/view/$rec_id"); ?>">
                <i class="fa fa-eye"></i> 
            </a>
            <?php } ?>
            <?php if($can_edit){ ?>
            <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("student_info/edit/$rec_id"); ?>">
                <i class="fa fa-edit"></i> 
            </a>
            <?php } ?>
            <?php if($can_delete){ ?>
            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("student_info/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
    
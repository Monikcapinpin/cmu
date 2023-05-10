<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("instructor/add");
$can_edit = ACL::is_allowed("instructor/edit");
$can_view = ACL::is_allowed("instructor/view");
$can_delete = ACL::is_allowed("instructor/delete");
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
$rec_id = (!empty($data['']) ? urlencode($data['']) : null);
$counter++;
?>
<div class="col-md-2">
    <div class="bg-light p-2 mb-3 animated bounceIn">
        <div class="mb-2">  <?php Html :: page_img($data['Photo'],180,180,1); ?></div>
        <div class="mb-2">  
            <span class="font-weight-light text-muted ">
                Name:  
            </span>
        <?php echo $data['Name']; ?></div>
        <div class="mb-2">  
            <span class="font-weight-light text-muted ">
                Roles:  
            </span>
        <?php echo $data['Roles']; ?></div>
    </div>
</div>
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

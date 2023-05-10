<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("instructor1/add");
$can_edit = ACL::is_allowed("instructor1/edit");
$can_view = ACL::is_allowed("instructor1/view");
$can_delete = ACL::is_allowed("instructor1/delete");
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
<tr>
    <th class="td-sno"><?php echo $counter; ?></th>
    <td class="td-Photo"><?php Html :: page_img($data['Photo'],50,50,1); ?></td>
    <td class="td-Name"> <?php echo $data['Name']; ?></td>
    <td class="td-Roles"> <?php echo $data['Roles']; ?></td>
    <td class="td-Email"><a href="<?php print_link("mailto:$data[Email]") ?>"><?php echo $data['Email']; ?></a></td>
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

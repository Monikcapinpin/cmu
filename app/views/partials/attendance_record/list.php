<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("attendance_record/add");
$can_edit = ACL::is_allowed("attendance_record/edit");
$can_view = ACL::is_allowed("attendance_record/view");
$can_delete = ACL::is_allowed("attendance_record/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <div  class="">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 comp-grid">
                </div>
            </div>
        </div>
    </div>
    <div  class="">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col comp-grid">
                    <div class=" ">
                        <?php  
                        $this->render_page("attendance_record/listclassrecord?limit_count=20"); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3 bg-transparent bgv">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Attendance Record</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <?php $modal_id = "modal-" . random_str(); ?>
                    <button data-toggle="modal" data-target="#<?php  echo $modal_id ?>"  class="btn btn btn-primary my-1">
                        <i class="fa fa-plus"></i>                                  
                        Add New Attendance Record 
                    </button>
                    <div data-backdrop="true" id="<?php  echo $modal_id ?>" class="modal fade"  role="dialog" aria-labelledby="<?php  echo $modal_id ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body p-0 reset-grids">
                                    <div class=" ">
                                        <?php  
                                        $this->render_page("attendance_record/add"); 
                                        ?>
                                    </div>
                                </div>
                                <div style="top: 5px; right:5px; z-index: 999;" class="position-absolute">
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('attendance_record/'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if(!empty($field_name) || !empty($_GET['search'])){
                            ?>
                            <hr class="sm d-block d-sm-none" />
                            <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                <ul class="breadcrumb m-0 p-1">
                                    <?php
                                    if(!empty($field_name)){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('attendance_record'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                        <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                    </li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(get_value("search")){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('attendance_record'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-capitalize">
                                        Search
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <!--End of Page bread crumbs components-->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div  class="bg-light p-3 mb-3 bg-transparent bgv">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col comp-grid">
                        <div class="dropdown">
                            <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-calendar-check-o "></i> Please Select Semester to View
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php
                                $attendance_record_Semester_options = Menu :: $Semester;
                                if(!empty($attendance_record_Semester_options)){
                                foreach($attendance_record_Semester_options as $option){
                                $value = $option['value'];
                                $label = $option['label'];
                                $nav_link = $this->set_current_page_link(array('attendance_record_Semester' => $value ) , false);
                                $is_active = is_active_link('attendance_record_Semester', $value);
                                ?>
                                <a class="dropdown-item <?php echo $is_active; ?>" href="<?php print_link($nav_link) ?>">
                                    <i class="fa fa-calendar "></i><?php echo $label ?>
                                </a>
                                <?php
                                }
                                }
                                ?>
                            </div>
                        </div>
                        <?php $this :: display_page_errors(); ?>
                        <div class="filter-tags mb-2">
                            <?php
                            if(!empty(get_value('attendance_record_Semester'))){
                            ?>
                            <div class="filter-chip card bg-light">
                                <b>Attendance Record Semester :</b> 
                                <?php 
                                if(get_value('attendance_record_Semesterlabel')){
                                echo get_value('attendance_record_Semesterlabel');
                                }
                                else{
                                echo get_value('attendance_record_Semester');
                                }
                                $remove_link = unset_get_value('attendance_record_Semester', $this->route->page_url);
                                ?>
                                <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                    &times;
                                </a>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div  class=" animated fadeIn page-content">
                            <div id="attendance_record-listclassrecord-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-light">
                                            <tr>
                                                <?php if($can_delete){ ?>
                                                <th class="td-checkbox">
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input class="toggle-check-all custom-control-input" type="checkbox" />
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </th>
                                                <?php } ?>
                                                <th class="td-sno">#</th>
                                                <th  class="td-student_info_Inst_id"> Student ID</th>
                                                <th  class="td-Student_Name"> Student Name</th>
                                                <th  class="td-Att_Date"> Att Date</th>
                                                <th  class="td-Att_Time"> Att Time</th>
                                                <th  class="td-Instructor"> Instructor</th>
                                                <th  class="td-Subject"> Subject</th>
                                                <th  class="td-Status"> Status</th>
                                                <th  class="td-Semester"> Semester</th>
                                                <th class="td-btn"></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if(!empty($records)){
                                        ?>
                                        <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
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
                                                <!--endrecord-->
                                            </tbody>
                                            <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                        <?php 
                                        if(empty($records)){
                                        ?>
                                        <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                            <i class="fa fa-ban"></i> No record found
                                        </h4>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if( $show_footer && !empty($records)){
                                    ?>
                                    <div class=" border-top mt-2">
                                        <div class="row justify-content-center">    
                                            <div class="col-md-auto justify-content-center">    
                                                <div class="p-3 d-flex justify-content-between">    
                                                    <?php if($can_delete){ ?>
                                                    <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("attendance_record/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                        <i class="fa fa-times"></i> Delete Selected
                                                    </button>
                                                    <?php } ?>
                                                    <div class="dropup export-btn-holder mx-1">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-save"></i> Export
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                                            <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                                                <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                                                </a>
                                                                <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                                                <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                                                    <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                                                    </a>
                                                                    <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                                                    <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                                        <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                                        </a>
                                                                        <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                                        <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                                            <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                                            </a>
                                                                            <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                                            <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                                                <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col">   
                                                                    <?php
                                                                    if($show_pagination == true){
                                                                    $pager = new Pagination($total_records, $record_count);
                                                                    $pager->route = $this->route;
                                                                    $pager->show_page_count = true;
                                                                    $pager->show_record_count = true;
                                                                    $pager->show_page_limit =true;
                                                                    $pager->limit_count = $this->limit_count;
                                                                    $pager->show_page_number_list = true;
                                                                    $pager->pager_link_range=5;
                                                                    $pager->ajax_page = true;
                                                                    $pager->render();
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

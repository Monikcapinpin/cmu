<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("attendance_record/add");
$can_edit = ACL::is_allowed("attendance_record/edit");
$can_view = ACL::is_allowed("attendance_record/view");
$can_delete = ACL::is_allowed("attendance_record/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3 bgv">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Attendance Record</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['ID']) ? urlencode($data['ID']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <?php Html::ajaxpage_spinner(); ?>
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-Student_Name">
                                        <th class="title"> Student Name: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-white page-modal" href="<?php print_link("attendance_record/history/Student_Name/" . urlencode($data['Student_Name'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['Student_Name'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-Att_Date">
                                        <th class="title"> Attendance Date: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Att_Time">
                                        <th class="title"> Attendance Time: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Instructor">
                                        <th class="title"> Instructor: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Subject">
                                        <th class="title"> Subject: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Status">
                                        <th class="title"> Status: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $Status); ?>' 
                                                data-value="<?php echo $data['Status']; ?>" 
                                                data-pk="<?php echo $data['ID'] ?>" 
                                                data-url="<?php print_link("attendance_record/editfield/" . urlencode($data['ID'])); ?>" 
                                                data-name="Status" 
                                                data-title="Select a value ..." 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="select" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Status']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-student_info_ID">
                                        <th class="title"> Student Info Id: </th>
                                        <td class="value"> <?php echo $data['student_info_ID']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Name">
                                        <th class="title"> Student Info Name: </th>
                                        <td class="value"> <?php echo $data['student_info_Name']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Block">
                                        <th class="title"> Student Info Block: </th>
                                        <td class="value"> <?php echo $data['student_info_Block']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Year">
                                        <th class="title"> Student Info Year: </th>
                                        <td class="value"> <?php echo $data['student_info_Year']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Program">
                                        <th class="title"> Student Info Program: </th>
                                        <td class="value"> <?php echo $data['student_info_Program']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Username">
                                        <th class="title"> Student Info Username: </th>
                                        <td class="value"> <?php echo $data['student_info_Username']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Password">
                                        <th class="title"> Student Info Password: </th>
                                        <td class="value"> <?php echo $data['student_info_Password']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Photo">
                                        <th class="title"> Student Info Photo: </th>
                                        <td class="value"> <?php echo $data['student_info_Photo']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Roles">
                                        <th class="title"> Student Info Roles: </th>
                                        <td class="value"> <?php echo $data['student_info_Roles']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Barcode">
                                        <th class="title"> Student Info Barcode: </th>
                                        <td class="value"> <?php echo $data['student_info_Barcode']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Email">
                                        <th class="title"> Student Info Email: </th>
                                        <td class="value"> <?php echo $data['student_info_Email']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Firstname">
                                        <th class="title"> Student Info Firstname: </th>
                                        <td class="value"> <?php echo $data['student_info_Firstname']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Lastname">
                                        <th class="title"> Student Info Lastname: </th>
                                        <td class="value"> <?php echo $data['student_info_Lastname']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Middlename">
                                        <th class="title"> Student Info Middlename: </th>
                                        <td class="value"> <?php echo $data['student_info_Middlename']; ?></td>
                                    </tr>
                                    <tr  class="td-student_info_Inst_id">
                                        <th class="title"> Student Info Inst Id: </th>
                                        <td class="value"> <?php echo $data['student_info_Inst_id']; ?></td>
                                    </tr>
                                    <tr  class="td-Semester">
                                        <th class="title"> Semester: </th>
                                        <td class="value">
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
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
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
                                                <?php if($can_edit){ ?>
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("attendance_record/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($can_delete){ ?>
                                                <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("attendance_record/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                    <i class="fa fa-times"></i> Delete
                                                </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <!-- Empty Record Message -->
                                            <div class="text-muted p-3">
                                                <i class="fa fa-ban"></i> No Record Found
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

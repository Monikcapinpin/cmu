<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("student_info/add");
$can_edit = ACL::is_allowed("student_info/edit");
$can_view = ACL::is_allowed("student_info/view");
$can_delete = ACL::is_allowed("student_info/delete");
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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3 bgv">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">My Account</h4>
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
                    <div  class="card  animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['ID']) ? urlencode($data['ID']) : null);
                        $counter++;
                        ?>
                        <div class="bg-primary m-2 mb-4">
                            <div class="profile">
                                <div class="avatar">
                                    <?php 
                                    if(!empty(USER_PHOTO)){
                                    Html::page_img(USER_PHOTO, 100, 100); 
                                    }
                                    ?>
                                </div>
                                <h1 class="title mt-4"><?php echo $data['Username']; ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mx-3 mb-3">
                                    <ul class="nav nav-pills flex-column text-left">
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageView" class="nav-link active">
                                                <i class="fa fa-user"></i> Account Detail
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageEdit" class="nav-link">
                                                <i class="fa fa-edit"></i> Edit Account
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageChangeEmail" class="nav-link">
                                                <i class="fa fa-envelope"></i> Change Email
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageChangePassword" class="nav-link">
                                                <i class="fa fa-key"></i> Reset Password
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <div class="tab-content">
                                        <div class="tab-pane show active fade" id="AccountPageView" role="tabpanel">
                                            <table class="table table-hover table-borderless table-striped">
                                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                    <tr  class="td-Name">
                                                        <th class="title"> Name: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Name']; ?>" 
                                                                data-pk="<?php echo $data['ID'] ?>" 
                                                                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                                                                data-name="Name" 
                                                                data-title="Enter Name" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" <?php } ?>>
                                                                <?php echo $data['Name']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-Username">
                                                        <th class="title"> Username: </th>
                                                        <td class="value"> <?php echo $data['Username']; ?></td>
                                                    </tr>
                                                    <tr  class="td-Roles">
                                                        <th class="title"> Roles: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $Roles); ?>' 
                                                                data-value="<?php echo $data['Roles']; ?>" 
                                                                data-pk="<?php echo $data['ID'] ?>" 
                                                                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                                                                data-name="Roles" 
                                                                data-title="Select a value ..." 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="select" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" <?php } ?>>
                                                                <?php echo $data['Roles']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-Email">
                                                        <th class="title"> Email: </th>
                                                        <td class="value"> <?php echo $data['Email']; ?></td>
                                                    </tr>
                                                    <tr  class="td-Firstname">
                                                        <th class="title"> Firstname: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Firstname']; ?>" 
                                                                data-pk="<?php echo $data['ID'] ?>" 
                                                                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                                                                data-name="Firstname" 
                                                                data-title="Enter Firstname" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" <?php } ?>>
                                                                <?php echo $data['Firstname']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-Lastname">
                                                        <th class="title"> Lastname: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Lastname']; ?>" 
                                                                data-pk="<?php echo $data['ID'] ?>" 
                                                                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                                                                data-name="Lastname" 
                                                                data-title="Enter Lastname" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" <?php } ?>>
                                                                <?php echo $data['Lastname']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-Middlename">
                                                        <th class="title"> Middlename: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Middlename']; ?>" 
                                                                data-pk="<?php echo $data['ID'] ?>" 
                                                                data-url="<?php print_link("student_info/editfield/" . urlencode($data['ID'])); ?>" 
                                                                data-name="Middlename" 
                                                                data-title="Enter Middlename" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" <?php } ?>>
                                                                <?php echo $data['Middlename']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-Inst_id">
                                                        <th class="title"> Inst Id: </th>
                                                        <td class="value">
                                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Inst_id']; ?>" 
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
                                                                <?php echo $data['Inst_id']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>    
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageEdit" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("account/edit"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane  fade" id="AccountPageChangeEmail" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("account/change_email"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageChangePassword" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("passwordmanager"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

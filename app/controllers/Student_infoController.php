<?php 
/**
 * Student_info Page Controller
 * @category  Controller
 */
class Student_infoController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "student_info";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Inst_id", 
			"Name", 
			"Program", 
			"Block", 
			"Year", 
			"Roles", 
			"Email");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				student_info.ID LIKE ? OR 
				student_info.Photo LIKE ? OR 
				student_info.Inst_id LIKE ? OR 
				student_info.Name LIKE ? OR 
				student_info.Program LIKE ? OR 
				student_info.Block LIKE ? OR 
				student_info.Year LIKE ? OR 
				student_info.Username LIKE ? OR 
				student_info.Password LIKE ? OR 
				student_info.Roles LIKE ? OR 
				student_info.Barcode LIKE ? OR 
				student_info.Email LIKE ? OR 
				student_info.Firstname LIKE ? OR 
				student_info.Lastname LIKE ? OR 
				student_info.Middlename LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "student_info/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("student_info.ID", ORDER_TYPE);
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$db->where("Roles='Student'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Student Info";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$view_name = (is_ajax() ? "student_info/ajax-list.php" : "student_info/list.php");
		$this->render_view($view_name, $data);
	}
	/**
     * Load csv|json data
     * @return data
     */
	function import_data(){
		if(!empty($_FILES['file'])){
			$finfo = pathinfo($_FILES['file']['name']);
			$ext = strtolower($finfo['extension']);
			if(!in_array($ext , array('csv','json'))){
				$this->set_flash_msg("File format not supported", "danger");
			}
			else{
			$file_path = null;
			$uploader=new Uploader;
			$config = array('uploadDir' => UPLOAD_FILE_DIR, 'title' => '{{file_name}}{{date}}', 'required' => true, 'extensions' => array('csv','json'), 'filenameprefix' => 'student_info_');
			$upload_data=$uploader->upload($_FILES['file'], $config);
			if($upload_data['isComplete']){
				$files = $upload_data['data'];
				$file_path = $upload_data['data']['files'][0];
			}
			if($upload_data['hasErrors']){
				$this->set_flash_msg($upload_data['errors'], "danger");
			}
				if(!empty($file_path)){
					$request = $this->request;
					$db = $this->GetModel();
					$tablename = $this->tablename;
					if($ext == "csv"){
						$options = array('table' => $tablename, 'fields' => '', 'delimiter' => ',', 'quote' => '"');
						$data = $db->loadCsvData($file_path , $options , false);
					}
					else{
						$data = $db->loadJsonData($file_path, $tablename , false);
					}
					if($db->getLastError()){
						$this->set_flash_msg($db->getLastError(), "danger");
					}
					else{
						$this->set_flash_msg("Data imported successfully", "success");
					}
				}
				else{
					$this->set_flash_msg("Error uploading file", "success");
				}
			}
		}
		else{
			$this->set_flash_msg("No file selected for upload", "warning");
		}
		$this->redirect("student_info");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Name", 
			"Program", 
			"Block", 
			"Year", 
			"Username", 
			"Email", 
			"Firstname", 
			"Lastname", 
			"Middlename", 
			"Inst_id");
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("student_info.ID", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Student Info";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("student_info/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("Inst_id","Firstname","Middlename","Lastname","Email","Block","Year","Program","Username","Password","Photo","Roles","Barcode","Name");
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['Password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'Inst_id' => 'required|numeric',
				'Firstname' => 'required',
				'Middlename' => 'required',
				'Lastname' => 'required',
				'Email' => 'required|valid_email',
				'Block' => 'required',
				'Year' => 'required',
				'Program' => 'required',
				'Username' => 'required',
				'Password' => 'required',
				'Photo' => 'required',
				'Roles' => 'required',
				'Barcode' => 'required',
				'Name' => 'required',
			);
			$this->sanitize_array = array(
				'Inst_id' => 'sanitize_string',
				'Firstname' => 'sanitize_string',
				'Middlename' => 'sanitize_string',
				'Lastname' => 'sanitize_string',
				'Email' => 'sanitize_string',
				'Block' => 'sanitize_string',
				'Year' => 'sanitize_string',
				'Program' => 'sanitize_string',
				'Username' => 'sanitize_string',
				'Photo' => 'sanitize_string',
				'Roles' => 'sanitize_string',
				'Barcode' => 'sanitize_string',
				'Name' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['Password'];
			//update modeldata with the password hash
			$modeldata['Password'] = $this->modeldata['Password'] = password_hash($password_text , PASSWORD_DEFAULT);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("Inst_id", $modeldata['Inst_id']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['Inst_id']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("Email", $modeldata['Email']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['Email']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("Username", $modeldata['Username']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['Username']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("student_info");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Student Info";
		$this->render_view("student_info/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("ID","Inst_id","Firstname","Middlename","Lastname","Photo","Roles","Name");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Inst_id' => 'required|numeric',
				'Firstname' => 'required',
				'Middlename' => 'required',
				'Lastname' => 'required',
				'Photo' => 'required',
				'Roles' => 'required',
				'Name' => 'required',
			);
			$this->sanitize_array = array(
				'Inst_id' => 'sanitize_string',
				'Firstname' => 'sanitize_string',
				'Middlename' => 'sanitize_string',
				'Lastname' => 'sanitize_string',
				'Photo' => 'sanitize_string',
				'Roles' => 'sanitize_string',
				'Name' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['Inst_id'])){
				$db->where("Inst_id", $modeldata['Inst_id'])->where("ID", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['Inst_id']." Already exist!";
				}
			} 
			if($this->validated()){
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
				$db->where("student_info.ID", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("student_info");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("student_info");
					}
				}
			}
		}
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$db->where("student_info.ID", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Student Info";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("student_info/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("ID","Inst_id","Firstname","Middlename","Lastname","Photo","Roles","Name");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'Inst_id' => 'required|numeric',
				'Firstname' => 'required',
				'Middlename' => 'required',
				'Lastname' => 'required',
				'Photo' => 'required',
				'Roles' => 'required',
				'Name' => 'required',
			);
			$this->sanitize_array = array(
				'Inst_id' => 'sanitize_string',
				'Firstname' => 'sanitize_string',
				'Middlename' => 'sanitize_string',
				'Lastname' => 'sanitize_string',
				'Photo' => 'sanitize_string',
				'Roles' => 'sanitize_string',
				'Name' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['Inst_id'])){
				$db->where("Inst_id", $modeldata['Inst_id'])->where("ID", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['Inst_id']." Already exist!";
				}
			} 
			if($this->validated()){
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
				$db->where("student_info.ID", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("student_info.ID", $arr_rec_id, "in");
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("student_info");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function teacherview($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Name", 
			"Roles", 
			"Email", 
			"Firstname", 
			"Lastname", 
			"Middlename", 
			"Inst_id");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("student_info.ID", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Student Info";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("student_info/teacherview.php", $record);
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function teacheredirt($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("ID","Name","Username","Photo","Roles","Email");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Name' => 'required',
				'Username' => 'required',
				'Photo' => 'required',
				'Roles' => 'required',
				'Email' => 'required|valid_email',
			);
			$this->sanitize_array = array(
				'Name' => 'sanitize_string',
				'Username' => 'sanitize_string',
				'Photo' => 'sanitize_string',
				'Roles' => 'sanitize_string',
				'Email' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("student_info.ID", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("student_info");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("student_info");
					}
				}
			}
		}
		$db->where("student_info.ID", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Student Info";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("student_info/teacheredirt.php", $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function stud_list($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Photo", 
			"Name", 
			"Block", 
			"Year", 
			"Program", 
			"Roles");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				student_info.ID LIKE ? OR 
				student_info.Barcode LIKE ? OR 
				student_info.Photo LIKE ? OR 
				student_info.Name LIKE ? OR 
				student_info.Block LIKE ? OR 
				student_info.Year LIKE ? OR 
				student_info.Program LIKE ? OR 
				student_info.Username LIKE ? OR 
				student_info.Password LIKE ? OR 
				student_info.Roles LIKE ? OR 
				student_info.Email LIKE ? OR 
				student_info.Firstname LIKE ? OR 
				student_info.Lastname LIKE ? OR 
				student_info.Middlename LIKE ? OR 
				student_info.Inst_id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "student_info/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("student_info.ID", ORDER_TYPE);
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$db->where("Roles='Student'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Student Info";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("student_info/stud_list.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function teacheradding($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("Inst_id","Firstname","Middlename","Lastname","Email","Username","Password","Photo","Roles","Name");
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['Password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'Inst_id' => 'required|numeric',
				'Firstname' => 'required',
				'Middlename' => 'required',
				'Lastname' => 'required',
				'Email' => 'required|valid_email',
				'Username' => 'required',
				'Password' => 'required',
				'Photo' => 'required',
				'Roles' => 'required',
				'Name' => 'required',
			);
			$this->sanitize_array = array(
				'Inst_id' => 'sanitize_string',
				'Firstname' => 'sanitize_string',
				'Middlename' => 'sanitize_string',
				'Lastname' => 'sanitize_string',
				'Email' => 'sanitize_string',
				'Username' => 'sanitize_string',
				'Photo' => 'sanitize_string',
				'Roles' => 'sanitize_string',
				'Name' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['Password'];
			//update modeldata with the password hash
			$modeldata['Password'] = $this->modeldata['Password'] = password_hash($password_text , PASSWORD_DEFAULT);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("Email", $modeldata['Email']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['Email']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("Username", $modeldata['Username']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['Username']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("student_info");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Student Info";
		$this->render_view("student_info/teacheradding.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function instructor_list($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Inst_id", 
			"Photo", 
			"Name", 
			"Roles", 
			"Barcode", 
			"Email");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				student_info.ID LIKE ? OR 
				student_info.Inst_id LIKE ? OR 
				student_info.Photo LIKE ? OR 
				student_info.Name LIKE ? OR 
				student_info.Block LIKE ? OR 
				student_info.Year LIKE ? OR 
				student_info.Program LIKE ? OR 
				student_info.Username LIKE ? OR 
				student_info.Password LIKE ? OR 
				student_info.Roles LIKE ? OR 
				student_info.Barcode LIKE ? OR 
				student_info.Email LIKE ? OR 
				student_info.Firstname LIKE ? OR 
				student_info.Lastname LIKE ? OR 
				student_info.Middlename LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "student_info/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("student_info.ID", ORDER_TYPE);
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$db->where("Roles='Teacher' OR Roles='Admin'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Student Info";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("student_info/instructor_list.php", $data); //render the full page
	}
}

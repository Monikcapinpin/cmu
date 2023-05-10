<?php 
/**
 * Attendance_record Page Controller
 * @category  Controller
 */
class Attendance_recordController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "attendance_record";
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
		$fields = array("attendance_record.ID", 
			"attendance_record.Student_Name", 
			"activity_record.ID AS activity_record_ID", 
			"attendance_record.Semester");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance_record.ID LIKE ? OR 
				attendance_record.Student_Name LIKE ? OR 
				attendance_record.Att_Date LIKE ? OR 
				attendance_record.Att_Time LIKE ? OR 
				attendance_record.Instructor LIKE ? OR 
				attendance_record.Subject LIKE ? OR 
				attendance_record.Status LIKE ? OR 
				attendance_record.Semester LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance_record/search.php";
		}
		$db->join("activity_record", "attendance_record.Student_Name = activity_record.ID", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("Subject", "ASC");
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
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
		$page_title = $this->view->page_title = "Attendance Record";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("attendance_record/list.php", $data); //render the full page
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
		$fields = array("attendance_record.ID", 
			"attendance_record.Student_Name", 
			"attendance_record.Att_Date", 
			"attendance_record.Att_Time", 
			"attendance_record.Instructor", 
			"attendance_record.Subject", 
			"attendance_record.Status", 
			"student_info.ID AS student_info_ID", 
			"student_info.Name AS student_info_Name", 
			"student_info.Block AS student_info_Block", 
			"student_info.Year AS student_info_Year", 
			"student_info.Program AS student_info_Program", 
			"student_info.Username AS student_info_Username", 
			"student_info.Password AS student_info_Password", 
			"student_info.Photo AS student_info_Photo", 
			"student_info.Roles AS student_info_Roles", 
			"student_info.Barcode AS student_info_Barcode", 
			"student_info.Email AS student_info_Email", 
			"student_info.Firstname AS student_info_Firstname", 
			"student_info.Lastname AS student_info_Lastname", 
			"student_info.Middlename AS student_info_Middlename", 
			"student_info.Inst_id AS student_info_Inst_id", 
			"attendance_record.Semester");
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("attendance_record.ID", $rec_id);; //select record based on primary key
		}
		$db->join("student_info", "attendance_record.Student_Name = student_info.Name", "INNER ");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$record['Att_Date'] = format_date($record['Att_Date'],'F j, Y');
$record['Att_Time'] = format_date($record['Att_Time'],'h:i:s');
			$page_title = $this->view->page_title = "View  Attendance Record";
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
		return $this->render_view("attendance_record/view.php", $record);
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
			$fields = $this->fields = array("Student_Name","Att_Date","Att_Time","Instructor","Subject","Status","Semester");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Student_Name' => 'required',
				'Att_Date' => 'required',
				'Att_Time' => 'required',
				'Instructor' => 'required',
				'Subject' => 'required',
				'Status' => 'required',
				'Semester' => 'required',
			);
			$this->sanitize_array = array(
				'Student_Name' => 'sanitize_string',
				'Att_Date' => 'sanitize_string',
				'Att_Time' => 'sanitize_string',
				'Instructor' => 'sanitize_string',
				'Subject' => 'sanitize_string',
				'Status' => 'sanitize_string',
				'Semester' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("attendance_record");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Attendance Record";
		$this->render_view("attendance_record/add.php");
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
		$fields = $this->fields = array("ID","Student_Name","Att_Date","Att_Time","Instructor","Subject","Status","Semester");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Student_Name' => 'required',
				'Att_Date' => 'required',
				'Att_Time' => 'required',
				'Instructor' => 'required',
				'Subject' => 'required',
				'Status' => 'required',
				'Semester' => 'required',
			);
			$this->sanitize_array = array(
				'Student_Name' => 'sanitize_string',
				'Att_Date' => 'sanitize_string',
				'Att_Time' => 'sanitize_string',
				'Instructor' => 'sanitize_string',
				'Subject' => 'sanitize_string',
				'Status' => 'sanitize_string',
				'Semester' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
				$db->where("attendance_record.ID", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("attendance_record");
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
						return	$this->redirect("attendance_record");
					}
				}
			}
		}
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
		$db->where("attendance_record.ID", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Attendance Record";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("attendance_record/edit.php", $data);
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
		$fields = $this->fields = array("ID","Student_Name","Att_Date","Att_Time","Instructor","Subject","Status","Semester");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'Student_Name' => 'required',
				'Att_Date' => 'required',
				'Att_Time' => 'required',
				'Instructor' => 'required',
				'Subject' => 'required',
				'Status' => 'required',
				'Semester' => 'required',
			);
			$this->sanitize_array = array(
				'Student_Name' => 'sanitize_string',
				'Att_Date' => 'sanitize_string',
				'Att_Time' => 'sanitize_string',
				'Instructor' => 'sanitize_string',
				'Subject' => 'sanitize_string',
				'Status' => 'sanitize_string',
				'Semester' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
				$db->where("attendance_record.ID", $rec_id);;
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
		$db->where("attendance_record.ID", $arr_rec_id, "in");
		$allowed_roles = array ('admin');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("attendance_record");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function list_att($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Student_Name", 
			"Att_Date", 
			"Att_Time", 
			"Instructor", 
			"Subject", 
			"Status", 
			"Semester");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance_record.ID LIKE ? OR 
				attendance_record.Student_Name LIKE ? OR 
				attendance_record.Att_Date LIKE ? OR 
				attendance_record.Att_Time LIKE ? OR 
				attendance_record.Instructor LIKE ? OR 
				attendance_record.Subject LIKE ? OR 
				attendance_record.Status LIKE ? OR 
				attendance_record.Semester LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance_record/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("attendance_record.ID", ORDER_TYPE);
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
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
		$page_title = $this->view->page_title = "Attendance Record";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("attendance_record/list_att.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function listclassrecord($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("attendance_record.ID", 
			"student_info.Inst_id AS student_info_Inst_id", 
			"attendance_record.Student_Name", 
			"attendance_record.Att_Date", 
			"attendance_record.Att_Time", 
			"attendance_record.Instructor", 
			"attendance_record.Subject", 
			"attendance_record.Status", 
			"attendance_record.Semester");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance_record.ID LIKE ? OR 
				student_info.Inst_id LIKE ? OR 
				attendance_record.Student_Name LIKE ? OR 
				attendance_record.Att_Date LIKE ? OR 
				attendance_record.Att_Time LIKE ? OR 
				attendance_record.Instructor LIKE ? OR 
				attendance_record.Subject LIKE ? OR 
				attendance_record.Status LIKE ? OR 
				student_info.ID LIKE ? OR 
				student_info.Name LIKE ? OR 
				student_info.Block LIKE ? OR 
				student_info.Year LIKE ? OR 
				student_info.Program LIKE ? OR 
				student_info.Username LIKE ? OR 
				student_info.Password LIKE ? OR 
				student_info.Photo LIKE ? OR 
				student_info.Roles LIKE ? OR 
				student_info.Barcode LIKE ? OR 
				student_info.Email LIKE ? OR 
				student_info.Firstname LIKE ? OR 
				student_info.Lastname LIKE ? OR 
				student_info.Middlename LIKE ? OR 
				attendance_record.Semester LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance_record/search.php";
		}
		$db->join("student_info", "attendance_record.Student_Name = student_info.Name", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("attendance_record.ID", ORDER_TYPE);
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->attendance_record_Semester)){
			$val = $request->attendance_record_Semester;
			$db->where("attendance_record.Semester", $val , "=");
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
		$page_title = $this->view->page_title = "Attendance Record";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$view_name = (is_ajax() ? "attendance_record/ajax-listclassrecord.php" : "attendance_record/listclassrecord.php");
		$this->render_view($view_name, $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function history($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Student_Name", 
			"Att_Date", 
			"Att_Time", 
			"Instructor", 
			"Subject", 
			"Status", 
			"Semester");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance_record.ID LIKE ? OR 
				attendance_record.Student_Name LIKE ? OR 
				attendance_record.Att_Date LIKE ? OR 
				attendance_record.Att_Time LIKE ? OR 
				attendance_record.Instructor LIKE ? OR 
				attendance_record.Subject LIKE ? OR 
				attendance_record.Status LIKE ? OR 
				attendance_record.Semester LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance_record/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("Instructor", "ASC");
		}
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("attendance_record.Student_Name", get_active_user('Name') );
		}
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
		$page_title = $this->view->page_title = "Attendance Record";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("attendance_record/history.php", $data); //render the full page
	}
}

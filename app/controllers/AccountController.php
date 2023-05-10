<?php 
/**
 * Account Page Controller
 * @category  Controller
 */
class AccountController extends SecureController{
	function __construct(){
		parent::__construct(); 
		$this->tablename = "student_info";
	}
	/**
		* Index Action
		* @return null
		*/
	function index(){
		$db = $this->GetModel();
		$rec_id = $this->rec_id = USER_ID; //get current user id from session
		$db->where ("ID", $rec_id);
		$tablename = $this->tablename;
		$fields = array("ID", 
			"Name", 
			"Username", 
			"Roles", 
			"Email", 
			"Firstname", 
			"Lastname", 
			"Middlename", 
			"Inst_id");
		$allowed_roles = array ('admin', 'teacher');
		if(!in_array(strtolower(USER_ROLE), $allowed_roles)){
		$db->where("student_info.Name", get_active_user('Name') );
		}
		$user = $db->getOne($tablename , $fields);
		if(!empty($user)){
			$page_title = $this->view->page_title = "My Account";
			$this->render_view("account/view.php", $user);
		}
		else{
			$this->set_page_error();
			$this->render_view("account/view.php");
		}
	}
	/**
     * Update user account record with formdata
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = USER_ID;
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
					$db->where ("ID", $rec_id);
					$user = $db->getOne($tablename , "*");
					set_session("user_data", $user);// update session with new user data
					return $this->redirect("account");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$this->set_flash_msg("No record updated", "warning");
						return	$this->redirect("account");
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
		$page_title = $this->view->page_title = "My Account";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("account/edit.php", $data);
	}
	/**
     * Change account email
     * @return BaseView
     */
	function change_email($formdata = null){
		if($formdata){
			$email = trim($formdata['Email']);
			$db = $this->GetModel();
			$rec_id = $this->rec_id = USER_ID; //get current user id from session
			$tablename = $this->tablename;
			$db->where ("ID", $rec_id);
			$result = $db->update($tablename, array('Email' => $email ));
			if($result){
				$this->set_flash_msg("Email address changed successfully", "success");
				$this->redirect("account");
			}
			else{
				$this->set_page_error("Email not changed");
			}
		}
		return $this->render_view("account/change_email.php");
	}
}

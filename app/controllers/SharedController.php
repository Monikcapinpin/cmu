<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * activity_record_Student_Name_option_list Model Action
     * @return array
     */
	function activity_record_Student_Name_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Name AS value,Name AS label FROM student_info WHERE Roles='Student'";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_record_Instructor_option_list Model Action
     * @return array
     */
	function attendance_record_Instructor_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Name AS value,Name AS label FROM student_info WHERE Roles='Teacher'";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_record_Student_Name_option_list Model Action
     * @return array
     */
	function attendance_record_Student_Name_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Name AS value,Name AS label FROM student_info WHERE Roles  ='Student'"

;
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_record_Student_Name_option_list_2 Model Action
     * @return array
     */
	function attendance_record_Student_Name_option_list_2(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Name AS value,Name AS label FROM student_info WHERE Roles  ='Student'";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * student_info_Email_value_exist Model Action
     * @return array
     */
	function student_info_Email_value_exist($val){
		$db = $this->GetModel();
		$db->where("Email", $val);
		$exist = $db->has("student_info");
		return $exist;
	}

	/**
     * student_info_Program_option_list Model Action
     * @return array
     */
	function student_info_Program_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Abbreviation AS value,Course AS label FROM courses ORDER BY ID ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * student_info_Username_value_exist Model Action
     * @return array
     */
	function student_info_Username_value_exist($val){
		$db = $this->GetModel();
		$db->where("Username", $val);
		$exist = $db->has("student_info");
		return $exist;
	}

	/**
     * student_info_Inst_id_value_exist Model Action
     * @return array
     */
	function student_info_Inst_id_value_exist($val){
		$db = $this->GetModel();
		$db->where("Inst_id", $val);
		$exist = $db->has("student_info");
		return $exist;
	}

	/**
     * getcount_activityrecord Model Action
     * @return Value
     */
	function getcount_activityrecord(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM activity_record";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_eventrecord Model Action
     * @return Value
     */
	function getcount_eventrecord(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM activity_record";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_classrecord Model Action
     * @return Value
     */
	function getcount_classrecord(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM attendance_record";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_studentinformation Model Action
     * @return Value
     */
	function getcount_studentinformation(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM student_info WHERE Roles='Student'";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
	* barchart_coursesmoststudentenrolled Model Action
	* @return array
	*/
	function barchart_coursesmoststudentenrolled(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(si.ID) AS count_of_ID, si.Program, si.Name FROM student_info AS si WHERE  (si.Roles  ='Student' ) GROUP BY si.Program";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_ID');
		$dataset_labels =  array_column($dataset1, 'Program');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}

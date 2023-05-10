<?php 

/**
 * Home Page Controller
 * @category  Controller
 */
class HomeController extends SecureController{
	/**
     * Index Action
     * @return View
     */
	function index(){
		if(strtolower(USER_ROLE) == 'admin'){
			$this->render_view("home/admin.php" , null , "main_layout.php");
		}
		elseif(strtolower(USER_ROLE) == 'teacher'){
			$this->render_view("home/teacher.php" , null , "main_layout.php");
		}
		elseif(strtolower(USER_ROLE) == 'student'){
			$this->render_view("home/student.php" , null , "main_layout.php");
		}
		else{
			$this->render_view("home/index.php" , null , "main_layout.php");
		}
	}
}

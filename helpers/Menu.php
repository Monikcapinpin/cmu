<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbartopleft = array(
		array(
			'path' => 'home', 
			'label' => 'Dashboard', 
			'icon' => '<i class="fa fa-home fa-2x"></i>'
		),
		
		array(
			'path' => 'attendance_record', 
			'label' => 'Attendance Record', 
			'icon' => '<i class="fa fa-book fa-2x"></i>','submenu' => array(
		array(
			'path' => 'attendance_record', 
			'label' => 'View Attendance', 
			'icon' => '<i class="fa fa-calendar "></i>','submenu' => array(
		array(
			'path' => 'attendance_record/listclassrecord', 
			'label' => 'by Class', 
			'icon' => '<i class="fa fa-file-photo-o "></i>'
		),
		
		array(
			'path' => 'activity_record', 
			'label' => 'by Event', 
			'icon' => '<i class="fa fa-flash "></i>'
		)
	)
		),
		
		array(
			'path' => 'attendance_record/add', 
			'label' => 'Addnew Attendance', 
			'icon' => '<i class="fa fa-calendar-plus-o "></i>','submenu' => array(
		array(
			'path' => 'attendance_record/add', 
			'label' => 'for Class', 
			'icon' => '<i class="fa fa-file-photo-o "></i>'
		),
		
		array(
			'path' => 'activity_record/add', 
			'label' => 'for Event', 
			'icon' => '<i class="fa fa-flash "></i>'
		)
	)
		)
	)
		),
		
		array(
			'path' => 'student_info', 
			'label' => 'Student Information', 
			'icon' => '<i class="fa fa-calendar-o fa-2x"></i>','submenu' => array(
		array(
			'path' => 'student_info', 
			'label' => 'View Student', 
			'icon' => '<i class="fa fa-credit-card "></i>'
		),
		
		array(
			'path' => 'student_info/add', 
			'label' => 'Addnew Student', 
			'icon' => '<i class="fa fa-edit "></i>'
		)
	)
		),
		
		array(
			'path' => 'instructor1', 
			'label' => 'Instructor Information', 
			'icon' => '<i class="fa fa-users fa-2x"></i>','submenu' => array(
		array(
			'path' => 'instructor1', 
			'label' => 'View Instructor', 
			'icon' => '<i class="fa fa-credit-card-alt "></i>'
		),
		
		array(
			'path' => 'student_info/teacheradding', 
			'label' => 'Addnew Instructor', 
			'icon' => '<i class="fa fa-user-plus "></i>'
		),
		
		array(
			'path' => 'scheduling', 
			'label' => 'Scheduling', 
			'icon' => '<i class="fa fa-clock-o "></i>'
		)
	)
		),
		
		array(
			'path' => 'courses', 
			'label' => 'Action', 
			'icon' => '<i class="fa fa-gears fa-2x"></i>','submenu' => array(
		array(
			'path' => 'courses', 
			'label' => 'View Courses', 
			'icon' => '<i class="fa fa-clipboard "></i>'
		),
		
		array(
			'path' => 'subject', 
			'label' => 'View Subject', 
			'icon' => '<i class="fa fa-copy "></i>'
		)
	)
		)
	);
		
	
	
			public static $Semester = array(
		array(
			"value" => "1st Semester", 
			"label" => "1st Semester", 
		),
		array(
			"value" => "2nd Semester", 
			"label" => "2nd Semester", 
		),);
		
			public static $Status = array(
		array(
			"value" => "Late", 
			"label" => "Late", 
		),
		array(
			"value" => "On-Time", 
			"label" => "On-Time", 
		),);
		
			public static $Block = array(
		array(
			"value" => "Block 1", 
			"label" => "Block 1", 
		),
		array(
			"value" => "Block 2", 
			"label" => "Block 2", 
		),
		array(
			"value" => "Block 3", 
			"label" => "Block 3", 
		),
		array(
			"value" => "Block 4", 
			"label" => "Block 4", 
		),);
		
			public static $Year = array(
		array(
			"value" => "1st ", 
			"label" => "1st", 
		),
		array(
			"value" => "2nd", 
			"label" => "2nd", 
		),
		array(
			"value" => "3rd", 
			"label" => "3rd", 
		),
		array(
			"value" => "4th", 
			"label" => "4th", 
		),
		array(
			"value" => "5th", 
			"label" => "5th", 
		),);
		
			public static $Roles = array(
		array(
			"value" => "Admin", 
			"label" => "Admin", 
		),
		array(
			"value" => "Teacher", 
			"label" => "Teacher", 
		),
		array(
			"value" => "Student", 
			"label" => "Student", 
		),);
		
}
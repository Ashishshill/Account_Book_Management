<?php 
/**
 * this class for employee
 */
class Employee
{

	private $_db,
			$_data,
			$_sessionName,
			$_suporttedFormats = ['image/png','image/jpeg','image/jpg',];
	
	function __construct()
	{
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('employees', $fields)) {
			throw new Exception('There was a problem.');
		}
	}


	public function delete($id){
		$fields = array("employee_id", "=", $id);
		if(!$this->_db->delete('employees', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}		
	}

	public function all(){
		if(!$this->_db->getAll('employees', "employee_id")) {
			throw new Exception('There was a problem getting.');
		}

		return $this->_db->results();
	}

	public function update($fields = array(), $id = null) {

		if(!$this->_db->update('employees', $id, $fields, "employee_id")) {
			throw new Exception('There was a problem updating.');
		}
	}

	public function find($employee = null) {
		if($employee) {
			// if user had a numeric username this FAILS...
			$field = 'employee_id'; 
			$data = $this->_db->get('employees', array($field, '=', $employee));

			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function data() {
		return $this->_data;
	}

	public function uploadFile($file){
		$file_name_dir = "";
		if (is_array($file)) {
			if (in_array($file['type'],$this->_suporttedFormats)) {

				$file_name_dir = 'uploads/' . $file['name'];
				move_uploaded_file($file['tmp_name'],$file_name_dir);
				
				return $file_name_dir;
			}else{
				return $file_name_dir;
			}
		}else{
			return $file_name_dir;
		}
	}

}
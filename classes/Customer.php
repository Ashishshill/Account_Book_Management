<?php 
/**
 * this class for employee
 */
class Customer
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
		if(!$this->_db->insert('customers', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}
	}


	public function delete($id){
		$fields = array("customer_id", "=", $id);
		if(!$this->_db->delete('customers', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}		
	}

	public function all(){
		if(!$this->_db->getAll('customers', "customer_id")) {
			throw new Exception('There was a problem getting.');
		}

		return $this->_db->results();
	}

	public function update($fields = array(), $id = null) {

		if(!$this->_db->update('customers', $id, $fields, "customer_id")) {
			throw new Exception('There was a problem updating.');
		}
	}

	public function find($customer = null) {
		if($customer) {
			// if user had a numeric username this FAILS...
			$field = 'customer_id'; 
			$data = $this->_db->get('customers', array($field, '=', $customer));

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
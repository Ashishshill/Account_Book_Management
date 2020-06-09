<?php 
/**
 * this class for expanse
*/
class Expense
{

	private $_db,
			$_data,
			$_sessionName;
	
	function __construct()
	{
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('expenses', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}
	}


	public function delete($id){
		$fields = array("expense_id", "=", $id);
		if(!$this->_db->delete('expenses', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}		
	}

	public function all(){
		if(!$this->_db->getAll('expenses', "expense_id")) {
			throw new Exception('There was a problem getting.');
		}

		return $this->_db->results();
	}

	public function update($fields = array(), $id = null) {

		if(!$this->_db->update('expenses', $id, $fields, "expense_id")) {
			throw new Exception('There was a problem updating.');
		}
	}

	public function find($expense = null) {
		if($expense) {
			// if user had a numeric username this FAILS...
			$field = 'expense_id'; 
			$data = $this->_db->get('expenses', array($field, '=', $expense));

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
}
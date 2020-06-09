<?php 
/**
 * this class for Payments
 */
class Payment
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
		if(!$this->_db->insert('payments', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}
	}


	public function delete($id){
		$fields = array("payment_id", "=", $id);
		if(!$this->_db->delete('payments', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}		
	}

	public function all(){
		if(!$this->_db->getAll('payments', "payment_id")) {
			throw new Exception('There was a problem getting.');
		}

		return $this->_db->results();
	}

	public function update($fields = array(), $id = null) {

		if(!$this->_db->update('payments', $id, $fields, "payment_id")) {
			throw new Exception('There was a problem updating.');
		}
	}

	public function find($product = null) {
		if($product) {
			// if user had a numeric username this FAILS...
			$field = 'payment_id'; 
			$data = $this->_db->get('payments', array($field, '=', $payment));

			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function invoice($invoice = null) {
		if($invoice) {
			// if user had a numeric username this FAILS...
			$field = 'invoice_id'; 
			$data = $this->_db->get('payments', array($field, '=', $invoice));

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
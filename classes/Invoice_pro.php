<?php 
/**
 * this class for Invoice
*/ 
class Invoice_pro
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
		if(!$this->_db->insert('invoice_product', $fields)) {
			throw new Exception('There was a problem this account.');
		}
		return $this->_db->lastId();
	}


	public function delete($id){
		$fields = array("invoice_product_id", "=", $id);
		if(!$this->_db->delete('invoice_product', $fields)) {
			throw new Exception('There was a problem creating this account.');
		}		
	}

	public function all(){
		if(!$this->_db->getAll('invoice_product', "invoice_product_id")) {
			throw new Exception('There was a problem getting.');
		}

		return $this->_db->results();
	}

	public function update($fields = array(), $id = null) {

		if(!$this->_db->update('invoice_product', $id, $fields, "invoice_product_id")) {
			throw new Exception('There was a problem updating.');
		}
	}

	public function find($invoice = null) {
		if($invoice) {
			// if user had a numeric username this FAILS...
			$field = 'invoice_product_id'; 
			$data = $this->_db->get('invoice_product', array($field, '=', $invoice));

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

 ?>
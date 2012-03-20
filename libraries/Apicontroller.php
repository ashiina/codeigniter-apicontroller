<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/*
	 *==================================
	 * Apicontroller : API input/output controller class for service 
	 *   by ashiina
	 *==================================
	*/
class Apicontroller {

	/*
	 * Configure whether to directly output a JSON response with headers,
	 * or to simply return a JSON sting. 
	 * (Can also set from setDirectOutput() function) 
	 * Default :
	 * true
	*/
	protected $DIRECT_OUTPUT = true;

	/*
	 * List of all statuscodes.
	 * Add/remove them for whatever is necessary in your app.
	 * You can enable/disable statuscodes with the corresponding boolean.
	 * Default :
	 * 0 => true
	 * 1 => true
	*/
	protected $STATUS_LIST = array(
		0 => true,
		1 => true,
	);

	/*
	 * Default statuscode to use in the following cases
	 *  - No statuscode 
	 *  - Invalid statuscode
	 *  - Disabled statuscode
	 * May change to whatever is necessary in your app. 
	 * Default :
	 * 0
	*/
	protected $STATUS_DEFAULT  = 0;

	/*
	 * key of statuscode, when data is outputted as JSON. 
	 * May change to whatever is necessary in your app. 
	 * Default :
	 * _status
	*/
	protected $STATUS_KEY  = '_status';

	public function __construct($params=null)
	{
		$this->CI =& get_instance();
	}

	/*
	 * API output
	 * 
	 * Outputs a JSON, after setting correct headers.
	 * If an invalid statuscode is called, the function will
	 * return a json with only { '_status': '500' } (a server-side error)
	 * 
	 * @param statuscode : integer
	 * @param data : array(kv)
	 * @return string
	*/
	public function output($statuscode, $data)
	{
		// validation of statuscode
		if (!array_key_exists($statuscode, $this->STATUS_LIST) 
		|| $this->STATUS_LIST[$statuscode] !== true) {
			$statuscode = 500;
			// clear all data
			$data = array();
		}
		// set statuscode
		$data[$this->STATUS_KEY] = $statuscode;

		// json encode
		$json_data = json_encode($data);

		if ($this->DIRECT_OUTPUT) {
			// set headers; then output
			$this->CI->output
				->set_header('HTTP/1.1 200 OK')
				->set_content_type('application/json')
				->set_output($json_data);
		} else {
			// simple string return
			return $json_data;
		}

		return '';
	}

	/*
	 * set direct_output externally
	 * @param bool : boolean
	 * @return void
	*/
	public function setDirectOutput ($bool = true) 
	{
		$this->DIRECT_OUTPUT = $bool;
	}

}

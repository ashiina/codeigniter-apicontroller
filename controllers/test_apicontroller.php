<?php 

/**
 * Test for APIController 
 * ( /application/libraries/Apicontroller.php )
 * Simplified, using stub data
 *
 */
if (! defined('BASEPATH')) exit('No direct script access');

class Test_apicontroller extends CI_Controller {
	
	function index() {
		
		$this->load->library('apicontroller');
		$this->load->library('unit_test');
		
		$this->unit->use_strict(TRUE);
		
		// Creating stub data
		$resultStub = array(
			'test.key1' => 'val1',
			'test.key2' => 'val2',
			'test.key3' => 'val3'
		);

		// disable direct_output
		$this->apicontroller->setDirectOutput(false);

		// Regular case
		$status = 0;
		$this->unit->run(
			$this->apicontroller->output($status, $resultStub), 
			'{"test.key1":"val1","test.key2":"val2","test.key3":"val3","_status":0}', 
			'Output JSON for a regular case with status=0'
		);

		// Empty body
		$status = 0;
		$this->unit->run(
			$this->apicontroller->output($status, array()), 
			'{"_status":0}', 
			'Output JSON with an empty array & status=0'
		);

		// Invalid status code
		$status = 99;
		$this->unit->run(
			$this->apicontroller->output($status, $resultStub), 
			'{"_status":500}', 
			'Output JSON with an invalid statuscode (99)'
		);

		// Display all results
		echo $this->unit->report();
		
	}

}

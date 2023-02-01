<?php

use Carbon\Carbon;

class Notes extends DataMapper
{

	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->load->library('session');
		//  $this->load->helper('form');
	}
	var $table = "notes";
	/**
	 * <p>Returns all recoreds with all fields</p>
	 * @param no prarameters
	 * @return Object Class
	 */
}

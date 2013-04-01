<?php

namespace ISG\ProjectSubmissionAppBundle\Model;

use ISG\ProjectSubmissionAppBundle\Model\om\BaseUser;

class User extends BaseUser
{
	
	public function preSave(\PropelPDO $con = null) {
		try {
			$salt = rand( 10000000001 , 99999999999 );
			$password = $this->getPassword();
			$this->setSalt($salt);
			$this->setPassword(md5($password.$salt));
	        return true;
				
		} catch (Exception $e) {
			throw new Exception("Error");	
		}
	}
}

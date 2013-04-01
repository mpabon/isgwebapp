<?php
namespace ISG\ProjectSubmissionAppBundle\SessionHandler;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionHandler {
	
	
	protected $session;	
	
	protected $method;
		
	protected $class;
	
	protected $mapValid = array (
	                       "user" => array (
	                                  "new" => "100000",
	                                  "list" => "100000",
	                                  "edit" => "100000",
	                                  "delete" => "100000",
	                                  "login" => "111111",
	                                  "logout" => "111111",
	                                  "profile" => "111111"
	                                 )
	                      );
	
	public function __construct(SessionInterface $session) {
       $this->session = $session;
     }
	
	public function setSession($session, $class, $method) {
		$this->session = $session;
        preg_match("/ISG\\\ProjectSubmissionAppBundle\\\Controller\\\([A-Za-z]+)Controller/", $class, $controller);
        $this->class = strtolower($controller[1]); 	
        preg_match("/([A-Za-z]+)Action/", $method, $function); 
        $this->method = $function[1];   
    }
	
	public function isValid () {
		if ($this->session->get("id") != null ) {
			return $this->isAllowed();
		} else {
			return false;
		}
	}
	
	public function isAllowed() {
		$index = $this->session->get("role") - 1;
		return $this->mapValid[$this->class][$this->method][$index];
		
	}
}
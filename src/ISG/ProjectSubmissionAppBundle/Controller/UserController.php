<?php

namespace ISG\ProjectSubmissionAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;
use ISG\ProjectSubmissionAppBundle\Model\Role;
use ISG\ProjectSubmissionAppBundle\Model\RoleQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use ISG\ProjectSubmissionAppBundle\Form\User\UserType;

//Setting custom validator for the submitted form
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * 
 * Controller for all User Actions on the application, from Login to User Management. 
 * Routing is set with the prefix /user and the view files are on the User folder
 * 
 * @author ISG Webapp team
 *
 */

class UserController extends Controller {
	             
    
	/**
	 * 
	 * Action that handles the login submission and authentication for every user in the application
	 * @param Request $request
	 */

    public function loginAction (Request $request) {

    	//@TODO bind with ldap authentication
		$form = $this->createFormBuilder()
    	    ->add('Username', 'text')
			->add('password', 'password')
    	    ->getForm();
			
		$error = null;
		
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			$data = $form->getData();
			$username = $data['Username'];
			$password = $data['password'];
		
		
			$user = UserQuery::create()
				->filterByUsername($username)
				->find();
			if($user[0] == NULL ){
				$error = "Wrong Username or Password try again";
				return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array('form' => $form->createView() , 'error' => $error));
			}	
			else{
				$salt = $user[0]->getSalt();				
				$id = $user[0]->getId();
				$name = $user[0]->getUserFirstname();			
				$surname = $user[0]->getUserLastname();
				$pass = $user[0]->getPassword();
				$plain_pass = $password.$salt;
				$role = $user[0]->getRole()->getId();
				$statusrole = $user[0]->getRole()->getStatus();
				$description = $user[0]->getRole()->getDescription();
				
				if(md5($password.$salt) == $pass){
					
					//@TODO extend as a service the session init and destruction
					if (!$this->getRequest()->getSession()->isStarted()){
						$session = new Session();
						$session->start();
						$session->setName("ISGSESSION");
					} else {
						$session = $this->getRequest()->getSession();
					}

					if (!$session->get("id")) {				
						$session->set("id", $id);
						$session->set("name", $name . " " . $surname);
						$session->set("role", $role);
						$session->set("statusrole", $statusrole);
						$session->set("description", $description);
					}
				
					
					return $this->redirect($this->generateUrl("_userProfile"));
				}
				else{
					$error = "Wrong Username or Password try again";
					return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array('form' => $form->createView() , 'error' => $error));
					
				};
				
			}
			
		} else {
			if ($this->getRequest()->getSession()->get("id") != null) {
			   return $this->redirect($this->generateUrl("_userProfile"));
			} else {
			   return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array('form' => $form->createView(),'error'=> $error,));
			}
		}
   }
    
    
   /**
    * 
    * Action that displays the main profile view of the user, according to the role it has
    */ 
    
    public function profileAction() {
        $session_checker = $this->get("session_handler");
    	$session_checker->setSession($this->getRequest()->getSession(), __CLASS__, __FUNCTION__); 	
    	if ($session_checker->isValid() == false) {
    		return $this->redirect($this->generateUrl("_userLogin"));
    	}
    	
    	$user = UserQuery::create()
                 ->findOneById($this->getRequest()->getSession()->get("id"));
    	
    	
    	$role_template = str_replace(" ", "_", strtolower($this->getRequest()->getSession()->get("description")));
        return $this->render('ISGProjectSubmissionAppBundle:User:profile/index.html.twig', array('user' => $user, 'roleTemplate' => $role_template));
    	
    } 
    
    /**
     * 
     * Action that inactivates and delete the current user session
     */
    public function logoutAction() {
        $this->getRequest()->getSession()->clear();
        $this->getRequest()->getSession()->invalidate(0);
        session_unset();
        return $this->redirect($this->generateUrl("_userLogin"));
                
    }
    
    /** Action that creates a new user in the application. Restricted to System Administrator profile only 
     * 
     * @param $request
     */
    public function newAction(Request $request) {
    	
    	
    	$session_checker = $this->get("session_handler");
    	$session_checker->setSession($this->getRequest()->getSession(), __CLASS__, __FUNCTION__); 	
    	if ($session_checker->isValid() == false) {
    		return $this->redirect($this->generateUrl("_userLogin"));
    	}
    	
    	$user = new User();    	 
    	$form = $this->createForm(new UserType(), $user);

    	if ($request->getMethod() === "POST") {
    	 	$form->bind($request);
    	 	if ($form->isValid()) {    	 		 	 		
    	 		$user = $form->getData();
    	 		$user->setStatus("Active");
    	 		$user->setCreatedBy(1);
    	 		$user->setCreatedOn(date("Y-m-d H:i:s", time()));   	 		
    	 		$user->save();
    	 		return $this->redirect($this->generateUrl("_userProfile"));
    	 	} else {
    	 		return $this->render('ISGProjectSubmissionAppBundle:User:new/index.html.twig', array('form' => $form->createView())); 	
    	 	}
    	 	
    	 }       
    	        
    	 return $this->render('ISGProjectSubmissionAppBundle:User:new/index.html.twig', array('form' => $form->createView()));
   
    }
    
    /**
     * 
     * Action that list all the users in the application. Restricted to users with a System Administrator Role
     */
    
    public function listAction() {
    	
    	$session_checker = $this->get("session_handler");
    	$session_checker->setSession($this->getRequest()->getSession(), __CLASS__, __FUNCTION__);
    	if ($session_checker->isValid() == false) {
    		return $this->redirect($this->generateUrl("_userLogin"));
    	}
    	 
    	$user = UserQuery::create()
    	         ->where("User.Id != ? ", 1)
                 ->find();
         
    	 
        return $this->render('ISGProjectSubmissionAppBundle:User:list/index.html.twig', array('users' => $user));
    	
    	
    }
    
    /**
     * 
     * Action that deletes the user with Id $id from the application. Restricted to users with role as system administrator
     * @param $id
     */
    public function deleteAction($id) {

    	$session_checker = $this->get("session_handler");
    	$session_checker->setSession($this->getRequest()->getSession(), __CLASS__, __FUNCTION__);
    	if ($session_checker->isValid() == false) {
    		return $this->redirect($this->generateUrl("_userLogin"));
    	}
    	 
    	try {
    	 $user = UserQuery::create()
    	 			->filterById($id)
    	 			->findOne();
         $user->delete();
    	 return $this->redirect($this->generateUrl("_userList"));
    	 			
    	} catch (Exception $e) {
    	   return $this->redirect($this->generateUrl("_userList"));
    	}
    }
    /**
     * 
     * Action that edits an user in the application. Restricted to user with System Administrator roles
     * @param int $id
     * @param Request $request
     */
    public function editAction($id, Request $request) {
    	
    	$session_checker = $this->get("session_handler");
    	$session_checker->setSession($this->getRequest()->getSession(), __CLASS__, __FUNCTION__);
    	if ($session_checker->isValid() == false) {
    		return $this->redirect($this->generateUrl("_userLogin"));
    	}
    	
    	$user = UserQuery::create()
    	 			->filterById($id)
    	 			->findOne();
    	 			
        if ($user == NULL) {
        	return $this->redirect($this->generateUrl("_userList"));
        }
     	 			
        $defaultData = array (
                        "user_firstname" => $user->getUserFirstname(),
                        "user_lastname"  => $user->getUserLastname(),
                        "phonenumber" => $user->getPhonenumber(),
                        "role" => $user->getRole()->getId(),
                        "supervisor_quota_1" => $user->getSupervisorQuota1()
                       );
        $array_roles = array();               
        $roles = RoleQuery::create()
                     ->find();
        foreach ($roles as $role) {
        	$id = $role->getId();
        	$array_roles[$id] = $role->getDescription();
        }               

        $not_blank_constraint = new NotBlank();
        $not_blank_constraint->message = "The field must not be empty";
        $length_constraint = new Length(array('min' => 3));
        $length_constraint->minMessage = "The field must be longer than 3 chararacters";
        $email_constraint = new Email();
        $email_constraint->message = "The email is not valid";
        
        $form = $this->createFormBuilder($defaultData)
                  ->add("user_firstname", "text", array( 'constraints' => array($not_blank_constraint,$length_constraint))) 
                  ->add("user_lastname", "text", array( 'constraints' => array($not_blank_constraint,$length_constraint) ) )
                  ->add('password', 'repeated', array(
    											'type' => 'password',
    											'invalid_message' => 'The password fields must match.',
    											'options' => array('attr' => array('class' => 'password-field')),
    											'required' => false,
    											'first_options'  => array('label' => 'Password'),
    											'second_options' => array('label' => 'Repeat Password'),
					))
                  ->add("phonenumber", "text")
                  ->add("role", "choice", array(
                                             "choices" => array($array_roles),
                                             "preferred_choices" =>array($defaultData["role"]) 
                                          ))
                  ->add("supervisor_quota_1", "text")
                  ->getForm();               
                       
    	 if ( $request->getMethod() === "POST"){
    	   $form->bind($request);	
    	   if ($form->isValid()) {
    	   	
    	   	//Updating Values that need to be updated ()   	   	     	   	
    	   	//@todo Refine updating methods for a "cleaner" one
    	   	$new_values = $form->getData();
    	   	if ($user->getUserFirstname() != $new_values["user_firstname"])$user->setUserFirstname($new_values["user_firstname"]);
    	   	if ($user->getUserLastname() != $new_values["user_lastname"])$user->setUserLastname($new_values["user_lastname"]);   	   	 
    	   	if ( $new_values["password"] !== NULL) $user->setPassword($new_values["password"]);
    	   	if ($user->getPhoneNumber() != $new_values["phonenumber"])$user->setPhoneNumber($new_values["phonenumber"]);
    	   	if ($user->getRole()->getId() != $new_values["role"]) $user->setRoleId($new_values["role"]);   	   	 
    	   	if ($user->getSupervisorQuota1() != $new_values["supervisor_quota_1"]) $user->setSupervisorQuota1($new_values["supervisor_quota_1"]);

            $user->setModifiedOn(date("Y-m-d H:i:s", time()));
    	   	$user->save();
    	   	return $this->redirect($this->generateUrl("_userList"));
    	   	
    	   } else {
    	   	  return $this->render('ISGProjectSubmissionAppBundle:User:edit/index.html.twig', array('form' => $form->createView(), 'id' => $user->getId()));	
    	   }
    		
    	 } else {
    	   return $this->render('ISGProjectSubmissionAppBundle:User:edit/index.html.twig', array('form' => $form->createView(), 'id' => $user->getId()));  			
    	 }			
    	 		
    }
}

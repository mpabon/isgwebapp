<?php

namespace ISG\ProjectSubmissionAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;
use ISG\ProjectSubmissionAppBundle\Model\Role;
use ISG\ProjectSubmissionAppBundle\Model\RoleQuery;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {
	             
    public function indexAction () {
        return $this->render('ISGProjectSubmissionAppBundle:Default:index.html.twig', array('name' => $name));
    }
    
	
	
    public function loginAction (Request $request) {
    	
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
			if($user=='{  }'){
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
				if(md5($password.md5($salt))==$pass){
					return $this->render('ISGProjectSubmissionAppBundle:User:enter.html.twig', array('id' => $id , 'name'=>$name , 'surname'=>$surname));
				}
				else{
					$error = "Wrong Username or Password try again";
					return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array('form' => $form->createView() , 'error' => $error));
					
				};
				
			}
			
		}
        return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array('form' => $form->createView(),'error'=> $error,));
    }
    
    
    public function showAction($name) {
    	return $this->render('ISGProjectSubmissionAppBundle:User:show.html.twig', array('name' => $name));
    }
    
    
    public function profileAction($id) {
    	$user = UserQuery::create()->filterById($id)->findOne();
    	if (!$user) {
    		throw $this->createNotFoundException("No user with Id {$id}");
    	}   	
    	$role = $user->getRole();
    	$role_template = str_replace(" ", "_", strtolower($role->getDescription()));
        return $this->render('ISGProjectSubmissionAppBundle:User:profile/index.html.twig', array('user' => $user, 'role' => $role, 'roleTemplate' => $role_template));
    	
    	
    } 
    
    public function newAction(Request $request) {
    	
    	$form2 = $this->createFormBuilder()
    	    ->add('User_Email', 'email')
			->add('Username', 'text')
			->add('Firstname', 'text')
			->add('Lastname', 'text')
			->add('password', 'password')
			->add('Repeat_Password', 'password')
    	    ->getForm();
			
		$error = null;
			
		if( $request->getMethod() == 'POST' ){
			$form2->bind($request);
			$data = $form2->getData();
			$User_Email = $data['User_Email'];
			$Username = $data['Username'];
			$Firstname = $data['Firstname'];
			$Lastname = $data['Lastname'];
			$password = $data['password'];
			$password_repeat = $data['Repeat_Password'];
			
			if( $password == $password_repeat ){
				$salt=rand ( 10000000001 , 99999999999 );
				$password = md5( $password.md5($salt));
				$user = new User();
	    		$user->setUserEmail($User_Email);
	    		$user->setUsername($Username);
				$user->setUserFirstname($Firstname);
				$user->setUserLastname($Lastname);
	    		$user->setPassword($password);
				$user->setSalt($salt);
				$user->save();
				$error = "Succesfully Created User";
				return $this->redirect($this->generateUrl('_mainIndex'));
			}
			else{
				$error = "Passwords do not match.. Please try Again";
				return $this->render('ISGProjectSubmissionAppBundle:User:new/index.html.twig', array('form' => $form2->createView(),'error'=>$error));
			}
				
		}	
		
		return $this->render('ISGProjectSubmissionAppBundle:User:new/index.html.twig', array('form' => $form2->createView(),'error'=>$error));
    	
    }
    
    public function deleteAction() {
    	
    }
}

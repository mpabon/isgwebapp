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
			//->add('nikos','email')
    	    ->getForm();
			
		$error = null;
		
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			$data = $form->getData();
			//username = $request->getRequest('name');
			$username = $data['Username'];
			$password = $data['password'];
			//$email = $data['nikos'];
			//echo "$email";
			//echo "$username";
			//echo "$password";
		
		
			$user = UserQuery::create()
				->filterByUsername($username)
				->find();
			//echo $user;	
			if($user=='{  }'){
				$error = "Wrong Username or Password try again";
				return $this->render('ISGProjectSubmissionAppBundle:User:login.html.twig', array('form' => $form->createView() , 'error' => $error));
			}	
			else{
				$salt = $user[0]->getSalt();
				//echo $salt."\n";
				
				$id = $user[0]->getId();
				$name = $user[0]->getUserFirstname();
				//echo $name;
				
				
				$surname = $user[0]->getUserLastname();
				//echo $surname;
				
				$pass = $user[0]->getPassword();
				//echo $pass."\n";
				
				$plain_pass = $password.$salt;
				//echo "$plain_pass \n";
				//echo  md5($password.md5($salt));
				if(md5($password.md5($salt))==$pass){
					//echo "success";echo $name;echo $surname;
					return $this->render('ISGProjectSubmissionAppBundle:User:enter.html.twig', array('id' => $id , 'name'=>$name , 'surname'=>$surname));
				}
				else{
					$error = "Wrong Username or Password try again";
					return $this->render('ISGProjectSubmissionAppBundle:User:login.html.twig', array('form' => $form->createView() , 'error' => $error));
					
				};
				
			}
			
		}
        return $this->render('ISGProjectSubmissionAppBundle:User:login.html.twig', array('form' => $form->createView(),'error'=> $error,));
    }
    
    
    public function showAction($name) {
    	return $this->render('ISGProjectSubmissionAppBundle:User:show.html.twig', array('name' => $name));
    }
    
    
    public function registerAction(Request $request) {
    	/*$user = new User();
    	$user->setName("Pablo");
    	$user->setUsername("asdas");
    	$user->setPassword("zzzz");
    	$user->setDescription("hola");
    	
    	$user->save();
    	
    	return $this->render('ISGProjectSubmissionAppBundle:User:enter.html.twig', array('id' => $user->getId()));*/
    	$form2 = $this->createFormBuilder()
    	    ->add('User_Email', 'email')
			->add('Username', 'text')
			->add('Firstname', 'text')
			->add('Lastname', 'text')
			->add('password', 'password')
			->add('Repeat_Password', 'password')
    	    ->getForm();
			
		$error = null;
			
		if($request->getMethod() == 'POST'){
			$form2->bind($request);
			$data = $form2->getData();
			$User_Email = $data['User_Email'];
			$Username = $data['Username'];
			$Firstname = $data['Firstname'];
			$Lastname = $data['Lastname'];
			$password = $data['password'];
			$password_repeat = $data['Repeat_Password'];
			
			//echo "$User_Email $Username  $Firstname $Lastname $password $password_repeat";
			if($password == $password_repeat){
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
				return $this->render('ISGProjectSubmissionAppBundle:User:register.html.twig', array('form' => $form2->createView(),'error'=>$error));
			}
			
    	
    		
		}	
		return $this->render('ISGProjectSubmissionAppBundle:User:register.html.twig', array('form' => $form2->createView(),'error'=>$error));
    }
    
    public function deleteAction() {
    	
    }
}

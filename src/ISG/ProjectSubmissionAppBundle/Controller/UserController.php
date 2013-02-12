<?php

namespace ISG\ProjectSubmissionAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;


class UserController extends Controller {
	             
    public function indexAction () {
        return $this->render('ISGProjectSubmissionAppBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function loginAction () {
        return $this->render('ISGProjectSubmissionAppBundle:User:login/login.html.twig', array());
    }
    
    public function showAction($name) {
    	return $this->render('ISGProjectSubmissionAppBundle:User:show.html.twig', array('name' => $name));
    }
    
    
    public function enterAction() {
    	$user = new User();
    	$user->setName("Pablo");
    	$user->setUsername("asdas");
    	$user->setPassword("zzzz");
    	$user->setDescription("hola");
    	
    	$user->save();

    	
    	
    	return $this->render('ISGProjectSubmissionAppBundle:User:enter.html.twig', array('id' => $user->getId()));
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
    
    public function newAction() {
    	
    }
    
    
    public function deleteAction() {
    	
    }
}

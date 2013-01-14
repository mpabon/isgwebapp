<?php

namespace ISG\ProjectSubmissionAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ISG\ProjectSubmissionAppBundle\Model\Register;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller {
	  
    public function newAction(Request $request) {
    	
    	$register = new Register();
    	
    	$form = $this->createFormBuilder($register)
    	    ->add('name', 'text')
    	    ->getForm();
        
    	if( $request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    		
    		if ($form->isValid()) {
    			$register->setUpdatedAt(time());
    			$register->save();
    			
    			return $this->render('ISGProjectSubmissionAppBundle:Test:success.html.twig', array('name' => $register->getName()));
    		}
    	}
    	
    	return $this->render('ISGProjectSubmissionAppBundle:Test:new.html.twig', array('form' => $form->createView()));
    }
    
}

<?php

namespace ISG\ProjectSubmissionAppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->add("user_email", "text");
        $builder->add("username", "text");    
		$builder->add("user_firstname", "text");
 	    $builder->add("user_lastname", "text");
        $builder->add('password', 'repeated', array(
    											'type' => 'password',
    											'invalid_message' => 'The password fields must match.',
    											'options' => array('attr' => array('class' => 'password-field')),
    											'required' => true,
    											'first_options'  => array('label' => 'Password'),
    											'second_options' => array('label' => 'Repeat Password'),
					));
        
    	$builder->add('role', 'model', array(
            'class' => 'ISG\ProjectSubmissionAppBundle\Model\Role',

        ));
        
        $builder->add("phone_number", "text");
        $builder->add("project_year", "text");
		$builder->add("department", "text");
	}
	
	public function getName() {
		return 'user';
	}
	
}
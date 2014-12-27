<?php
$em->attach(
        'ZfcUser\Form\ChangeEmail', 'init', function($e) {
    $form = $e->getTarget();

    $form->remove('newIdentity');
    $form->add(array('name' => 'newIdentity', 'options' => array('label' => 'Neue Email',),
        'attributes' => array('type' => 'email',),
            )
    );
    $form->remove('newIdentityVerify');
    $form->add(array('name' => 'newIdentityVerify', 'options' => array('label' => 'Neue Email bestätigen',),
        'attributes' => array('type' => 'email',),
            )
    );
    $form->remove('credential');
    $form->add(array(
        'name' => 'credential', 'options' => array('label' => 'Passwort',),
        'attributes' => array('type' => 'password'),
    ));
   
}
);

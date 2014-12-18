<?php

$em->attach(
        'ZfcUser\Form\Register', 'init', function($e) {
    $form = $e->getTarget();

    $form->remove('username');
    $form->add(array('name' => 'username', 'options' => array('label' => 'Vorname Nachname',),
        'attributes' => array('type' => 'text','class'=>''),
            )
    );
    $form->remove('email');
    $form->add(array('name' => 'email', 'options' => array('label' => 'Email',),
        'attributes' => array('type' => 'text',),
            )
    );
    $form->remove('password');
    $form->add(array(
        'name' => 'password', 'options' => array('label' => 'Passwort',),
        'attributes' => array('type' => 'password'),
    ));
    $form->remove('passwordVerify');
    $form->add(array('name' => 'passwordVerify', 'options' => array('label' => 'Password Verify',), 'attributes' => array('type' => 'password'
        ),
    ));

    $form->remove('display_name');
    $form->add(array('name' => 'display_name', 'options' => array('label' => 'Nutzername',),
        'attributes' => array('type' => 'text',),
            )
    );

    $form->add(array('name' => 'street', 'options' => array('label' => 'Strasse',),
        'attributes' => array('type' => 'text',),
            )
    );

    $form->add(
            array('name' => 'plz', 'options' => array('label' => 'Postleitzahlen',),
                'attributes' => array('type' => 'text',),
            )
    );
    $form->add(
            array('name' => 'village', 'options' => array('label' => 'Ort',),
                'attributes' => array('type' => 'text',),
            )
    );
}
);

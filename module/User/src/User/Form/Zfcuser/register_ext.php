<?php

$em->attach(
        'ZfcUser\Form\Register', 'init', function($e) {
    $form = $e->getTarget();

    $form->remove('username');
    $form->add(array('name' => 'username', 'options' => array('label' => 'Vorname Nachname',),
        'attributes' => array('type' => 'text', 'class' => '', 'required'),
            )
    );
    $form->remove('email');
    $form->add(array('name' => 'email', 'options' => array('label' => 'Email',),
        'attributes' => array('type' => 'email', 'required'),
            )
    );

    $form->remove('password');
    $form->add(array(
        'name' => 'password', 'options' => array('label' => 'Passwort',),
        'attributes' => array('type' => 'password'),
    ));
    $form->remove('passwordVerify');
    $form->add(array(
        'name' => 'passwordVerify', 'options' => array('label' => 'Passwort wiederholen',),
        'attributes' => array('type' => 'password'
        ),
    ));

    $form->remove('display_name');
    $form->add(array('name' => 'display_name', 'options' => array('label' => 'Benutzername',),
        'attributes' => array('type' => 'text',), 'required',
            )
    );

    $form->add(array('name' => 'street', 'options' => array('label' => 'Strasse',),
        'attributes' => array('type' => 'text',), 'required',
            )
    );

    $form->add(
            array('name' => 'plz', 'options' => array('label' => 'Postleitzahl',),
                'attributes' => array('type' => 'text',), 'required',
            )
    );
    $form->add(
            array('name' => 'village', 'options' => array('label' => 'Ort',),
                'attributes' => array('type' => 'text',), 'required',
            )
    );
    
        $form->add(array('name' => 'phone', 'options' => array('label' => 'Telefon',),
        'attributes' => array('type' => 'tel', 'required'),
            )
    );
}
);

<?php

$em->attach(
        'ZfcUser\Form\ChangePassword', 'init', function($e) {
    $form = $e->getTarget();

    $form->remove('credential');
    $form->add(array(
        'name' => 'credential',
        'options' => array(
            'label' => 'Aktuelles Passwort',
        ),
        'attributes' => array(
            'type' => 'password',),
            )
    );

    $form->remove('newCredential');
    $form->add(array(
        'name' => 'newCredential',
        'options' => array(
            'label' => 'Neues Passwort',
        ),
        'attributes' => array(
            'type' => 'password',
        ),
            )
    );

    $form->remove('newCredentialVerify');
    $form->add(array(
        'name' => 'newCredentialVerify',
        'options' => array(
            'label' => 'Neues Passwort bestätigen',
        ),
        'attributes' => array(
            'type' => 'password',
        ),
            )
    );
    $form->remove('submit');
    $form->add(array(
        'name' => 'submit',
        'attributes' => array(
            'value' => 'Submit',
            'type' => 'submit'
        ),
            )
    );
}
);

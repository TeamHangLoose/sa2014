<?php

$em->attach(
        'ZfcUser\Form\ChangePassword', 'init', function($e) {
    $form = $e->getTarget();

    $form->remove('credential');
    $form->add(array('name' => 'credential', 'options' => array('label' => 'Neue Email',),
        'attributes' => array('type' => 'text',),
            )
    );
}
);

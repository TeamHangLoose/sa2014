
<?php
$sitepath = 'http://theothersite.ch'
?>
<?php if (isset($name)) { ?>
    Wilkommen <?= $name ?><br />
    <br />
<?php } ?>
Bitte bestaetigen Sie Ihre Email Adresse.<br />
<br />
Klicken Sie auf folgenden Link um diese zu bestaetigen:<br />
<br />
<?php
echo '<a' . 'http://theothersite.ch/double-opt-in/confirmed/' . ['token' => $token] . '>';
echo 'http://theothersite.ch/double-opt-in/confirmed/' . ['token' => $token] . '</a><br>'
?>

<a href="<?= $this->url('double-opt-in/confirmed', ['token' => $token], ['force_canonical' => true]) ?>"><?= $this->url('double-opt-in/confirmed', ['token' => $token], ['force_canonical' => true]) ?></a><br />
<br />

Wenn Sie diese Email Irrtuemlicherweise bekommen haben, koennen Sie diese ignorieren.

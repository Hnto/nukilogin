<?php $this->layout('main') ?>

<?php $this->section('content') ?>
<p style="color: #000000; font-weight: bold;" align="center">
    <a href="/account/home">Home</a> || <a href="/account/settings">Settings</a> || <a href="/account/logout">Logout</a>
</p>
<div class="form">
    <p class="message" style="color: #761c19; font-weight: bold;" align="center">
        <?= $Nuki->error; ?>
    </p>

    <p style="color: #000000; font-weight: bold;" align="center">
       Welcome to My Application
    </p>
</div>
<?php $this->append() ?>

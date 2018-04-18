<?php $this->layout('main') ?>

<?php $this->section('content') ?>
    <p style="color: #000000; font-weight: bold;" align="center">
        <a href="/account/home">Home</a> || <a href="/account/settings">Settings</a> || <a href="/account/logout">Logout</a>
    </p>
    <div class="form">
        <p class="message" style="color: #761c19; font-weight: bold;" align="center">
            <?= $Nuki->error; ?>
        </p>
        <p class="message" style="color: #2ca02c; font-weight: bold;" align="center">
            <?= $Nuki->success; ?>
        </p>
        <form method="post" action="/account/settings">
            <input type="hidden" name="userToken" value="<?= $Nuki->userToken; ?>" />

            <input type="password" name="oldPassword" placeholder="old password here" />
            <input type="password" name="newPassword" placeholder="new password here"  />
            <input type="password" name="newPasswordVerify" placeholder="verify new password here" />

            <input type="email" name="email" value="<?= $Nuki->user->getEmail(); ?>" />

            <button name="save">Save</button>
        </form>
    </div>
<?php $this->append() ?>

<?php $this->layout('main') ?>

<?php $this->section('content') ?>
    <div class="form">
        <p class="message" style="color: #761c19; font-weight: bold;" align="center">
            <?= $Nuki->error; ?>
        </p>
        <p></p>
        <form class="login-form" method="post" action="/login">
            <input type="hidden" name="userToken" value="<?= $Nuki->userToken; ?>" />
            <input type="text" name="username" placeholder="username"/>
            <input type="password" name="password" placeholder="password"/>
            <button name="login">Sign in</button>
            <p class="message">Not registered? <a href="/register">Create an account</a></p>
        </form>
    </div>
<?php $this->append() ?>


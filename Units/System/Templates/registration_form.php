<?php $this->layout('main') ?>

<?php $this->section('content') ?>
    <div class="form">
        <p class="message" style="color: #2ca02c; font-weight: bold;" align="center">
            <?= $Nuki->success; ?>
        </p>
        <p class="message" style="color: #761c19; font-weight: bold;" align="center">
            <?= $Nuki->error; ?>
        </p>
        <p></p>
        <form class="register-form" method="post" action="/register">
            <input type="hidden" name="userToken" value="<?= $Nuki->userToken; ?>" />
            <input type="text" name="username" placeholder="name"/>
            <input type="password" name="password" placeholder="password"/>
            <input type="email" name="email" placeholder="email address"/>
            <button name="register">Register</button>
            <p class="message">Already registered? <a href="/login">Sign In</a></p>
        </form>
    </div>
<?php $this->append() ?>

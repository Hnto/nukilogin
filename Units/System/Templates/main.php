<!DOCTYPE html>
<html>
<head>
    <?php $this->section('head') ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
        crossorigin="anonymous">
    </script>
    <title><?php $this->section('title') ?>My application<?php $this->stop() ?></title>
    <?php $this->stop() ?>
</head>
<body>
<div id="content">
    <div class="page">
        <?php $this->section('content') ?>
        <?php $this->stop() ?>
    </div>
</div>
<div id="footer" align="center">
    <?php $this->section('footer') ?>
    &copy; Copyright 2018 - <?= date('Y'); ?>
    <?php $this->stop() ?>
</div>
</body>
</html>
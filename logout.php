<?php
require 'classes/User.php';
require 'includes/redirect.php';

User::logout();
redirect('/');
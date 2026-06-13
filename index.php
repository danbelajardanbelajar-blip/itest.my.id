<?php

// Front Controller
session_start();

// Define Base Path
define('BASE_PATH', __DIR__);

// Load Configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Load Core MVC Classes
require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';
require_once 'app/core/Auth.php';
require_once 'app/core/Middleware.php';
require_once 'app/core/Helpers.php';

// Initialize the Application
$app = new App();

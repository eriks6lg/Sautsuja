<?php

require('Controller.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'home':
                controller_page_load('home');
                break;
            case 'toptoday':
                controller_page_load('toptoday');
                break;
            case 'topalltime':
                controller_page_load('topalltime');
                break;
            case 'profile':
                controller_page_load('profile');
                break;
            case 'contacts':
                controller_page_load('contacts');
                break;
        }
    }
}

require('View.php');
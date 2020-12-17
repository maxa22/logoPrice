<?php

/*** Function for loading the page ***/
function load_page($page, $data = null){
    // Check is page empty. If it is, load the default page
    if($page === ''){
        require 'pages/index.php';
        return;
    }
    // Create whitelist so nonexisting page cannot be loaded, and pages with third argument can be loaded without problems
    switch($page){
        // Normal pages in whitelist
        case 'login':
        case 'register':
        case 'calculators':
        case 'questions':
        case 'add_question':
        case 'create_calc':
        case 'edit':
        case 'estimate':
        case 'calculator_redirect':
            require 'pages/' . $page . '.php';
        break;
        case range(1,10000):
            require 'pages/calculator_redirect.php';
        break;
        // case preg_match('/[\d]+/', $page):
        //     require 'pages/calculator_redirect.php';
        // break;     
        default:
            // Load index by default
            require 'pages/index.php';
        return;
    }
}

    if(isset($_GET['page']) && !empty($_GET['page'])){

    /*** Get the third argument ***/
    @$data = $_GET['data'];

    /*** Call loading function from includes/functions.php ***/
    load_page($_GET['page'], $data);
    }
?>
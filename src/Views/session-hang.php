
<?
    function useful_function() {
        sleep(1);
    }
    session_start();
    if(isset($_SESSION['visit_count'])===FALSE){
        $_SESSION['visit_count'] = 1;
    }
    else{
        $_SESSION['visit_count'] += 1;
    }
    $visit_count = 'visit_count = '.$_SESSION['visit_count'];
    echo $visit_count;
    // aries_add_message_profile($visit_count); //add 'visit_count' to jennifer profiles
    
    useful_function();
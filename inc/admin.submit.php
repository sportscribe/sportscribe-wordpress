<?php

// Process the submit from the admin panel
function sportscribe_doSubmit() {
        if(isset($_POST['sportscribe_apikey'])) {
        // CHECK THAT API KEY WORKS

          $endpoint = trim( $_POST['sportscribe_endpoint'], '/' );

          if(ss_test_api( $_POST['sportscribe_apikey'], $endpoint )) {
            echo '<b>API GOOD!</b><br><br>';
            update_option('sportscribe_apikey',$_POST['sportscribe_apikey']);
            update_option('sportscribe_endpoint',$_POST['sportscribe_endpoint']);
          } else {
            echo '<b>Invalid API KEY or ENDPOINT</b><br><br>';
          }

        } else if(isset($_POST['test_post'])) {



        } else if ( isset($_POST['test_grab']) ) {

          $date = $_POST['grab_date'];
          sportscribe_fetch($date);

        } else if ( isset($_POST['ss_settings']) ) {

          if(isset($_POST['front_page']))
            update_option('sportscribe_front_page', 1 );
          else
            update_option('sportscribe_front_page', 0 );

          if(isset($_POST['sportscribe_grab_days']) && is_numeric($_POST['sportscribe_grab_days']))
            update_option('sportscribe_grab_days', min(14,$_POST['sportscribe_grab_days']) );


        }

}

?>

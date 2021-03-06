<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<h2 id="title">Sign in</h2>';

//first, check if the user is already signed in. If that is the case, there is no need to display this page
if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    echo '<p id="msg">You are already signed in, you can <a href="signout.php">sign out</a> if you want.<p>';
} else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form class="form-inline"  method="post" action="">
            <div class="form-group">
            <label id="signin-label1" for="user_name">Username: </label><input class="form-control" type="text" name="name" />
            </div>
            <div class="form-group">
            <label id="signin-label2" for="user_pass">Password: </label><input class="form-control" type="password" name="password">
            </div>
            <input id="signin-btn" class="btn btn-primary" type="submit" value="Sign in" />
         </form>';
    } else {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
        
        if (!isset($_POST['name'])) {
            $errors[] = 'The username field must not be empty.';
        }
        
        if (!isset($_POST['password'])) {
            $errors[] = 'The password field must not be empty.';
        }
        
        if (!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/ {
            echo 'Some fields are not filled in correctly!';
//            echo '<ul>';
//            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
//            {
//                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
//            }
//            echo '</ul>';
        } else {
            //the form has been posted without errors, so save it
            if (!is_array($array)) {
                //something went wrong, display the error
                echo '<p id="msg">The user doesn\'t exist. Please<a href="signUp.php"> sign-up<a>!</p>';
                //echo mysqli_error($conn); //debugging purposes, uncomment when needed
            } else {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                foreach ($user as $name) {
                    if ( $_POST['password'] != $row['password'] && !password_verify( $_POST['password'], $row['password'] ) ){
                        echo '<p id="msg">You have supplied a wrong username or password. Please try again.</p>';
                    } else {
                        $_SESSION['signed_in'] = true;
                        $_SESSION['cvrnumber'] = $row['cvrnumber'];
                        $_SESSION['name'] = $row['name'];
//                        $_SESSION['user_level'] = $row['user_level'];

                        echo '<p id="msg">Welcome, ' . $_SESSION['name'] . '. <a href="index.php">Proceed to the shop overview</a>.<p>';

                    }
                }
            }
        }
    }
}
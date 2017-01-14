<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
  ?>

  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
  First Name:<br /> <input type="text" name="first_name" value="" /><br />
  Last Name:<br /> <input type="text" name="last_name" value="" /><br />
  E-mail:<br /> <input type="text" name="email" value="" /><br />
  User Name:<br /> <input type="text" name="username" value="" /><br />
  Password:<br /> <input type="password" name="password" value="" /><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if (is_post_request()) {
    // Confirm that POST values are present before accessing them.

    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    $errors = [];    
    //validate first_name
    if (is_blank($_POST['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 30])) {
      $errors[] = "First name must be between 2 and 30 characters.";
    }
    //validate last_name
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 30])) {
      $errors[] = "Last name must be between 2 and 30 characters.";
    }
    //validate email
    if (is_blank($_POST['email'])) {
      $errors[] = "E-mail cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 2, 'max' => 255])) {
      $errors[] = "E-mail must be between 2 and 255 characters.";
    }    
    //validate username
    if (is_blank($_POST['username'])) {
      $errors[] = "User Name cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 2, 'max' => 30])) {
      $errors[] = "User Name must be between 2 and 30 characters.";
    } elseif (!has_valid_email_format($email)) {
      //check for valid email address
      $errors[] = "Please provide a valid e-mail address.";
    }

    


    if (empty($errors)) {
 
    // if there were no errors, submit data to database

      //Need one more variable, created_at
      $created_at = date("Y-m-d H:i:s");

      // Write SQL INSERT statement
      $sql = "INSERT INTO  users (";
      $sql .= "first_name, last_name, email, username, created_at";
      $sql .= ") VALUES (";
      $sql .= "'${first_name}', '{$last_name}', '{$email}', '{$username}', '{$created_at}'";
      $sql .=")";

      // For INSERT statments, $result is just true/false
       $result = db_query($db, $sql);
       if($result) {
         db_close($db);
         echo "<p>{$result}</p>";
      //   TODO redirect user to success page

       } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
         echo db_error($db);
         db_close($db);
         exit;
       }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    if (isset($errors)){
      $error_text = display_errors($errors);
      if ($error_text != '') { echo $error_text; }
    }
  ?>

  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
  First Name:<br /> <input type="text" name="first_name" value="<?php if (isset($first_name)) { echo $first_name; } ?>" /><br />
  Last Name:<br /> <input type="text" name="last_name" value="<?php if (isset($last_name)) { echo $last_name; } ?>" /><br />
  E-mail:<br /> <input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" /><br />
  User Name:<br /> <input type="text" name="username" value="<?php if (isset($username)) { echo $username; } ?>" /><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

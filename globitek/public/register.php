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
    } elseif (!has_valid_characters($first_name, "/\A[A-Za-z\s\-,\.\']+\Z/")){
      //Validate for whitelisted characters using regex
      $errors[] = "First name can only include letters, spaces, \"-\", \",\", and \".\".";
    }
    //validate last_name
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 30])) {
      $errors[] = "Last name must be between 2 and 30 characters.";
    } elseif (!has_valid_characters($last_name, "/\A[A-Za-z\s\-,\.\']+\Z/")){
      //Validate for whitelisted characters using regex
      $errors[] = "Last name can only include letters, spaces, \"-\", \",\", and \".\".";
    }
    //validate email
    if (is_blank($_POST['email'])) {
      $errors[] = "E-mail cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 2, 'max' => 255])) {
      $errors[] = "E-mail must be between 2 and 255 characters.";
    } elseif (!has_valid_email_format($email)) {
      $errors[] = "Please provide a valid E-mail address.";

    }elseif (!has_valid_characters($email, "/\A[A-Za-z0-9\_\@']+\Z/")){
      //Validate for whitelisted characters using regex
      $errors[] = "E-mail can only include letters, numbers, \"_\", and \"@\" .";
    }    
    //validate username
    if (is_blank($_POST['username'])) {
      $errors[] = "User name cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 2, 'max' => 30])) {
      $errors[] = "User name must be between 2 and 30 characters.";
    }  elseif (!has_valid_characters($username, "/\A[A-Za-z0-9\_']+\Z/")){
      //Validate for whitelisted characters using regex
      $errors[] = "User name can only include letters, numbers, and \"_\".";
    }  else {
      //Validate uniqueness of user name
      $username = db_escape($db, $username);
      // Write SQL query statement
      $query = "SELECT * ";
      $query .= "FROM users ";
      $query .= "WHERE username = '{$username}'";

      $uniqueness_result = mysqli_query($db, $query);

      if (mysqli_num_fields($uniqueness_result) != 0) {
        $errors[] = "That user name is already taken.";
      }

    }

    


    if (empty($errors)) {
 
    // if there were no errors, submit data to database

      //Need one more variable, created_at
      $created_at = date("Y-m-d H:i:s");

      //Sanitize variables for MYSQL
      $first_name = db_escape($db, $first_name);
      $last_name = db_escape($db, $last_name);
      $email = db_escape($db, $email);
      $username = db_escape($db, $username);
      

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
      //   TODO redirect user to success page
         redirect_to('./registration_success.php');

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
  First Name:<br /> <input type="text" name="first_name" value="<?php if (isset($first_name)) { echo h($first_name); } ?>" /><br />
  Last Name:<br /> <input type="text" name="last_name" value="<?php if (isset($last_name)) { echo h($last_name); } ?>" /><br />
  E-mail:<br /> <input type="text" name="email" value="<?php if (isset($email)) { echo h($email); } ?>" /><br />
  User Name:<br /> <input type="text" name="username" value="<?php if (isset($username)) { echo h($username); } ?>" /><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

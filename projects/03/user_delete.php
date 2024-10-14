<?php
// Step 1: Include config.php file
include 'config.php';

// Step 2: Secure and only allow 'admin' users to access this page

// Step 3: Check if the $_GET['id'] exists (isset); if it does, get the user the record from the database and store it in the associative array $user. If a user record with that ID does not exist, display the message "A user with that ID did not exist."

// Step 4: Check if $_GET['confirm'] == 'yes'. This means they clicked the 'yes' button to confirm the removal of the record. Prepare and execute a SQL DELETE statement where the user id == the $_GET['id']. Else (meaning they clicked 'no'), return them to the users_manage.php page.
// prepare a SQL statment: DELETE FROM 'users' WHERE id = ?

?>
<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

    <!-- BEGIN YOUR CONTENT -->
    <h1 class="title">This is my page content.</h1>
    <h2 class="subtitle">This is the subtitle</h2>
    <!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>
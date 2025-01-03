<?php 
// Step 1: Include config.php file
include 'config.php'; 

// Step 2: Secure and only allow 'admin' users to access this page
if (!isset($_SESSION['loggedin']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect user to login page or display an error message
    $_SESSION['messages'][] = "You must be an administrator to access that resource.";
    header('Location: login.php');
    exit;
}

// Step 3: Check if the $_GET['id'] exists; if it does, get the article record from the database and store it in the associative array $article. If an article with that ID does not exist, display "An article with that ID did not exist."
if (isset($_GET['id'])) {

    // Prepare and execute a query to fetch the article by id
    $stmt = $pdo->prepare("SELECT * FROM `articles` WHERE `id` = ?");
    $stmt->execute([$_GET['id']]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no article is found, show the error
    if (!$article) {
        $_SESSION['messages'][] = "An article with that ID did not exist.";
    }

}

// Step 4: Check if $_GET['confirm'] == 'yes'. This means they clicked the 'yes' button to confirm the removal of the record. Prepare and execute a SQL DELETE statement where the article id == the $_GET['id']. Else (meaning they clicked 'no'), return them to the articles.php page.
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Prepare and execute the DELETE statement
    $deleteStmt = $pdo->prepare("DELETE FROM `articles` WHERE `id` = ?");
    $deleteStmt->execute([$_GET['id']]);
    // Set a success message and redirect to the articles page
    $_SESSION['messages'][] = "Article was successfully deleted.";
    header('Location: articles.php');
    exit;
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'no') {
    // Redirect back to the articles page if they clicked "No"
    header('Location: articles.php');
    exit;
}

?>
<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Delete Article</h1>
    <p class="subtitle">Are you sure you want to delete the article: <?= $article['title'] ?></p>
    <div class="buttons">
        <a href="?id=<?= $article['id'] ?>&confirm=yes" class="button is-success">Yes</a>
        <a href="articles.php" class="button is-danger">No</a>
    </div>
</section>
<!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>
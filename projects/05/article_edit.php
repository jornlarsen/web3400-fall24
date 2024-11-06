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

// Step 3: Check if the update form was submitted. If so, update article details using an UPDATE SQL query.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract, sanitize user input, and assign data to variables
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    // Update article information
    $insertStmt = $pdo->prepare("UPDATE `articles` SET `title`= ?,`content`= ?, `modified_on` = NOW() WHERE `id` = ?");
    $insertStmt->execute([$title, $content, $_POST['id']]);

    $_SESSION['messages'][] = "Article was successfully edited.";
    header('Location: articles.php');
    exit;
}

// Step 4: Else it's an initial page request, fetch the article's current data from the database by preparing and executing a SQL statement that uses the article id from the query string (ex. $_GET['id'])
if (isset($_GET['id'])) {

    // Prepare and execute the SELECT query to fetch the user data
    $stmt = $pdo->prepare("SELECT * FROM `articles` WHERE `id` = ?");
    $stmt->execute([$_GET['id']]);
    $article = $stmt->fetch();
}


?>
<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

    <!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Edit Article</h1>
    <form action="" method="post">
        <!-- ID -->
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
        <!-- Title -->
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" value="<?= $article['title'] ?>" required>
            </div>
        </div>
        <!-- Content -->
        <div class="field">
            <label class="label">Content</label>
            <div class="control">
                <textarea class="textarea" id="content" name="content" required><?= $article['content'] ?></textarea>
            </div>
        </div>
        <!-- Submit -->
        <div class="field is-grouped">
            <div class="control">
                <button type="submit" class="button is-link">Update Article</button>
            </div>
            <div class="control">
                <a href="articles.php" class="button is-link is-light">Cancel</a>
            </div>
        </div>
    </form>
</section>
<!-- END YOUR CONTENT -->


<?php include 'templates/footer.php'; ?>
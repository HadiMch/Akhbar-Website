<?php
include 'partials/header.php';

//fetch post from database if id is set
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'] , FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE posts_id=$id";
    $result = mysqli_query($connection , $query);
    $post = mysqli_fetch_assoc($result);
} else{
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>
<!-- End of Nav-->


<section class="singlepost">
    <div class="container singlepost-container">
        <h2><?= $post['posts_title'] ?></h2>
        <div class="post-author">
        <?php 
                $author_id = $post['author_id'];
                $author_query = "SELECT * FROM users WHERE users_id=$author_id";
                $author_result = mysqli_query($connection , $author_query);
                $author = mysqli_fetch_assoc($author_result);

                ?>
            <div class="post-author-avatar">
                <img src="./images/<?= $author['users_avatar'] ?>">
            </div>
            <div class="post-author-info">
                <h5>By: <?= $author['users_firstname'] . " " . $author['users_lastname'] ?></h5>
                <small><?= date("M d, Y - H:i" , strtotime($post['posts_datetime'])) ?></small>
            </div>
        </div>
        <div class="singlepost-thumbnail">
            <img src="images/<?= $post['posts_thumbnail'] ?>">
        </div>
      <p><?= $post['posts_body'] ?></p>
    </div>
  </section>


<?php 
include './partials/footer.php';
?>
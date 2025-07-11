<?php 
require './partials/header.php';

if(isset($_GET['search']) && isset($_GET['submit'])){
    $search = filter_var($_GET['search'] ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM posts WHERE posts_title LIKE '%$search%' ORDER BY posts_datetime DESC ";
    $posts = mysqli_query($connection , $query);
} else{
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<section class="posts section-extra-margin">
        <div class="container posts-container">
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post-thumbnail">
                    <img src="./images/<?= $post['posts_thumbnail'] ?>">
                </div>
                <div class="post-info">
                <?php 
            //fetch category from categories table using category_id of post
            $category_id = $post['category_id'];
            $category_query = "SELECT * FROM categories WHERE categories_id=$category_id";
            $category_result = mysqli_query($connection , $category_query);
            $category = mysqli_fetch_assoc($category_result);
          
            ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category-button"><?= $category['categories_title'] ?></a>
                    <h3 class="post-title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['posts_id'] ?>"><?= $post['posts_title'] ?></a></h3>
                    <p class="post-body"> <?= substr($post['posts_body'] ,0,100) ?>...</p>
                         <div class="post-author">
                         <?php 
                $author_id = $post['author_id'];
                $author_query = "SELECT * FROM users WHERE users_id=$author_id";
                $author_result = mysqli_query($connection , $author_query);
                $author = mysqli_fetch_assoc($author_result);

                ?>
                            <div class="post-author-avatar">
                                <img src="images/<?= $author['users_avatar'] ?>">
                            </div>
                            <div class="post-author-info">
                                <h5>By: <?= $author['users_firstname'] . " " . $author['users_lastname'] ?></h5>
                                <small><?= date("M d, Y - H:i" , strtotime($post['posts_datetime'])) ?></small>
                            </div>
                         </div>
                </div>
            </article>
            <?php endwhile ?>
        </div>
    </section>

<?php 
include './partials/footer.php';
?>
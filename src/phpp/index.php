<?php 
include './partials/header.php';

//fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE posts_isfeatured=1";
$featured_result = mysqli_query($connection , $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch 9 posts from posts table
$query = "SELECT * FROM posts ORDER BY posts_datetime DESC LIMIT 9";
$posts = mysqli_query($connection , $query);


?>
    <?php if(mysqli_num_rows($featured_result)  == 1 ) : ?>
    <section class="featured">
        <div class="container featured-container">
            <div class="post-thumbnail">
                <img src="./images/<?= $featured['posts_thumbnail'] ?>">
            </div>
        <div class="post-info">
            <?php 
            //fetch category from categories table using category_id of post
            $category_id = $featured['category_id'];
            $category_query = "SELECT * FROM categories WHERE categories_id=$category_id";
            $category_result = mysqli_query($connection , $category_query);
            $category = mysqli_fetch_assoc($category_result);
          
            ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category-button"><?= $category['categories_title'] ?></a>
            <h2 class="post-title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['posts_id'] ?>"><?= $featured['posts_title'] ?></a></h2>
            <p class="post-body">
                <?= substr($featured['posts_body'] ,0,100) ?> ...
            </p>
            <div class="post-author">
                <?php 
                $author_id = $featured['author_id'];
                $author_query = "SELECT * FROM users WHERE users_id=$author_id";
                $author_result = mysqli_query($connection , $author_query);
                $author = mysqli_fetch_assoc($author_result);

                ?>
                <div class="post-author-avatar">
                    <img src="images/<?= $author['users_avatar'] ?>">
                </div>
                <div class="post-author-info">
                    <h5>By: <?= $author['users_firstname'] . " " . $author['users_lastname'] ?></h5>
                    <small><?= date("M d, Y - H:i" , strtotime($featured['posts_datetime'])) ?></small>
                </div>
            </div>
        </div>
    </div>
    </section>
    <?php endif ?>
    <!-- End of Featured-->

    <section class="posts">
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
<!-- End of Posts-->

<section class="category-buttons">
    <div class="container category-buttons-container">
        <?php 
        $all_categories_query = "SELECT *  FROM categories";
        $all_categories_result = mysqli_query($connection , $all_categories_query);
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories_result)) : ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['categories_id'] ?>" class="category-button"><?=$category['categories_title']?></a>
       <?php endwhile ?>
    </div>
</section>
<!-- End of Categories -->


<?php
include './partials/footer.php';
?>
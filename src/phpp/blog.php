<?php 
include './partials/header.php';
$query = "SELECT * FROM posts ORDER BY posts_datetime DESC";
$posts = mysqli_query($connection , $query);
?>
<!-- End of Nav-->
    <section class="search-bar">
        <form class="container search-bar-container" action="<?= ROOT_URL ?>search.php" method="get">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                  </svg>
                <input type="search" name="search"  placeholder="Search">                 
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
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

<?php
include './partials/footer.php';
?>
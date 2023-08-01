<?php
$book_id = get_the_ID();
$author = get_field('author', $book_id);
$genre = get_field('genre', $book_id);
$publish_year = get_field('publish_year', $book_id);
$price = get_field('price', $book_id);
$description = get_field('description', $book_id);
?>
<section>
   <div class="row">
    <div class="col-12 col-md-6 pe-md-4">
      <?php echo get_the_post_thumbnail($book_id, 'full', array("class" => "w-100 h-100 object-fit-cover")); ?>
    </div>
    <div class="col-12 col-md-6 ps-md-4">
      <h1 class="mt-0 mb-0"><?php the_title(); ?></h1>
      <h6 class="mt-0 mb-5"><?php echo $genre; ?></h6>
      <h4 class="mt-0 mb-2"><?php echo $author; ?></h4>
      <p class="mt-0 mb-2"><strong><?php echo $publish_year; ?></strong></p>
      <h3 class="mt-0 mb-4"><?php echo $price; ?></h3>
      <div><?php echo $description; ?></div>
    </div>
   </div>
</section>
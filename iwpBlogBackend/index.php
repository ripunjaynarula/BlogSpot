<?php include("path.php"); ?>
<?php include("app/database/db.php"); ?>
<?php include("app/controllers/topics.php");?>
<?php error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); ?>
<?php 
  $posts = array();
  $postsTitle = 'Recent Posts';
  

  if(isset($_GET['t_id'])){
    $posts = getPostsByTopicId($_GET['t_id']);
    $postsTitle = "Search by Topic Results";
  } else if(isset($_POST['search-term'])){
    $posts = searchPosts($_POST['search-term']);
    $postsTitle = "Search Results";
  } else {
    $posts = getPublishedPosts();
  }

  
  
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">

  <title>Blog</title>
</head>

<body>
  
  <?php include(ROOT_PATH . "/app/includes/header.php");?>

  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider -->
    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">

      <?php foreach ($posts as $post): ?>
        <div class="post">
          <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image" >
          <div class="post-info">
            <h3><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
            <i class="far fa-user"> <span><?php echo $post['username']; ?></span></i>
            &nbsp;
            <i class="far fa-calendar"> <span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span></i>
          </div>
        </div>
      <?php endforeach; ?>

        

      </div>

    </div>
    <!-- // Post Slider -->

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title"><?php echo $postsTitle ;?></h1>

        <?php foreach ($posts as $post): ?>
          <div class="post clearfix">
          <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="post-image" usemap="#blogmap">
          <div class="post-preview">
            <h2><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
            <i class="far fa-user"><?php echo $post['username']; ?></i>
            &nbsp;
            <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
            <p class="preview-text">
              <?php echo substr($post['body'], 0, 150) . '...' ?>
            </p>
            <a href="single.php?id=<?php echo $post['id']; ?>" class="btn read-more">Read More</a>
          </div>
        </div>
        <?php endforeach; ?>

      </div>

      <!-- usemap -->
      <map name="blogmap">
        <area shape="rect" coords="0,0,382,326" href="single.html" alt="blog">
      </map>

      <!-- // Main Content -->

      <div class="sidebar">

        <div class="section search">
          <h2 class="section-title">Search</h2>
          <form action="/index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Search...">
          </form>
        </div>


        <div class="section topics">
          <h2 class="section-title">Topics</h2>
          <ul>
            <?php foreach ($topics as $key => $topic): ?>
              <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] ?>"><?php echo $topic['name']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div>

    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->

  <!-- footer -->
  <?php include("app/includes/footer.php");?>
  <!-- // footer -->


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Slick Carousel -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/script.js"></script> 

</body>

</html>

           
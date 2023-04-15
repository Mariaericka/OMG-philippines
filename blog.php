<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMG Philippines | Blog</title>
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Own Carousel -->
 <link rel="stylesheet" href="css/owl.carousel.min.css">


  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">
   <link rel="stylesheet" href="css/bootstrap.css">


</head>
<body>

<?php include 'components/user_header.php'; ?>

<main>
    
    <section class="site-title">
        <div class="site-background">
            <h3>OMG is the perfect choice</h3>
            <h1>OVERLOAD GOODNESS IN EVERY CUP</h1>
        </div>
    </section>

</main>

<section>
        <div class="blog">
            <div class="container">
                <div class="owl-carousel owl-theme blog-post">
                    <div class="blog-content">
                        <img src="images/blog-post-1.jpg" alt="post-1">
                        <div class="blog-title">
                            <h3>Buy one take one milk shake for only 88 pesos!</h3>
                            <button class="btn btn-blog">Milkshakes</button>
                            <span>2 minutes ago</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <img src="images/blog-post-2.jpg" alt="post-2">
                        <div class="blog-title">
                            <h3>Price rollback sale from P69 to P45!</h3>
                            <button class="btn btn-blog">Coffees</button>
                            <span>2 minutes ago</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <img src="images/blog-post-3.jpg" alt="post-3">
                        <div class="blog-title">
                            <h3>Yogurt for only P88!</h3>
                            <button class="btn btn-blog">Yogurts</button>
                            <span>2 minutes ago</span>
                        </div>
                    </div>
                </div>
                <div class="owl-navigation">
                    <span class="owl-nav-prev"><i class="fa-solid fa-circle-chevron-left"></i></span>
                    <span class="owl-nav-next"><i class="fa-solid fa-circle-chevron-right"></i></span>
                </div>
            </div>
        </div>
    </section>

<!------------------- Site Content ----------------->


<section class="container">
        <div class="site-content">
            <div class="posts">
                <div class="post-content">
                    <div class="post-image">
                        <div>
                            <img src="images/franchise-1.jpg" alt="franchise-1"  >
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fa-solid fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                            <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 21, 2022</span>
                            <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;2 comments</span>
                        </div>
                    </div>
                    <div class="post-title">
                        <a href="#">OMG Quezon City will open soon!</a>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores reprehenderit, veniam nisi recusandae modi eius vel dolore odio ut a suscipit sint neque beatae. Facilis tempore iure vitae, eveniet voluptatibus nam suscipit perspiciatis accusamus quaerat maxime minus voluptate nisi eius.</p>
                        <button class="btn post-btn">Read more &nbsp;<i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <hr>
                <div class="post-content">
                    <div class="post-image">
                        <div>
                            <img src="images/likes.png" alt="franchise-1"  >
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fa-solid fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                            <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 20, 2022</span>
                            <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;5 comments</span>
                        </div>
                    </div>
                    <div class="post-title">
                        <a href="#">OMG has now reached 10k followers on facebook!</a>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores reprehenderit, veniam nisi recusandae modi eius vel dolore odio ut a suscipit sint neque beatae. Facilis tempore iure vitae, eveniet voluptatibus nam suscipit perspiciatis accusamus quaerat maxime minus voluptate nisi eius.</p>
                        <button class="btn post-btn">Read more &nbsp;<i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <hr>
                <div class="post-content">
                    <div class="post-image">
                        <div>
                            <img src="images/newest.jpg" alt="franchise-1"  >
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fa-solid fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                            <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 21, 2022</span>
                            <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;15 comments</span>
                        </div>
                    </div>
                    <div class="post-title">
                        <a href="#">Premium drinks is the best seller! Here's why..</a>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores reprehenderit, veniam nisi recusandae modi eius vel dolore odio ut a suscipit sint neque beatae. Facilis tempore iure vitae, eveniet voluptatibus nam suscipit perspiciatis accusamus quaerat maxime minus voluptate nisi eius.</p>
                        <button class="btn post-btn">Read more &nbsp;<i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <hr>
                <div class="post-content">
                    <div class="post-image">
                        <div>
                            <img src="images/customers.jpg" alt="franchise-1"  >
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fa-solid fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                            <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 21, 2022</span>
                            <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;20 comments</span>
                        </div>
                    </div>
                    <div class="post-title">
                        <a href="#">Reasons why OMG is the perfect choice</a>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores reprehenderit, veniam nisi recusandae modi eius vel dolore odio ut a suscipit sint neque beatae. Facilis tempore iure vitae, eveniet voluptatibus nam suscipit perspiciatis accusamus quaerat maxime minus voluptate nisi eius.</p>
                        <button class="btn post-btn">Read more &nbsp;<i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
                <div class="pagination flex-row">
                    <a href="#"><i class="fa-solid fa-angle-left"></i></a>
                    <a href="#" class="pages">1</a>
                    <a href="#" class="pages">2</a>
                    <a href="#" class="pages">3</a>
                    <a href="#"><i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
            <aside class="sidebar">
                <div class="category">
                    <h2>category</h2>
                    <ul class="category-list">
                        <li class="list-items">
                            <a href="#">Bevarages</a>
                            <span>(05)</span>
                            <li class="list-items">
                                <a href="#">Franchise</a>
                                <span>(07)</span>
                                <li class="list-items">
                                    <a href="#">Favourites</a>
                                    <span>(08)</span>
                                    <li class="list-items">
                                        <a href="#">History</a>
                                        <span>(09)</span>

                        </li>
                    </ul>
                </div>
                <div class="popular-post">
                    <h2>Popular post</h2>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images//blog-post-4.jpg">
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 21, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;2 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">3 days april fools sale!</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images/image 1.png"  >
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 21, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;2 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">New beverages are coming!</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images//image 3.png" alt="franchise-1">
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 18, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;3 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">Milkteas for kids are avaible for only 49!</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images/image 7.png" alt="franchise-1">
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 18, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp;3 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">Overload chocolate shake is people's choice!</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images/image 9.png" alt="franchise-1">
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 15, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp; 90 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">Milkshakes perfect for this summer</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-image">
                            <div>
                                <img src="images/image 2.png" alt="franchise-1">
                            </div>
                            <div class="post-info flex-row">
                                <span><i class="fa-solid fa-calendar-days text-gray"></i>&nbsp;&nbsp;April 10, 2022</span>
                                <span><i class="fa-solid fa-comments"></i>&nbsp;&nbsp; 16 comments</span>
                            </div>
                        </div>
                        <div class="post-title">
                            <a href="#">Try our newest frappe!</a>
                        </div>
                    </div>
                </div>
                <div class="newsletter">
                    <h2>Newsletter</h2>
                    <div class="form-elemet">
                        <input type="text" class="inout-element" placeholder="email">
                        <button class="btn form-btn">Subscribe</button>
                    </div>
                </div>
                <div class="popular-tags">
                    <h2>Popular tags</h2>
                    <div class="tags flex-row">
                        <span class="tag">OMG-Alaminos Laguna</span>
                        <span class="tag">Overload milkshakes</span>
                        <span class="tag">Premium drinks</span>
                        <span class="tag">Branches</span>
                        <span class="tag">Prices</span>
                    </div>
                </div>

            </aside>
        </div>
    </section>

    <!----------x--------- Site Content --------x--------->



    </body>
    <?php include 'components/footer.php'; ?>

     <!-- Owl Carousel -->
    <script src="js/Jquery3.6.0.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/script2.js"></script>



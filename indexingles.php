<?php
include('forms/config.php');

function getProdutosByCategoria($conexao, $categoria)
{
    $sql = "SELECT * FROM produtos WHERE categoria = '$categoria' ORDER BY id_produtos DESC";
    $result = $conexao->query($sql);
    return $result;
}

$categorias = array('Roupas', 'Maquiagens', 'Acessórios');

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>Bella Makes</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/responsive.css">
      <link rel="icon" href="assets/images/icon.png" />
      <link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
      <link rel="stylesoeet" href="assets/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

      <style>
         .product_image {
            text-align: center; 
         }

         .product_image img {
            max-width: 100%; 
            height: auto;
            display: inline-block; 
            vertical-align: middle; 
         }
      </style>
   </head>
   <body>
      <div class="banner_bg_main">
         <div class="container">
            <div class="header_section_top">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="custom_menu">
                        <ul>
                           <li><a></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="logo_section">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="logo"><a href="index.php"><img src="assets/images/bellamakes.png" style="width: 27%; height: auto;"></a></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="header_section">
            <div class="container">
               <div class="containt_main">
                  <div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <a href="index.php">Home</a>
                     <a href="clothes.php">Clothes</a>
                     <a href="makeups.php">Make ups</a>
                     <a href="accessories.php">Accessories</a>
                  </div>
                  <span class="toggle_icon" onclick="openNav()"><img src="assets/images/toggle-icon.png"></span>
                  <div class="dropdown">
                     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All categories 
                     </button>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Clothes</a>
                        <a class="dropdown-item" href="#">Make ups</a>
                        <a class="dropdown-item" href="#">Accessories</a>
                     </div>
                  </div>
                  <div class="main">
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                           <button class="btn btn-secondary" type="button" style="background-color: #874947; border-color: #874947 ">
                           <i class="fa fa-search"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                  <div class="header_box">
                     <div class="lang_box ">
                        <a href="#" title="Language" class="nav-link" data-toggle="dropdown" aria-expanded="true">
                        <img src="assets/images/flag-us.png" alt="flag" class="mr-2" title="United States" style="width: 20px; height: auto;"> English <i class="fa fa-angle-down ml-2" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu ">
                           <a href="index.php" class="dropdown-item">
                           <img src="assets/images/flag-br.png" class="mr-2" alt="flag" style="width: 20px; height: auto;">
                           Portuguese
                           </a>
                        </div>
                     </div>
                     <div class="login_menu">
                        <ul>
                           <li><a href="#">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_10">Cart</span></a>
                           </li>
                           <li><a href="login.php">
                              <i class="fa fa-user" aria-hidden="true"></i>
                              <span class="padding_10">User</span></a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="banner_section layout_padding">
            <div class="container">
               <div id="my_slider" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">Discover<br>Our Products</h1>
                              <div class="buynow_bt"><a href="#">Buy now</a></div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">Discover<br>Bella Makes</h1>
                              <div class="buynow_bt"><a href="#">Buy now</a></div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">Discover<br>Our Products</h1>
                              <div class="buynow_bt"><a href="#">Buy now</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <?php foreach ($categorias as $categoria) : ?>
         <div class="fashion_section">
               <div class="container">
                  <h1 class="fashion_taital"><?php echo $categoria; ?></h1>
                  <div class="fashion_section_2">
                     <div class="row">
                           <?php
                           $produtos = getProdutosByCategoria($conexao, $categoria);
                           if ($produtos->num_rows > 0) {
                              while ($row = $produtos->fetch_assoc()) {
                                 ?>
                                 <div class="col-lg-4 col-sm-4">
                                       <div class="box_main">
                                          <h4 class="shirt_text"><?php echo $row['nome']; ?></h4>
                                          <p class="price_text">Price <span style="color: #262626;"><?php echo 'R$' . $row['preco']; ?></span></p>
                                          <div class="product_image">
                                             <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>">
                                          </div>
                                          <div class="btn_main">
                                             <div class="buy_bt"><a href="#">Buy now</a></div>
                                             <div class="seemore_bt"><a href="#">See more</a></div>
                                          </div>
                                       </div>
                                 </div>
                              <?php } ?>
                           <?php } else { ?>
                              <p>No products found in this category.</p>
                           <?php } ?>
                     </div>
                  </div>
               </div>
         </div>
      <?php endforeach; ?>
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_logo"><a href="index.php"><img src="assets/images/bellamakes.png" style="width: 20%; height: auto;"></a></div>
            <div class="location_main">Number: <a href="#">+55 (48) 9 1234-5678</a></div>
         </div>
      </div>
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">© 2023 All rights reserved. Made by <a href="https://github.com/daiogojacare">Diogo Borges Corso</a></p>
         </div>
      </div>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="assets/js/jquery-3.0.0.min.js"></script>
      <script src="assets/js/plugin.js"></script>
      <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="assets/js/custom.js"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>
   </body>
</html>
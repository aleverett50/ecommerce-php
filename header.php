<!DOCTYPE HTML>
<head>
    <title><?= isset($meta_title) ? $meta_title : 'Hidden Wardrobe' . " | Women's Clothes | Shoes | Jewellery"?></title>
    <meta charset="UTF-8">
    <meta name="google-site-verification" content="1T1KQObgVHi8d7zLtjrxywXn_0-2AgWTGCNEjO8DuTU" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= DOMAIN ?>/css/bootstrap.min.css" />
    <link href="<?= DOMAIN ?>/css/bootstrap-touch-slider.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="<?= DOMAIN ?>/css/padding.css" />
    <link rel="stylesheet" type="text/css" href="<?= DOMAIN ?>/css/styles.css?v=2" />
    <link rel="stylesheet" type="text/css" href="<?= DOMAIN ?>/font-awesome/css/font-awesome.css" />
    <meta name="description" content="<?= isset($meta_description) ? $meta_description : 'Hidden Wardrobe - Premium Products ' ?>" />
    <meta name="keywords" content="<?= isset($meta_keywords) ? $meta_keywords : '' ?>" />
    <script src="<?= DOMAIN ?>/js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="<?= DOMAIN ?>/lightbox/dist/css/lightbox.css">
    <script src="<?= DOMAIN ?>/lightbox/dist/js/lightbox-plus-jquery.min.js"></script>
    <script src="<?= DOMAIN ?>/js/jquery.matchHeight-min.js"></script>
    <script src="<?= DOMAIN ?>/js/bootstrap.min.js"></script>

    <script>

        $(function(){

            $('.search-submit').click(function(){

                if( $('#q').val() == '' ){

                    alert('Please enter a search term');
                    $('#q').focus();
                    return false;
                }

                $('#search-form').submit();

            });

            $('#icon-search').click(function(){

                $('#mobile-search-form').submit();

            });



        });

    </script>
    <script>
        $(function() {
            $('.search-height').matchHeight({byRow : false});
        });
    </script>


</head>
<body>

<div class="bg-grey">

    <?php require __DIR__.'/includes/cookies.php'; ?>

    <div class="container-fluid hidden-xs pb-5 pt-10" style='background:#FFF;'>

        <div class="container">

            <div class="row">

                <div class="col-md-12 col-sm-12 mt-2" style="min-height: 115px;">


                    <a href="<?= DOMAIN ?>/">
                        <img alt="Logo" class="img-responsive logo-img" style="max-width: 250px !important;position: absolute;left:50%;transform: translate(-50%,0);" src="<?= DOMAIN ?>/images/logo.PNG">
                    </a>


                    <div style="float: right;position: absolute;right:10px;top:10px;">
                        <?php
                        if($user->auth()){

                            ?>

                                <a href="<?php echo DOMAIN ?>/login?log=out">
                                    <button style="float: right;background: #e1ceb0;color:#333;border:none;margin-left: 10px;">Logout</button>
                                </a>
                                <a href="<?php echo DOMAIN ?>/account">
                                    <button style="float: right;background: #e1ceb0;color:#333;border:none;margin-left: 10px;"><i class="fa fa-cog"></i></button>
                                </a>
  

                                 <a href="<?php echo DOMAIN ?>/basket">
                                    <button style="float: right;background: #e1ceb0;color:#333;border:none;margin-left: 10px;">
                                        <i class="fa fa-shopping-cart" style="color:#333;position: relative;left:-1px;top:1px;"> </i>
                                        <?= $count_cart_items ?>
                                       </button>
                                </a>
                            <?php

                        }

                        else{

                            ?>

                                <a href="<?php echo DOMAIN ?>/login">
                                    <button  style="float: right;background: #e1ceb0;color:#333;border:none;margin-left: 10px;">Sign in</button>
                                </a>

                            <a href="<?php echo DOMAIN ?>/basket">
                                <button style="float: right;background: #e1ceb0;color:#333;border:none;margin-left: 10px;">
                                    <i class="fa fa-shopping-cart" style="color:#333;position: relative;left:-1px;top:1px;"> </i>
                                    <?= $count_cart_items ?>
                                </button>
                            </a>                               

                            <?php

                        }
                            ?>


                    </div>


                </div>



            </div>
        </div>

    </div> <!-- logo+ line -->

</div>

<!-- container-fluid to make nav full width -->

<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top mt-0 mb-0 container-fluid no-padding">
    <div class="container no-padding pr-0 pl-0">

        <a class="visible-xs" href="<?= DOMAIN ?>">
            <img alt="logo"  class="img-responsive mobile-logo" src="<?= DOMAIN ?>/images/logo.PNG">
        </a>

        <div class="navbar-header">
            <button style="position: relative;top:25px;margin-right: 5px !important;" onclick="$('#navbar-mobile').slideToggle()" type="button" class="navbar-toggle " >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <button style="position: relative;top:25px;margin-right: 5px !important;" type="button" class="navbar-toggle collapsed pt-5 pb-5" data-toggle="collapse" data-target="#mySearch" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-search" style="color:#fff"></i>
            </button>

            <button style="position: relative;top:25px;margin-right: 5px !important;" type="button" class="navbar-toggle collapsed pt-5 pb-5 white">
                <span class="sr-only">Toggle navigation</span>
                <a class="white" href="<?= DOMAIN ?>/basket"> <i class="fa fa-shopping-cart white"> </i> <?= basename($_SERVER['SCRIPT_NAME']) == 'complete.php' ? 0 : $count_cart_items ?> </a>
            </button>


        </div>

        <script>

            $(function(){

                if(screen.width > 1024){

                    $('.link').hover(function(){

                        $(this).find('.dropdown-menu').toggle();

                    });

                }

                if(screen.width < 1025){

                    $('.link').click(function(){

                        $(this).find('.dropdown-menu').toggle();

                    });

                }


            });

        </script>

        <style>

            @media (max-width: 767px ) {

                .dropdown-menu{ position:relative }
                .dropdown-menu>li>a { font-size:18px }
                .link{ float:left }
                .dropdown-menu{ box-shadow: 0 0px 0px rgba(0,0,0,0); }
            }
            @media(min-width: 767px){
                #navbar-mobile{
                    display: none !important;
                }
            }
        </style>

        <div id="navbar" class="navbar-collapse collapse" style="border:0">
            <ul class="nav navbar-nav">
                <li class="link ">
                    <a href="<?php echo DOMAIN ?>">HOME</a>
                </li>

                <?php  $i = 1;   foreach( $categories as $category ){  ?>

                    <li class="link <?php if($i == count( $categories )){ print 'no-border'; } ?>">
                        <a <?php if($category->seo_url == "flash-sale"){print "style='color:#e62929'";} ?> class="visible-lg" href="<?= DOMAIN ?>/<?= $category->seo_url ?>"><?= strtoupper($category->title) ?></a>

                    </li>

                    <?php $i++; } ?>




            </ul>

            <script>
                function mouseover1(id){
                    $(".nav-class").hide();
                    $(".nav-class-" + id).show();
                }
                function mouseover2(id){
                    $(".nav-class-" + id).show();
                }
                function mouseleave1(id){
                    $(".nav-class-" + id).hide();
                }
            </script>
        </div><!--/.nav-collapse -->
    </div> <!-- mobile -->
</nav>
<style>
    .text-test{
        font-size: 17px;
    }
</style>
<script>
    $(function () {
        $('.same-height').matchHeight({byRow: false});
        $('.same-height3').matchHeight({byRow: false});
        $('.same-height2').matchHeight({byRow: false});
    });
</script>

<div class="" id="mySearchB">

    <div class="row mt-20 mb-20 ">

        <form action="<?= DOMAIN ?>/search" method="get">

            <div class="col-xs-8">

                <input required class="form-control" placeholder="Search products..." type="text" name="q" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">

            </div>

            <div class="col-xs-4">

                <button type="submit" class="btn btn-default more-info form-control">SEARCH</button>

            </div>

        </form>

    </div>

</div>
<script>
    let way = 0;
    $(".abc").click(function (){
        if(way == 0){
            way ++;
            $("#mySearchB").animate({
                height: "70px"
            })
        }
        else{
            way = 0;
            $("#mySearchB").animate({
                height: "0px"
            })
        }
    });
</script>
<div class="collapse navbar-collapse pl-20 pr-20" id="mySearch">

    <div class="row mt-20 mb-20 visible-xs">

        <form action="<?= DOMAIN ?>/search" method="get">

            <div class="col-xs-8">

                <input required class="form-control" placeholder="Search products..." type="text" name="q" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">

            </div>

            <div class="col-xs-4">

                <button type="submit" class="btn btn-default more-info form-control">SEARCH</button>

            </div>

        </form>

    </div>

</div>


  <div id="navbar-mobile" class=" " style="display: none;padding: 10px;position: absolute;top:100px;background: #e1ceb0;width: 100%;z-index: 1001;color:white;">




  </div>

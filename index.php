<?php include 'include/navbar.php' ?>
<!DOCTYPE html>
<html>
<head>
  <title>ePharma - Pharmacy at your home</title>
  <style type="text/css">
   /* Make the image fully responsive */
   .carousel-inner img {
     width: 1920px;
     height: 500px;
   }
   .card-img-top
   { height: 300px;
   }
 
</style>
</head>
<body>
<div class="content" style="height: 500PX;">
  <div id="landingslider" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
      <li data-target="#landingslider" data-slide-to="0" class="active"></li>
      <li data-target="#landingslider" data-slide-to="1"></li>
      <li data-target="#landingslider" data-slide-to="2"></li>
    </ul>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/carousel1.png" alt="slideImage"> 
      </div>
      <div class="carousel-item">
        <img src="images/carousel2.png" alt="slideImage">
      </div>
      <div class="carousel-item">
        <img src="images/carousel3.jpeg" alt="slideImage">
      </div>
    </div>
    <a class="carousel-control-prev" href="#landingslider" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#landingslider" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>
</div>

<br>
<div class="container jumbotron">
  <div class="d-flex justify-content-end">
    <a href="cart.php" class="btn btn-warning" >More Products . . .</a>
  </div>
  <h2 class="mt--1 mb-5 text-center"><span class="text-success font-weight-bold">Top</span> Selling <span class="text-info">Products</span></h2>
  <div class="row d-flex justify-content-center">
      <?php
    $sql = "SELECT *,P.name AS name,P.id AS pid FROM product P LEFT JOIN  category C ON P.category=C.name ORDER BY `stock` DESC";
    $result=mysqli_query($conn,$sql);
      for ($i=0; $i<3; $i++) 
      { $row = mysqli_fetch_assoc($result);
        ?>
        <div class="col-md-3">
              <a href="details.php?id=<?= $row['pid']; ?>" class="hovereffect d-flex flex-wrap align-content-center" style="height: 200px;">
                <img src="<?php echo $row["image"]; ?>" class="img-fluid mb-2">
                <h2 class="overlay d-flex flex-wrap align-content-center">
                  <?php  
                  echo $row["description"];
                  ?>
                </h2>
              </a>
            <p class="font-weight-bold"><?php echo $row["name"]; ?></p></tr>
            <p class="text-danger">Price : Rs <?php echo $row["price"]; ?></p></tr>
        </div>
  <?php
      }
    ?>
  </div>
</div>

<div style="width: 90%;margin-left: 5%;margin-bottom: 3%;">
  <h1 class="text-center text-bold">Stay Healthy Stay Fit</h1>
        <div class="row m-2 mt-5">
          <img src="images/health/diet.jpg" alt="diet.jpg" class="col-sm-5 img-thumbnail">
          <div class="col-sm-7 p-3 text-justify d-flex flex-wrap align-content-center">The major factor that determines health is the type of food intake a person takes. If a person has an unbalanced diet then it is much easier to guess that they are gonna have some kind of health issues in the future. On the other side, people who maintain a healthy diet are much less likely to numerous health issues.</div>
        </div>
        <div class="row m-2 mt-5">
          <div class="col-sm-7 p-3 text-justify d-flex flex-wrap align-content-center">Exercising is a crucial part of being healthy. Often associated after healthy diet, exercising regularly benefits the body in numerous ways. It maintains the body activities and ensures a more happening body system. Not to mention, exercising tones your body and gives it decent posture and shape.</div>
          <img src="images/health/exercise.jpg" alt="exercise.pg" class="col-sm-5 img-thumbnail">
        </div>
        <div class="row m-2 mt-5">
          <img src="images/health/meditation.jpg" alt="meditation.jpg" class="col-sm-5 img-thumbnail">
          <div class="col-sm-7 p-3 text-justify d-flex flex-wrap align-content-center">Meditation enhances ones mental health as well as some portion of physical health. Many researches conducted till today have proved the benefits of meditating in one's health. Meditaiton not only keeps your mind and body calm but it also helps to reduce stress, improve sleep, enhance conentration, decrease blodd pressure and can be done almost anywhere.</div>
        </div>
        <div class="row m-2 mt-5">
          <div class="col-sm-7 p-3 text-justify d-flex flex-wrap align-content-center">It is a fact that one can not be healthy with only physical health, a good mental health is necessary as well. Researchers are finding more and more evidence pointing to the many benefits of optimism and positive thinking on their mental health. Positive thinking helps to build a better, confident, stressfree and strong mental health.</div>
          <img src="images/health/positivity.jpg" alt="positivity.jpg" class="col-sm-5 img-thumbnail">
        </div>
</div>
  <?php include 'include/footer.php' ?>
</body>
</html>
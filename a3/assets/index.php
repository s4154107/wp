<?php
require_once 'includes/db_connect.inc';
$page_title = 'Home';
include 'includes/header.inc';

$carouselSql = "SELECT p.*, u.username FROM pets p JOIN users u ON p.user_id=u.user_id ORDER BY p.pet_id DESC LIMIT 4";
$carouselResult = mysqli_query($conn, $carouselSql);

$latestSql = "SELECT p.*, u.username FROM pets p JOIN users u ON p.user_id=u.user_id ORDER BY p.pet_id DESC LIMIT 4";
$latestResult = mysqli_query($conn, $latestSql);
?>

<section class="hero-section mb-5">
  <div id="petCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php $active=true; while($pet=mysqli_fetch_assoc($carouselResult)): ?>
        <div class="carousel-item <?= $active?'active':'' ?>">
          <img src="<?= pet_img($pet['image']) ?>" class="d-block w-100 carousel-image" alt="<?= h($pet['name']) ?>">
          <div class="carousel-caption">
            <h2><?= h($pet['name']) ?></h2>
            <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn">👁 View Details</a>
          </div>
        </div>
      <?php $active=false; endwhile; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>

<section>
  <h1 class="section-title">Recently Added Pets</h1>

  <div class="row g-4">
    <?php while($pet=mysqli_fetch_assoc($latestResult)): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card pet-card h-100">
          <img src="<?= pet_img($pet['image']) ?>" class="card-img-top pet-thumb" alt="<?= h($pet['name']) ?>">

          <div class="card-body">
            <h5><?= h($pet['name']) ?></h5>
            <p><?= h(substr($pet['description'],0,45)) ?>...</p>

            <div class="price">$<?= number_format((float)$pet['price'],2) ?></div>

            <a href="owner.php?id=<?= $pet['user_id'] ?>" class="owner-link">
              <?= h($pet['username']) ?>
            </a>

            <div class="mt-3">
              <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary">👁 View Details</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<?php include 'includes/footer.inc'; ?>
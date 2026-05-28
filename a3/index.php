<?php
require_once 'includes/db_connect.inc';

$page_title = 'Home';
include 'includes/header.inc';

$carouselSql = "SELECT * FROM pets ORDER BY pet_id DESC LIMIT 3";
$carouselResult = mysqli_query($conn, $carouselSql);

$latestSql = "SELECT * FROM pets ORDER BY pet_id DESC LIMIT 4";
$latestResult = mysqli_query($conn, $latestSql);
?>

<div class="container mt-4">

    <h1 class="text-white mb-4">Recently Added Pets</h1>

    <div class="row">

        <?php while($pet = mysqli_fetch_assoc($latestResult)): ?>

        <div class="col-md-3 mb-4">

            <div class="card bg-dark text-white">

                <img src="assets/images/pets/<?= $pet['image'] ?>" class="d-block w-100 carousel-image" alt="<?= h($pet['name']) ?>">

                <div class="card-body">

                    <h5><?= $pet['name'] ?></h5>

                    <p>$<?= $pet['price'] ?></p>

                    <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary">
                        View Details
                    </a>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include 'includes/footer.inc'; ?>
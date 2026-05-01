<?php
$title = "Home";
include "includes/db_connect.inc";
include "includes/header.inc";
include "includes/nav.inc";

$sql = "SELECT pet_id, name, species, breed, image_path, adoption_fee 
        FROM pets 
        ORDER BY pet_id ASC 
        LIMIT 8";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<main>

<section id="petCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/images/pets/5.jpg" class="d-block w-100 hero-img" alt="Charlie">
            <div class="carousel-caption custom-caption">
                <h5>Charlie</h5>
            </div>
        </div>

        <div class="carousel-item">
            <img src="assets/images/pets/1.jpg" class="d-block w-100 hero-img" alt="Buddy">
            <div class="carousel-caption custom-caption">
                <h5>Buddy</h5>
            </div>
        </div>

        <div class="carousel-item">
            <img src="assets/images/pets/2.jpg" class="d-block w-100 hero-img" alt="Whiskers">
            <div class="carousel-caption custom-caption">
                <h5>Whiskers</h5>
            </div>
        </div>

        <div class="carousel-item">
            <img src="assets/images/pets/3.jpg" class="d-block w-100 hero-img" alt="Max">
            <div class="carousel-caption custom-caption">
                <h5>Max</h5>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>

<section class="container py-5">
    <h1 class="section-title">
        <span class="material-icons">favorite</span>
        Recently Added Pets
    </h1>

    <div class="title-line"></div>

    <div class="row g-4 mt-2">
        <?php while ($pet = mysqli_fetch_assoc($result)) { ?>
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="pet-link">
                    <div class="card pet-card h-100">
                        <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>"
                             class="card-img-top pet-img"
                             alt="<?php echo htmlspecialchars($pet['name']); ?>">

                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($pet['name']); ?></h5>
                            <p class="pet-small">
                                <?php echo htmlspecialchars($pet['species']); ?> • 
                                <?php echo htmlspecialchars($pet['breed']); ?>
                            </p>
                            <p class="price">$<?php echo number_format($pet['adoption_fee'], 2); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</section>

</main>

<?php include "includes/footer.inc"; ?>
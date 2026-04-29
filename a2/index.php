<?php
$title = "Home";
include "includes/db_connect.inc";
include "includes/header.inc";
include "includes/nav.inc";

$sql = "SELECT pet_id, name, image_path, adoption_fee 
        FROM pets 
        ORDER BY created_at DESC 
        LIMIT 4";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<main class="container mt-4">

<h1 class="mb-4">Recently Added Pets</h1>

<div class="row g-4">
<?php while ($pet = mysqli_fetch_assoc($result)) { ?>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100">
            <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>" 
                 class="card-img-top pet-img" 
                 alt="<?php echo htmlspecialchars($pet['name']); ?>">

            <div class="card-body">
                <h5><?php echo htmlspecialchars($pet['name']); ?></h5>
                <p>$<?php echo number_format($pet['adoption_fee'], 2); ?></p>
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn btn-primary btn-sm">
                    View Details
                </a>
            </div>
        </div>
    </div>
<?php } ?>
</div>

</main>

<?php include "includes/footer.inc"; ?>
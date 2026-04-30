<?php
$title = "Pet Details";
include "includes/db_connect.inc";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM pets WHERE pet_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pet = mysqli_fetch_assoc($result);

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container mt-4">

<?php if ($pet) { ?>
    <div class="row">
        <div class="col-md-5">
            <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>" 
                 class="img-fluid rounded pet-detail-img" 
                 alt="<?php echo htmlspecialchars($pet['name']); ?>">
        </div>

        <div class="col-md-7">
            <h1><?php echo htmlspecialchars($pet['name']); ?></h1>

            <p>
                <span class="badge bg-primary"><?php echo htmlspecialchars($pet['species']); ?></span>
                <span class="badge bg-success"><?php echo htmlspecialchars($pet['status']); ?></span>
            </p>

            <table class="table table-bordered bg-white">
                <tr>
                    <th>Breed</th>
                    <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo $pet['age_years']; ?> years, <?php echo $pet['age_months']; ?> months</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><?php echo htmlspecialchars($pet['size']); ?></td>
                </tr>
                <tr>
                    <th>Adoption Fee</th>
                    <td>$<?php echo number_format($pet['adoption_fee'], 2); ?></td>
                </tr>
            </table>

            <h3>Description</h3>
            <p><?php echo htmlspecialchars($pet['description']); ?></p>

            <h3>Health Information</h3>
            <p><?php echo htmlspecialchars($pet['health_info']); ?></p>

            <a href="pets.php" class="btn btn-secondary">Back to Pets</a>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-danger">
        Pet not found.
    </div>
<?php } ?>

</main>

<?php include "includes/footer.inc"; ?>
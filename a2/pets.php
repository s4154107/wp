<?php
$title = "Browse Pets";
include "includes/db_connect.inc";
include "includes/header.inc";
include "includes/nav.inc";

$sql = "SELECT pet_id, name, species, breed, size, adoption_fee FROM pets ORDER BY name ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<main class="container mt-4">
    <h1 class="mb-4">All Available Pets</h1>

    <div class="row align-items-start">
        <div class="col-md-4 mb-4">
            <img src="assets/images/pets_banner.jpg" class="img-fluid rounded" alt="Pets banner">
        </div>

        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-striped table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Breed</th>
                            <th>Size</th>
                            <th>Fee ($)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($pet = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <a href="details.php?id=<?php echo $pet['pet_id']; ?>">
                                        <?php echo htmlspecialchars($pet['name']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($pet['species']); ?></td>
                                <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                                <td><?php echo htmlspecialchars($pet['size']); ?></td>
                                <td><?php echo number_format($pet['adoption_fee'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include "includes/footer.inc"; ?>
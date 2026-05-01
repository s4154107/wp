<?php
$title = "Pet Gallery";
include "includes/db_connect.inc";
include "includes/header.inc";
include "includes/nav.inc";

$sql = "SELECT pet_id, name, species, image_path, adoption_fee, status FROM pets ORDER BY pet_id DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<main class="container mt-4 gallery-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pet Gallery</h1>

        <select id="statusFilter" class="form-select w-auto">
            <option value="all">Show All</option>
            <option value="Available">Available</option>
            <option value="Pending">Pending</option>
            <option value="Adopted">Adopted</option>
        </select>
    </div>

    <div class="row g-4">
        <?php while ($pet = mysqli_fetch_assoc($result)) { ?>
            <?php
            $imageUrl = "assets/images/pets/" . $pet['image_path'];
            ?>

            <div class="col-12 col-sm-6 col-lg-3 pet-gallery-item" data-status="<?php echo htmlspecialchars($pet['status']); ?>">
                <div class="card pet-card h-100">
                    <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                         class="card-img-top pet-img gallery-img"
                         alt="<?php echo htmlspecialchars($pet['name']); ?>"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         data-img="<?php echo htmlspecialchars($imageUrl); ?>"
                         data-name="<?php echo htmlspecialchars($pet['name']); ?>">

                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($pet['name']); ?></h5>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($pet['species']); ?></span>
                        <span class="badge bg-success"><?php echo htmlspecialchars($pet['status']); ?></span>
                        <p class="mt-2">$<?php echo number_format($pet['adoption_fee'], 2); ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Pet Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Pet image">
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.inc"; ?>
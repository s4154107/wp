<?php
require_once 'includes/db_connect.inc';
$page_title = 'Gallery';
include 'includes/header.inc';

$sql = "SELECT * FROM pets ORDER BY pet_id ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-start mb-4">
  <h1 class="page-title">Pet Gallery</h1>

  <div>
    <label class="form-label">🔽 Filter by Status:</label>
    <select id="statusFilter" class="form-select">
      <option value="all">Show All</option>
      <option value="Available">Available</option>
      <option value="Pending">Pending</option>
      <option value="Adopted">Adopted</option>
    </select>
  </div>
</div>

<div class="row g-4">
  <?php while($pet=mysqli_fetch_assoc($result)): ?>
    <div class="col-md-6 col-lg-3 gallery-item" data-status="<?= h($pet['status']) ?>">
      <div class="card pet-card h-100">
        <img src="assets/images/pets/<?= htmlspecialchars($pet['image']) ?>" class="gallery-image" alt="<?= htmlspecialchars($pet['name']) ?>" data-bs-toggle="modal" data-bs-target="#imageModal" data-name="<?= htmlspecialchars($pet['name']) ?>" data-image="assets/images/pets/<?= htmlspecialchars($pet['image']) ?>">
          <h5><?= h($pet['name']) ?></h5>

          <span class="badge badge-purple"><?= h($pet['species']) ?></span>
          <span class="badge badge-pink"><?= h($pet['status']) ?></span>

          <p class="mt-2"><?= h($pet['breed']) ?></p>

          <div class="price">$<?= number_format((float)$pet['price'],2) ?></div>

          <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary mt-3">
            👁 View Details
          </a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<div class="modal fade" id="imageModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header gradient-nav text-white">
        <h5 id="modalTitle" class="modal-title"></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-3">
        <img src="" id="modalImage" class="img-fluid w-100 rounded" alt="">
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.inc'; ?>
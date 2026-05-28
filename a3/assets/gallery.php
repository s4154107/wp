<?php
require_once 'includes/db_connect.inc';
$page_title = 'Gallery';
include 'includes/header.inc';

$sql = "SELECT * FROM pets ORDER BY pet_id DESC";
$result = mysqli_query($conn, $sql);
?>

<h1 class="page-title">Pet Gallery</h1>

<div class="mb-4">
  <select id="categoryFilter" class="form-select w-auto">
    <option value="all">All Pets</option>
    <option value="Dog">Dogs</option>
    <option value="Cat">Cats</option>
    <option value="Bird">Birds</option>
    <option value="Rabbit">Rabbits</option>
  </select>
</div>

<div class="row g-4">
  <?php while($pet = mysqli_fetch_assoc($result)): ?>
    <div class="col-md-4 gallery-item" data-species="<?= h($pet['species']) ?>">
      <div class="card pet-card h-100">
        <img src="<?= pet_img($pet['image']) ?>"
             class="card-img-top gallery-image"
             alt="<?= h($pet['name']) ?>"
             data-bs-toggle="modal"
             data-bs-target="#imageModal"
             data-image="<?= pet_img($pet['image']) ?>">

        <div class="card-body">
          <h5><?= h($pet['name']) ?></h5>
          <p><?= h($pet['species']) ?> • <?= h($pet['breed']) ?></p>
          <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary">
            View Details
          </a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<div class="modal fade" id="imageModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid w-100" alt="Pet image">
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.inc'; ?>
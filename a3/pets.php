<?php
require_once 'includes/db_connect.inc';
$page_title = 'Browse Pets';
include 'includes/header.inc';

$sql = "SELECT p.*, u.username 
        FROM pets p
        JOIN users u ON p.user_id = u.user_id
        ORDER BY p.pet_id ASC";
$result = mysqli_query($conn, $sql);
?>

<h1 class="page-title">All Available Pets</h1>

<div class="row g-4">
  <div class="col-lg-4">
    <img src="assets/images/pets_banner.jpg" class="img-fluid rounded shadow" alt="Pets">
  </div>

  <div class="col-lg-8">
    <div class="table-responsive">
      <table class="table table-light align-middle">
        <thead>
          <tr>
            <th>Name</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Size</th>
            <th>Fee ($)</th>
            <th>Owner</th>
          </tr>
        </thead>

        <tbody>
          <?php while($pet=mysqli_fetch_assoc($result)): ?>
            <tr>
              <td>
                <a href="details.php?id=<?= $pet['pet_id'] ?>" class="fw-bold">
                  <?= h($pet['name']) ?>
                </a>
              </td>
              <td><?= h($pet['species']) ?></td>
              <td><?= h($pet['breed']) ?></td>
              <td><?= h($pet['size']) ?></td>
              <td><?= number_format((float)$pet['price'],2) ?></td>
              <td>
                <a href="owner.php?id=<?= $pet['user_id'] ?>">
                  👤 <?= h($pet['username']) ?>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/footer.inc'; ?>
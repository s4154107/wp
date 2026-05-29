<?php
require_once 'includes/db_connect.inc';
$page_title = 'Pet Details';
include 'includes/header.inc';

$id = (int)($_GET['id'] ?? 0);
$pet = get_pet($conn, $id);

if (!$pet) {
  echo "<p>Pet not found.</p>";
  include 'includes/footer.inc';
  exit;
}

if (isset($_POST['delete']) && logged_in() && $_SESSION['user_id'] == $pet['user_id']) {
  $stmt = mysqli_prepare($conn, "DELETE FROM pets WHERE pet_id=? AND user_id=?");
  mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['user_id']);
  mysqli_stmt_execute($stmt);

  header('Location: pets.php');
  exit;
}
?>

<div class="row g-4 align-items-start">
  <div class="col-md-5">
    <img src="/~s4154107/wp/a3/assets/images/pets/<?= h($pet['image_path']) ?>" alt="<?= h($pet['name']) ?>" class="img-fluid rounded">
  </div>

  <div class="col-md-7">
    <h1 class="page-title mb-2"><?= h($pet['name']) ?></h1>

    <span class="badge badge-purple"><?= h($pet['species']) ?></span>
    <span class="badge badge-pink"><?= h($pet['status']) ?></span>

    <table class="info-table mt-3">
      <tr><td>Breed:</td><td><?= h($pet['breed']) ?></td></tr>
      <tr><td>Age:</td><td><?= h($pet['age_years']) ?> years, <?= h($pet['age_months']) ?> months</td></tr>
      <tr><td>Gender:</td><td><?= h($pet['gender']) ?></td></tr>
      <tr><td>Size:</td><td><?= h($pet['size']) ?></td></tr>
      <tr><td>Adoption Fee:</td><td><strong>$<?= number_format((float)$pet['price'],2) ?></strong></td></tr>
    </table>

    <h4 class="mt-4">📋 Description</h4>
    <p><?= h($pet['description']) ?></p>

    <h4 class="mt-4">💚 Health Information</h4>
    <p><?= h($pet['health']) ?></p>

    <hr>

    <h4>Contact Owner</h4>
    <p>👤 <strong>Name:</strong> <a href="owner.php?id=<?= $pet['user_id'] ?>"><?= h($pet['username']) ?></a></p>
    <p>✉️ <strong>Email:</strong> <a href="mailto:<?= h($pet['email']) ?>"><?= h($pet['email']) ?></a></p>
    <p>📞 <strong>Phone:</strong> <?= h($pet['phone']) ?></p>
    <p>📍 <strong>Location:</strong> <?= h($pet['location']) ?></p>

    <?php if (logged_in() && $_SESSION['user_id'] == $pet['user_id']): ?>
      <hr>
      <a href="edit.php?id=<?= $pet['pet_id'] ?>" class="btn btn-orange">✏️ Edit</a>

      <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#deleteModal">
        🗑 Delete
      </button>
    <?php endif; ?>
  </div>
</div>

<div class="modal fade" id="deleteModal">
  <div class="modal-dialog modal-dialog-centered">
    <form method="post" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">⚠ Confirm Deletion</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-dark">
        <p>Are you sure you want to delete <?= h($pet['name']) ?>?</p>
        <p>This action cannot be undone.</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
        <button name="delete" class="btn btn-pink">Yes, Delete</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/footer.inc'; ?>
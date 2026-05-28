<?php
require_once 'includes/db_connect.inc';
require_login();

$id = (int)($_GET['id'] ?? 0);
$pet = get_pet($conn, $id);

if (!$pet || $_SESSION['user_id'] != $pet['user_id']) {
  flash('danger', 'You are not allowed to edit this pet.');
  header('Location: pets.php');
  exit;
}

$page_title = 'Edit Pet';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $name = trim($_POST['name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $age_years = (int)$_POST['age_years'];
    $age_months = (int)$_POST['age_months'];
    $gender = trim($_POST['gender']);
    $size = trim($_POST['size']);
    $price = (float)$_POST['price'];
    $description = trim($_POST['description']);
    $health = trim($_POST['health']);
    $status = trim($_POST['status']);
    $image = upload_pet_image('image', $pet['image']);

    $sql = "UPDATE pets
            SET name=?, species=?, breed=?, age_years=?, age_months=?, gender=?, size=?, price=?, description=?, health=?, status=?, image=?
            WHERE pet_id=? AND user_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
      $stmt,
      'sssiissdssssii',
      $name,
      $species,
      $breed,
      $age_years,
      $age_months,
      $gender,
      $size,
      $price,
      $description,
      $health,
      $status,
      $image,
      $id,
      $_SESSION['user_id']
    );

    mysqli_stmt_execute($stmt);

    flash('success', 'Pet updated successfully.');
    header('Location: details.php?id=' . $id);
    exit;
  } catch (Exception $e) {
    flash('danger', $e->getMessage());
  }
}

include 'includes/header.inc';
?>

<h1 class="page-title">Edit Pet: <?= h($pet['name']) ?></h1>

<form method="post" enctype="multipart/form-data">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Pet Name *</label>
      <input class="form-control" name="name" value="<?= h($pet['name']) ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Species *</label>
      <select class="form-select" name="species" required>
        <?php foreach(['Dog','Cat','Bird','Rabbit'] as $option): ?>
          <option <?= $pet['species']===$option?'selected':'' ?>><?= $option ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Breed</label>
      <input class="form-control" name="breed" value="<?= h($pet['breed']) ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Age Years</label>
      <input class="form-control" type="number" name="age_years" value="<?= h($pet['age_years']) ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Age Months</label>
      <input class="form-control" type="number" name="age_months" value="<?= h($pet['age_months']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Gender *</label>
      <select class="form-select" name="gender" required>
        <?php foreach(['Male','Female'] as $option): ?>
          <option <?= $pet['gender']===$option?'selected':'' ?>><?= $option ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Size *</label>
      <select class="form-select" name="size" required>
        <?php foreach(['Small','Medium','Large'] as $option): ?>
          <option <?= $pet['size']===$option?'selected':'' ?>><?= $option ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Adoption Fee ($) *</label>
      <input class="form-control" type="number" step="0.01" name="price" value="<?= h($pet['price']) ?>">
    </div>

    <div class="col-12">
      <label class="form-label">Description *</label>
      <textarea class="form-control" name="description" rows="5"><?= h($pet['description']) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Health Information</label>
      <textarea class="form-control" name="health" rows="4"><?= h($pet['health']) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Status *</label>
      <select class="form-select" name="status">
        <?php foreach(['Available','Pending','Adopted'] as $option): ?>
          <option <?= $pet['status']===$option?'selected':'' ?>><?= $option ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Current Photo</label><br>
      <img src="<?= pet_img($pet['image']) ?>" class="rounded mb-3" style="max-width:150px;">
      <input class="form-control" type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif,.webp">
      <img id="imagePreview" class="mt-3 rounded d-none" style="max-width:180px;">
    </div>
  </div>

  <div class="mt-4">
    <button class="btn btn-primary">Update Pet</button>
    <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-pink">Cancel</a>
  </div>
</form>

<?php include 'includes/footer.inc'; ?>
<?php
require_once 'includes/db_connect.inc';
require_login();

$page_title = 'Add Pet';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

  $image = '';

  if (!empty($_FILES['image']['name'])) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
      $error = "Only jpg, jpeg, png, gif and webp files are allowed.";
    } else {
      $image = uniqid('pet_', true) . '.' . $ext;
      move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/pets/' . $image);
    }
  }

  if (!isset($error)) {
    $sql = "INSERT INTO pets
            (name, species, breed, age_years, age_months, gender, size, price, description, health, status, image, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
      $stmt,
      'sssiissdssssi',
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
      $_SESSION['user_id']
    );

    mysqli_stmt_execute($stmt);

    header('Location: index.php');
    exit;
  }
}

include 'includes/header.inc';
?>

<h1 class="page-title">⊕ Add a New Pet for Adoption</h1>

<?php if(isset($error)): ?>
  <div class="alert alert-danger"><?= h($error) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Pet Name *</label>
      <input class="form-control" name="name" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Species *</label>
      <select class="form-select" name="species" required>
        <option value="">Select species</option>
        <option>Dog</option>
        <option>Cat</option>
        <option>Bird</option>
        <option>Rabbit</option>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Breed</label>
      <input class="form-control" name="breed">
    </div>

    <div class="col-md-3">
      <label class="form-label">Age Years</label>
      <input class="form-control" type="number" name="age_years" min="0" value="0">
    </div>

    <div class="col-md-3">
      <label class="form-label">Age Months</label>
      <input class="form-control" type="number" name="age_months" min="0" max="11" value="0">
    </div>

    <div class="col-md-4">
      <label class="form-label">Gender *</label>
      <select class="form-select" name="gender" required>
        <option value="">Select gender</option>
        <option>Male</option>
        <option>Female</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Size *</label>
      <select class="form-select" name="size" required>
        <option value="">Select size</option>
        <option>Small</option>
        <option>Medium</option>
        <option>Large</option>
        <option>Extra Large</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Adoption Fee ($) *</label>
      <input class="form-control" type="number" step="0.01" name="price" required>
    </div>

    <div class="col-12">
      <label class="form-label">Description *</label>
      <textarea class="form-control" name="description" rows="5" required></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Health Information</label>
      <textarea class="form-control" name="health" rows="4"></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Status *</label>
      <select class="form-select" name="status" required>
        <option value="">Select status</option>
        <option>Available</option>
        <option>Pending</option>
        <option>Adopted</option>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Pet Photo</label>
      <input class="form-control" type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif,.webp" required>
      <img id="imagePreview" class="mt-3 rounded d-none" style="max-width:180px;">
    </div>
  </div>

  <div class="mt-4">
    <button class="btn btn-primary">💾 Add Pet</button>
    <a href="index.php" class="btn btn-pink">Cancel</a>
  </div>
</form>

<?php include 'includes/footer.inc'; ?>
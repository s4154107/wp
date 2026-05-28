<?php
require_once 'includes/db_connect.inc';
$page_title='Owner Pets';
include 'includes/header.inc';

$id=(int)($_GET['id']??0);

$stmt=mysqli_prepare($conn,"SELECT p.*, u.username, u.location FROM pets p JOIN users u ON p.user_id=u.user_id WHERE u.user_id=? ORDER BY p.pet_id DESC");
mysqli_stmt_bind_param($stmt,'i',$id);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$first=mysqli_fetch_assoc($result);

if(!$first){
  echo '<p>No pets found.</p>';
  include 'includes/footer.inc';
  exit;
}

mysqli_data_seek($result,0);
?>

<h1 class="page-title">Pets by <?= h($first['username']) ?></h1>
<p>📍 <strong>Location:</strong> <?= h($first['location']) ?></p>
<hr>

<div class="row g-4">
  <?php while($pet=mysqli_fetch_assoc($result)): ?>
    <div class="col-md-4">
      <div class="card pet-card h-100">
        <img src="<?= pet_img($pet['image']) ?>" class="card-img-top pet-thumb">

        <div class="card-body">
          <h5><?= h($pet['name']) ?></h5>
          <span class="badge badge-purple"><?= h($pet['species']) ?></span>
          <span class="badge badge-pink"><?= h($pet['status']) ?></span>
          <p class="mt-2"><?= h($pet['breed']) ?></p>
          <div class="price">$<?= number_format((float)$pet['price'],2) ?></div>
          <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary mt-3">View Details</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php include 'includes/footer.inc'; ?>
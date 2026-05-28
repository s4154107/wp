<?php
require_once 'includes/db_connect.inc';
$page_title='Search Pets';
include 'includes/header.inc';

$q=trim($_GET['q']??'');
$result=null;

if($q!==''){
  $term="%$q%";
  $stmt=mysqli_prepare($conn,"SELECT * FROM pets WHERE name LIKE ? OR species LIKE ? OR breed LIKE ? OR description LIKE ? ORDER BY pet_id DESC");
  mysqli_stmt_bind_param($stmt,'ssss',$term,$term,$term,$term);
  mysqli_stmt_execute($stmt);
  $result=mysqli_stmt_get_result($stmt);
}
?>

<h1 class="page-title">Search Pets</h1>

<form method="get" class="d-flex mb-4">
  <input class="form-control" name="q" value="<?= h($q) ?>">
  <button class="btn btn-primary ms-2">Search</button>
</form>

<?php if($q!==''): ?>
  <h3>Search Results for "<?= h($q) ?>"</h3>

  <div class="row g-4 mt-2">
    <?php while($pet=mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4">
        <div class="card pet-card h-100">
          <img src="<?= pet_img($pet['image']) ?>" class="card-img-top pet-thumb">
          <div class="card-body">
            <h5><?= h($pet['name']) ?></h5>
            <p><?= h($pet['species']) ?> • <?= h($pet['breed']) ?></p>
            <div class="price">$<?= number_format((float)$pet['price'],2) ?></div>
            <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary mt-3">View Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>

<?php include 'includes/footer.inc'; ?>
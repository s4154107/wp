<?php
require_once __DIR__ . '/functions.inc';
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark gradient-nav">
    <div class="container-fluid px-3">
      <a class="navbar-brand" href="index.php">🐾 PetConnect</a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">⌂ Home</a></li>
          <li class="nav-item"><a class="nav-link" href="pets.php">☰ Browse Pets</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">▣ Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="search.php">⌕ Search</a></li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <?php if (logged_in()): ?>
            <li class="nav-item"><a class="nav-link" href="add.php">⊕ Add Pet</a></li>
            <li class="nav-item"><span class="nav-link">☻ <?= h($_SESSION['username']) ?></span></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">↪ Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">↪ Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">♚ Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
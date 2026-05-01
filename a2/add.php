<?php
$title = "Add Pet";
include "includes/db_connect.inc";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $species = trim($_POST["species"]);
    $breed = trim($_POST["breed"]);
    $age_years = intval($_POST["age_years"]);
    $age_months = intval($_POST["age_months"]);
    $gender = trim($_POST["gender"]);
    $size = trim($_POST["size"]);
    $description = trim($_POST["description"]);
    $health_info = trim($_POST["health_info"]);
    $adoption_fee = floatval($_POST["adoption_fee"]);
    $status = trim($_POST["status"]);

    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!empty($_FILES["image"]["name"])) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $image_name = uniqid("pet_", true) . "." . $ext;
            move_uploaded_file($_FILES["image"]["tmp_name"], "assets/images/pets/" . $image_name);

            $sql = "INSERT INTO pets 
            (name, species, breed, age_years, age_months, gender, size, description, health_info, image_path, adoption_fee, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssiisssssds",
                $name,
                $species,
                $breed,
                $age_years,
                $age_months,
                $gender,
                $size,
                $description,
                $health_info,
                $image_name,
                $adoption_fee,
                $status
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = "Pet added successfully.";
            } else {
                $message = "Database error.";
            }
        } else {
            $message = "Invalid image type.";
        }
    } else {
        $message = "Please upload an image.";
    }
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container mt-4">
    <h1 class="mb-4">
        <span class="material-icons">add_circle</span>
        Add a New Pet for Adoption
    </h1>

    <?php if ($message !== "") { ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="post" enctype="multipart/form-data" id="addPetForm">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Pet Name *</label>
                <input type="text" name="name" class="form-control" placeholder="Enter pet name" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Species *</label>
                <select name="species" class="form-select" required>
                    <option value="">Select species</option>
                    <option>Dog</option>
                    <option>Cat</option>
                    <option>Bird</option>
                    <option>Rabbit</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Breed</label>
                <input type="text" name="breed" class="form-control" placeholder="Enter breed" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Age (Years)</label>
                <input type="number" name="age_years" class="form-control" placeholder="Years" min="0" value="0">
            </div>

            <div class="col-md-3 mb-3">
                <label>Age (Months)</label>
                <input type="number" name="age_months" class="form-control" placeholder="Months" min="0" max="11" value="0">
            </div>

            <div class="col-md-4 mb-3">
                <label>Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Size *</label>
                <select name="size" class="form-select" required>
                    <option value="">Select size</option>
                    <option>Small</option>
                    <option>Medium</option>
                    <option>Large</option>
                    <option>Extra Large</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Adoption Fee ($) *</label>
                <input type="number" name="adoption_fee" class="form-control" placeholder="Enter fee" step="0.01" required>
            </div>

            <div class="col-12 mb-3">
                <label>Description *</label>
                <textarea name="description" class="form-control" placeholder="Describe the pet's personality and characteristics" required></textarea>
            </div>

            <div class="col-12 mb-3">
                <label>Health Information</label>
                <textarea name="health_info" class="form-control" placeholder="Enter health and vaccination information" required></textarea>
            </div>

            <div class="col-12 mb-3">
                <label>Status *</label>
                <select name="status" class="form-select" required>
                    <option value="">Select status</option>
                    <option>Available</option>
                    <option>Pending</option>
                    <option>Adopted</option>
                </select>
            </div>

            <div class="col-12 mb-3">
                <label>Pet Photo</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                <div id="imageError" class="text-danger mt-2"></div>
                <img id="imagePreview" class="mt-3 rounded d-none" width="150" alt="Image preview">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <span class="material-icons small-icon">save</span>
            Add Pet
        </button>

        <a href="index.php" class="btn btn-danger">
            <span class="material-icons small-icon">cancel</span>
            Cancel
        </a>
    </form>
</main>

<?php include "includes/footer.inc"; ?>
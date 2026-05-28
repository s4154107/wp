document.addEventListener("DOMContentLoaded", function () {
  const statusFilter = document.getElementById("statusFilter");

  if (statusFilter) {
    statusFilter.addEventListener("change", function () {
      const selected = this.value;

      document.querySelectorAll(".gallery-item").forEach(function (item) {
        if (selected === "all" || item.dataset.status === selected) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });
  }

  const imageModal = document.getElementById("imageModal");

  if (imageModal) {
    imageModal.addEventListener("show.bs.modal", function (event) {
      const img = event.relatedTarget;
      document.getElementById("modalImage").src = img.dataset.image;
      document.getElementById("modalTitle").textContent = img.dataset.name;
    });
  }

  const fileInput = document.querySelector('input[type="file"][name="image"]');
  const preview = document.getElementById("imagePreview");

  if (fileInput) {
    fileInput.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;

      const allowed = ["jpg", "jpeg", "png", "gif", "webp"];
      const ext = file.name.split(".").pop().toLowerCase();

      if (!allowed.includes(ext)) {
        alert("Only jpg, jpeg, png, gif and webp files are allowed.");
        this.value = "";
        return;
      }

      if (preview) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove("d-none");
      }
    });
  }
});
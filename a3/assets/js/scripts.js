document.addEventListener("DOMContentLoaded", function () {
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
        if (preview) preview.classList.add("d-none");
        return;
      }

      if (preview) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove("d-none");
      }
    });
  }

  const filter = document.getElementById("categoryFilter");

  if (filter) {
    filter.addEventListener("change", function () {
      const selected = this.value;
      document.querySelectorAll(".gallery-item").forEach(function (item) {
        if (selected === "all" || item.dataset.species === selected) {
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
      const src = img.getAttribute("data-image");
      document.getElementById("modalImage").src = src;
    });
  }
});
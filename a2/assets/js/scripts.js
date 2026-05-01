document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("imageInput");
    const imagePreview = document.getElementById("imagePreview");
    const imageError = document.getElementById("imageError");

    if (imageInput) {
        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            const allowed = ["jpg", "jpeg", "png", "gif", "webp"];

            if (file) {
                const ext = file.name.split(".").pop().toLowerCase();

                if (!allowed.includes(ext)) {
                    imageError.textContent = "Only jpg, jpeg, png, gif and webp files are allowed.";
                    imageInput.value = "";
                    imagePreview.classList.add("d-none");
                    return;
                }

                imageError.textContent = "";
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove("d-none");
            }
        });
    }

    const galleryImages = document.querySelectorAll(".gallery-img");
    const modalImage = document.getElementById("modalImage");
    const modalTitle = document.getElementById("modalTitle");

    galleryImages.forEach(function (img) {
        img.addEventListener("click", function () {
            modalImage.src = this.dataset.img;
            modalTitle.textContent = this.dataset.name;
        });
    });

    const statusFilter = document.getElementById("statusFilter");
    const galleryItems = document.querySelectorAll(".pet-gallery-item");

    if (statusFilter) {
        statusFilter.addEventListener("change", function () {
            const selected = this.value;

            galleryItems.forEach(function (item) {
                if (selected === "all" || item.dataset.status === selected) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }
});
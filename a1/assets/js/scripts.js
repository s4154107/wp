document.addEventListener('DOMContentLoaded', function () {
  setupGalleryFilter();
  setupGalleryModal();
  setupImageValidationAndPreview();
  setupFormReset();
});

function setupGalleryFilter() {
  const filter = document.getElementById('statusFilter');
  const items = document.querySelectorAll('.gallery-item');

  if (!filter || !items.length) return;

  filter.addEventListener('change', function () {
    const selected = this.value;

    items.forEach(function (item) {
      const status = item.dataset.status;

      if (selected === 'all' || status === selected) {
        item.classList.remove('d-none');
      } else {
        item.classList.add('d-none');
      }
    });
  });
}

function setupGalleryModal() {
  const modal = document.getElementById('petModal');
  if (!modal) return;

  const modalTitle = document.getElementById('petModalLabel');
  const modalImage = document.getElementById('modalPetImage');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const title = button.getAttribute('data-title');
    const image = button.getAttribute('data-image');

    modalTitle.textContent = title;
    modalImage.src = image;
    modalImage.alt = title;
  });
}

function setupImageValidationAndPreview() {
  const imageInput = document.getElementById('image');
  const feedback = document.getElementById('imageFeedback');
  const previewWrapper = document.getElementById('imagePreviewWrapper');
  const previewImage = document.getElementById('imagePreview');

  if (!imageInput || !feedback || !previewWrapper || !previewImage) return;

  const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  imageInput.addEventListener('change', function () {
    feedback.textContent = '';
    feedback.className = 'image-feedback';
    previewWrapper.classList.add('d-none');
    previewImage.src = '';

    const file = this.files[0];
    if (!file) return;

    const fileName = file.name.toLowerCase();
    const extension = fileName.split('.').pop();

    if (!allowedExtensions.includes(extension)) {
      feedback.textContent = 'Invalid file type. Please select jpg, jpeg, png, gif, or webp.';
      feedback.classList.add('error');
      this.value = '';
      return;
    }

    feedback.textContent = 'Valid image selected. Preview shown below.';
    feedback.classList.add('success');

    const reader = new FileReader();
    reader.onload = function (event) {
      previewImage.src = event.target.result;
      previewWrapper.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
  });
}

function setupFormReset() {
  const form = document.getElementById('petForm');
  const feedback = document.getElementById('imageFeedback');
  const previewWrapper = document.getElementById('imagePreviewWrapper');
  const previewImage = document.getElementById('imagePreview');

  if (!form) return;

  form.addEventListener('reset', function () {
    setTimeout(function () {
      if (feedback) {
        feedback.textContent = '';
        feedback.className = 'image-feedback';
      }

      if (previewWrapper) {
        previewWrapper.classList.add('d-none');
      }

      if (previewImage) {
        previewImage.src = '';
      }
    }, 0);
  });
}
/*
 *  Document   : media_selection.js
 *  Author     : saico
 *  Description: Selects medias and takes their values.
 */

// handel data pages
class mediaSelection {
  /*
   * Init Data
   *
   */
  static initData() {
    $(document).ready(function () {
      let selectedImages = [];
      let currentInput = null;
      let selectionType = "single"; // Default selection type
      let fileType = "image"; // Default file type
      const url = $("#model-media-container").data("url");
      const asset = $("#model-media-container").data("asset");

      // Open offcanvas and fetch images
      function openModal(button) {
        currentInput = $(button).data("input-set-value"); // Get target input field ID
        selectionType = $(button).data("selection-type"); // Get selection type
        fileType = $(button).data("file-type"); // Get file type
        $("#model-media-container").empty(); // Clear previous images

        // Get existing values in the current input
        const existingValues = $(currentInput).val()
          ? $(currentInput).val().split(",")
          : [];

        // Fetch images from the backend
        $.get(`${url}?type=${fileType}`, function (data) {
          data.uploads.forEach((image) => {
            // Check if the image ID is already in the existing values
            const isChecked = existingValues.includes(image.id.toString())
              ? "checked"
              : "";
            if (fileType == "image") {
              $("#model-media-container").append(`
    <div class="col-12 col-sm-6">
        <div class="form-check form-block image-item" data-id="${image.id}">
            <input type="checkbox" class="form-check-input image-select" id="image-${
              image.id
            }" value="${image.id}" ${isChecked}>
            <label class="form-check-label bg-body-light" for="image-${
              image.id
            }">
                <span class="d-block p-1 mb-2 ratio ratio-21x9">
                    <img class="img-fluid options-item lazyload" 
                         data-src="${asset + image.path}" 
                         alt="${image.title}">
                </span>
                <span class="text-sm text-muted text-center" style="display: block;font-size: 12px; text-overflow: ellipsis; overflow: hidden; width: 100%; white-space: nowrap;">
                    ${image.title}
                </span>
            </label>
        </div>
    </div>
`);
            } else {
              $("#model-media-container").append(`
    <div class="col-12 col-sm-6">
        <div class="form-check form-block image-item" data-id="${image.id}" title="${image.title}">
            <input type="checkbox" class="form-check-input image-select" id="image-${image.id}" value="${image.id}" ${isChecked}>
            <label class="form-check-label bg-body-light" for="image-${image.id}">
                <span class="d-block p-1 ratio ratio-21x9">
                  <i class="fa fa-file text-secondary text-center h1"></i>
                </span>
                <span class="text-sm text-center text-muted" style="display: block;font-size: 12px; text-overflow: ellipsis; overflow: hidden; width: 100%; white-space: nowrap;">
                    ${image.title}
                </span>
            </label>
        </div>
    </div>
`);
            }
          });

          // Initialize lazy loading for images
          initLazyLoad();

          // Adjust checkboxes for single selection
          if (selectionType === "single") {
            $(".image-select").on("change", function () {
              $(".image-select").not(this).prop("checked", false); // Uncheck other checkboxes
            });
          }
        });
      }

      // Lazy load initialization function
      function initLazyLoad() {
        const lazyImages = document.querySelectorAll(".lazyload");

        if ("IntersectionObserver" in window) {
          const imageObserver = new IntersectionObserver(
            (entries, observer) => {
              entries.forEach((entry) => {
                if (entry.isIntersecting) {
                  const img = entry.target;
                  img.src = img.dataset.src; // Replace data-src with src
                  img.classList.remove("lazyload");
                  imageObserver.unobserve(img);
                }
              });
            }
          );

          lazyImages.forEach((image) => {
            imageObserver.observe(image);
          });
        } else {
          // Fallback for browsers without IntersectionObserver
          lazyImages.forEach((img) => {
            img.src = img.dataset.src;
            img.classList.remove("lazyload");
          });
        }
      }

      // Handle button clicks to open offcanvas
      $(document).on("click", ".btn-select-upload-file", function () {
        openModal(this);
      });

      // Save selected images
      $("#save-selection").click(function () {
        selectedImages = [];
        $("#model-media-container .image-item").each(function () {
          if ($(this).find(".image-select").is(":checked")) {
            selectedImages.push($(this).data("id"));
          }
        });

        // Assign selected image(s) to the input
        if (selectionType === "single") {
          if (selectedImages.length > 1) {
            alert("You can only select one main image!");
            return;
          }
          $(currentInput).val(selectedImages[0]); // Save single ID
        } else if (selectionType === "multiple") {
          $(currentInput).val(selectedImages.join(",")); // Save comma-separated IDs
        }

        // Close the offcanvas
        const offcanvas = bootstrap.Offcanvas.getInstance(
          "#offcanvasScrollingBackdrop"
        );
        offcanvas.hide();
      });

      $(".btn-unselect-input").on("click", function () {
        // Get the selector from the `data-input-unselect` attribute
        var inputSelector = $(this).data("input-unselect");
        // Unselect the value of the input field
        $(inputSelector).val("");
        // Remove the button
        $(this).remove();
      });
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initData();
  }
}

// Initialize when page loads
One.onLoad(() => mediaSelection.init());

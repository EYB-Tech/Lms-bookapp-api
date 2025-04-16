/*
 *  Document   : admin/languages/index.balde.php & admin/languages/show.balde.php
 *  Author     : saico
 *  Description: Custom JS code used in Languages Page
 */

// handel data pages
class pageLanguages {
  /*
   * Init Data
   *
   */
  static initData() {
    $(document).ready(function () {
      /**
       * admin/languages/index.balde.php
       */
      if ($('select[name="language_select"]').length > 0) {
        $(document).on("change", 'select[name="language_select"]', function () {
          let el = $(this);
          let name = el
            .parent()
            .find(
              'select[name="language_select"] option[value="' + el.val() + '"]'
            )
            .text();
          el.parent().find('input[name="name"]').val(name);
          el.parent()
            .parent()
            .parent()
            .find('input[name="slug"]')
            .val(el.val());
        });
      }
      if ($(".table .modal-edit").length > 0) {
        $(".table .modal-edit").on("click", function () {
          var data = $(this).data("language");
          var url = $("#edit-modal form").attr("action");
          $("#edit-modal form").attr("action", url.replace(":id", data.id));
          $("#edit-modal input[name='name']").val(data.name);
          $("#edit-modal select[name='direction']").val(data.direction);
          $("#edit-modal select[name='status']").val(data.status);
          $("#edit-modal select[name='language_select']").val(data.slug);
          $("#edit-modal input[name='slug']").val(data.slug);
        });
      }

      /**
       * admin/languages/show.balde.php
       */
      if (
        $(".card-item").length > 0 &&
        $(".save-words").length > 0 &&
        $("#show-more").length > 0 &&
        $("#search").length > 0 &&
        $("#all-words").length > 0
      ) {
        // Initially show only 52 cards
        var cardLimit = 52;
        var totalCards = $(".card-item").length;

        // Show the initial set of cards with a smooth animation
        $(".card-item")
          .slice(0, cardLimit)
          .each(function (index) {
            let that = this;
            setTimeout(function () {
              $(that).addClass("show");
            }, index * 100); // Slight delay for each card for staggered effect
          });

        // Show more cards when "Show More" is clicked
        $(document).on("click", "#show-more", function () {
          showMore();
        });

        // Show next 52 hidden cards with smooth animation
        function showMore() {
          let nextLimit = cardLimit + 52;
          $(".card-item")
            .slice(cardLimit, nextLimit)
            .each(function (index) {
              let that = this;
              setTimeout(function () {
                $(that).addClass("show");
              }, index * 100); // Delay for staggered effect
            });

          cardLimit = nextLimit;
          toggleShowMoreButton();
        }

        // Toggle "Show More" button visibility based on remaining hidden cards
        function toggleShowMoreButton() {
          if (cardLimit >= totalCards) {
            $("#show-more").hide();
          } else {
            $("#show-more").show();
          }
        }

        // Debounced search event
        $("#search").on(
          "keyup",
          debounce(function () {
            let searchQuery = $(this).val();
            let url = $(this).data("url");
            if (searchQuery.length >= 2) {
              $.ajax({
                url: url,
                type: "GET",
                data: {
                  search: searchQuery,
                },
                success: function (response) {
                  $("#all-words").html(response);
                  cardLimit = 52;
                  totalCards = $(".card-item").length;
                  $(".card-item")
                    .slice(0, cardLimit)
                    .each(function (index) {
                      let that = this;
                      setTimeout(function () {
                        $(that).addClass("show");
                      }, index * 100);
                    });
                  toggleShowMoreButton();
                },
                error: function (xhr, status, error) {
                  console.error(error);
                },
              });
            }
          }, 1000)
        ); // 1000ms delay for debouncing search

        // AJAX form submission
        $(document).on("click", ".save-words", function (e) {
          // e.preventDefault();

          var form = $(this).closest("form");
          var url = form.attr("action");
          var formData = form.serialize();
          var successMessage = $("#all-words").data("success-message");
          var errorMessage = $("#all-words").data("error-message");
          $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
              One.helpers("jq-notify", {
                type: "success",
                icon: "fa fa-check me-1",
                message: successMessage,
              });
            },
            error: function (xhr, status, error) {
              console.error(error);
              One.helpers("jq-notify", {
                type: "danger",
                icon: "fa fa-times me-1",
                message: errorMessage,
              });
            },
          });
        });

        // Debounce function to limit the rate of search input
        function debounce(func, wait) {
          let timeout;
          return function () {
            let context = this,
              args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
              func.apply(context, args);
            }, wait);
          };
        }
      }
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
One.onLoad(() => pageLanguages.init());

<template>
      <!-- Poll Post trigger modal -->
      <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#pollpostModal">
        <i class="bi bi-bar-chart-line-fill me-2"></i>
        <span>Poll</span>
      </button>
      <!-- Poll Post Modal -->
      <div class="modal fade" id="pollpostModal" tabindex="-1" aria-labelledby="pollpostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="pollpostModal">Create a poll</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" id="myForm">

                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Your question</label>
                  <textarea class="form-control border border-dark" id="exampleFormControlTextarea1" rows="3"
                    placeholder="E.g., How do you commute to work?"></textarea>
                </div>

                <div class="options-container">
                  <div class="mb-3 option-group">
                    <label class="form-label">Option 1</label>
                    <input type="text" class="form-control border border-dark" placeholder="E.g., Public transportation">
                  </div>
                  <div class="mb-3 option-group">
                    <label class="form-label">Option 2</label>
                    <input type="text" class="form-control border border-dark" placeholder="E.g., Drive myself">
                  </div>
                </div>
                <div class="mb-3">
                  <button type="button" id="addOptionBtn" class="btn btn-primary">Add Option</button>
                </div>
                <div class="mb-3">
                  <select class="form-select border border-dark" aria-label="Default select example">
                    <option value="1" selected>1 day</option>
                    <option value="3">3 day</option>
                    <option value="7">1 week</option>
                    <option value="14">2 week</option>
                  </select>
                </div>
              </form>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="button" class="btn btn-primary">Done</button>
            </div>
          </div>
        </div>
      </div>
</template>

<script>
$(document).ready(function () {
  // Add Option
  $("#addOptionBtn").on("click", function () {
    var optionGroup = $(".option-group:first").clone();
    optionGroup.find("input").val(""); // Clear the input value
    optionGroup.append('<button type="button" class="deleteOptionBtn btn text-danger">Delete</button>');
    $(".options-container").append(optionGroup);
  });

  // Delete Option
  $(document).on("click", ".deleteOptionBtn", function () {
    if ($(this).closest(".option-group").index() > 1) {
      $(this).closest(".option-group").remove();
    }
  });
});
</script>
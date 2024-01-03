<template>
  <!-- Media Post trigger modal -->
  <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#mediapostModal">
    <i class="bi bi-image me-2 media-icon"></i>
    <span>Media</span>
  </button>
  <!-- Media Post Modal -->
  <div class="modal fade" id="mediapostModal" tabindex="-1" aria-labelledby="mediapostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="mediapostModalLabel">Editor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center h-100">
            <div class="text-center align-self-center">
              <img src="	https://www.fzcoltd.com/wp-content/uploads/2022/11/company-registration-1024x827.jpg" alt=""
                class="mb-3" width="200">
              <h2>Select files to begin</h2>
              <p>Share images or a single video in your post.</p>
              <form action="">
                <label class="btn btn-primary">
                  <input type="file" />
                  Upload from computer
                </label>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</template>
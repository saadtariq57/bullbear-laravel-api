<template>
      <!-- Document Post trigger modal -->
      <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#decumentpostModal">
        <i class="bi bi-file-earmark-text me-2"></i>
        <span>Document</span>
      </button>

      <!-- Media Post Modal -->
      <div class="modal fade" id="decumentpostModal" tabindex="-1" aria-labelledby="decumentpostModallLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="decumentpostModallLabel">Share a document</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="">
                <label class="btn btn-primary w-100">
                  <input type="file" />
                  Choose file
                </label>
              </form>
              <div class="d-flex gap-2 mt-3">
                <i class="bi bi-info-square-fill fs-5"></i>
                <p>For accessibility purposes, Rich Tv members who can view your post will be able to download your
                  document as a PDF</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="button" class="btn btn-primary">Done</button>
            </div>
          </div>
        </div>
        </div>
</template>
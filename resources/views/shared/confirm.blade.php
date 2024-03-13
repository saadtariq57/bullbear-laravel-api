<div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $modalId }}Label">{{ $title }}</h1>
                <button class="btn-close" type="button" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"></button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary border-btn" data-bs-dismiss="modal">DON’T DELETE</button>
                <form id="{{ $formId }}" action="{{ $formAction }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">DELETE</button>
                </form>
            </div>
        </div>
    </div>
</div>

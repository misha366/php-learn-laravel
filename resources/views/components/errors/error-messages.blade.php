@props(['errTitle' => '', 'errSubtitle' => ''])

@if($errors->any())
    <div class="toast-container position-fixed bottom-0 end-0 p-3 user-select-none">
        @foreach($errors->all() as $error)
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img
                        class="validation__toast-image"
                        src="https://cdn-icons-png.flaticon.com/512/12434/12434856.png" alt="Alert">
                    <strong class="me-auto">{{ $errTitle }}</strong>
                    <small>{{ $errSubtitle }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ $error }}
                </div>
            </div>
        @endforeach
    </div>
@endif

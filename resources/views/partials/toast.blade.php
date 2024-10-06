@vite(['resources/js/app.js', 'resources/js/toasts.js'])
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery -->


<div aria-live="polite" aria-atomic="true">
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        @if(session('success'))
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="display: block;">
                <div class="toast-body bg-success text-white">
                    {{ session('success') }}
                </div>
            </div>
        @endif
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- JavaScript de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>



<style>
    /* styles.css */
.loading-page {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    z-index: 9999;
}

.loading-spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s infinite linear;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }

}


</style>

<div class="loading-page" id="loadingPage">
    <div class="loading-spinner"></div>
</div>

@include('layouts.header')
@include('layouts.navbar')
@include('layouts.sidebar')
@include('layouts.content')
@include('layouts.footer')

<!-- Preloader -->
{{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ Asset('/img/logo/logo.png') }}" alt="AdminLTELogo" height="60" width="60" style="border-radius: 50%;">
</div> --}}



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

$(window).on('load', function () {
    setTimeout(function() {
        hideLoadingPage(); // Sembunyikan elemen loading page setelah selesai loading
    }, 1200)
});

function hideLoadingPage() {
    $('#loadingPage').fadeOut();
}
</script>

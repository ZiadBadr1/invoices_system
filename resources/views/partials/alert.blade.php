@if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show text-right" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session('success') }}</strong>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show text-right" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session('info') }}</strong>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show text-right" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session('error') }}</strong>
        </div>
    </div>
@endif

<style>
    .alert strong {
        display: block;
        margin-right: 1.5rem; /* Adjust this value if needed */
    }

    .close {
        position: absolute;
        top: 0;
        right: 0;
        padding: 0.75rem 1.25rem;
        color: inherit;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all alerts
        var alerts = document.querySelectorAll('.alert');

        // Iterate over each alert and set a timeout to hide it
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.classList.remove('show');
                }, 500); // Bootstrap fade transition duration
            }, 3000); // 3 seconds before hiding
        });
    });
</script>

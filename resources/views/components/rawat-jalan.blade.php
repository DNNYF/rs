<script>
    document.addEventListener('DOMContentLoaded', function () {
    const nextSteps = document.querySelectorAll('.next-step');
    const prevSteps = document.querySelectorAll('.prev-step');
    const form = document.getElementById('multiStepForm');

    nextSteps.forEach(button => {
        button.addEventListener('click', () => {
            // Temukan tab aktif saat ini
            let active = document.querySelector('.tab-pane.active');
            let formElements = active.querySelectorAll('input, select, textarea');

            // Validasi semua input di tab aktif
            let valid = true;
            formElements.forEach(element => {
                if (!element.checkValidity()) {
                    valid = false;
                    element.classList.add('is-invalid');  // Tambahkan kelas bootstrap untuk memperlihatkan error
                } else {
                    element.classList.remove('is-invalid'); // Hapus error jika input valid
                }
            });

            // Jika valid, pindah ke step berikutnya
            if (valid) {
                let next = active.nextElementSibling;
                if (next) {
                    let activeNav = document.querySelector('.nav-pills .active');
                    activeNav.classList.remove('active');
                    activeNav.nextElementSibling.classList.add('active');

                    active.classList.remove('show', 'active');
                    next.classList.add('show', 'active');
                }
            } else {
                alert('Tolong lengkapi semua field di step ini sebelum melanjutkan.');
            }
        });
    });

    prevSteps.forEach(button => {
        button.addEventListener('click', () => {
            let active = document.querySelector('.tab-pane.active');
            let prev = active.previousElementSibling;

            if (prev) {
                let activeNav = document.querySelector('.nav-pills .active');
                activeNav.classList.remove('active');
                activeNav.previousElementSibling.classList.add('active');

                active.classList.remove('show', 'active');
                prev.classList.add('show', 'active');
            }
        });
    });
});

</script>


document.addEventListener('DOMContentLoaded', function() {
    const specializationSelect = document.getElementById('spesialis');
    const specializationForm = document.getElementById('spesialis-form');
    const namaSpesialisInput = document.getElementById('nama_spesialis');

    specializationSelect.addEventListener('change', function() {
        if (this.value === 'Spesialis') {
            if (specializationForm.style.display === 'none') {
                specializationForm.style.display = 'block';
            }
            namaSpesialisInput.setAttribute('required', true);
        } else if (this.value === 'Umum') {
            if (specializationForm.style.display === 'block') {
                specializationForm.style.display = 'none';
            }
            namaSpesialisInput.removeAttribute('required');

            if (document.contains(specializationForm)) {
                specializationForm.remove();
            }
        }
    });
});

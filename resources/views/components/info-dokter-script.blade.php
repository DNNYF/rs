<script>
    document.addEventListener('DOMContentLoaded', function() {
        const spesialisSelect = document.getElementById('spesialis');
        const namaSpesialisContainer = document.getElementById('nama-spesialis-container');
        const namaSpesialisInput = document.getElementById('nama_spesialis');
    
        function toggleNamaSpesialis() {
            if (spesialisSelect.value === 'Spesialis') {
                namaSpesialisContainer.style.display = 'block';
                namaSpesialisInput.required = true;
            } else {
                namaSpesialisContainer.style.display = 'none';
                namaSpesialisInput.required = false;
                namaSpesialisInput.value = '';
            }
        }
    
        spesialisSelect.addEventListener('change', toggleNamaSpesialis);
        
        toggleNamaSpesialis();
    });
    </script>

@extends('layouts.user_type.auth')

@section('content')
<form id="multiStepForm" method="POST" action="{{ route('submitStep1') }}">
    @csrf
    <div id="step1">
        <label for="pasien_id">ID Pasien:</label>
        <input type="text" name="pasien_id" id="pasien_id" required>
        
        <label for="dokter_id">ID Dokter:</label>
        <input type="text" name="dokter_id" id="dokter_id" required>

        <button type="button" onclick="submitStep1()">Next</button>
    </div>

    <div id="step2" style="display: none;">
        <label for="obat_list">Daftar Obat:</label>
        <input type="text" name="obat_list" id="obat_list">
        
        <button type="button" onclick="previousStep(1)">Previous</button>
        <button type="button" onclick="submitStep2()">Next</button>
    </div>

    <div id="step3" style="display: none;">
        <label for="total_biaya">Total Biaya:</label>
        <input type="number" name="total_biaya" id="total_biaya" step="0.01" required>

        <button type="button" onclick="previousStep(2)">Previous</button>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
<script>
    function submitStep1() {
        let pasien_id = document.getElementById('pasien_id').value;
        let dokter_id = document.getElementById('dokter_id').value;
        let _token = document.querySelector('input[name="_token"]').value;

        ffetch('{{ route("submitStep1") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': _token
    },
    body: JSON.stringify({ pasien_id: pasien_id, dokter_id: dokter_id })
})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('rawat_jalan_id', data.rawat_jalan_id);
                nextStep(2);
            } else {
                alert('Error: ' + data.message);
            }
        });
    }

    function submitStep2() {
        let obat_list = document.getElementById('obat_list').value;
        let rawat_jalan_id = sessionStorage.getItem('rawat_jalan_id');
        let _token = document.querySelector('input[name="_token"]').value;

        fetch('{{ route("submitStep2") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _token
            },
            body: JSON.stringify({ id: rawat_jalan_id, obat_list: obat_list })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                nextStep(3);
            } else {
                alert('Error: ' + data.message);
            }
        });
    }

    function submitStep3() {
        let total_biaya = document.getElementById('total_biaya').value;
        let rawat_jalan_id = sessionStorage.getItem('rawat_jalan_id');
        let _token = document.querySelector('input[name="_token"]').value;

        fetch('{{ route("submitStep3") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _token
            },
            body: JSON.stringify({ id: rawat_jalan_id, total_biaya: total_biaya })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data berhasil disimpan!');
                window.location.href = '{{ route("successPage") }}';
            } else {
                alert('Error: ' + data.message);
            }
        });
    }

    function nextStep(step) {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';
        document.getElementById('step3').style.display = step === 3 ? 'block' : 'none';
    }

    function previousStep(step) {
        document.getElementById('step1').style.display = step === 1 ? 'block' : 'none';
        document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';
        document.getElementById('step3').style.display = step === 3 ? 'block' : 'none';
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Auto Story Viewer</title>
    <style>
        #loading-spinner {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Auto Story Viewer</h1>

    <div id="cookie-info">
        <!-- Informasi akun client -->
        <h2>Informasi akun client</h2>
        <p>Username : {{ $username_akun_client }}</p>
        <!-- ... (sisa informasi) ... -->
    </div>

    <div id="cookie-info-dump">
        <!-- Informasi akun dump -->
        <h2>Informasi akun dump</h2>
        <p>Username : {{ $username_akun_dump }}</p>
        <!-- ... (sisa informasi) ... -->
    </div>

    <div id="input-container">
        <h2>Input Target</h2>
        <form id="target-form">
            <!-- Input target -->
            <label for="targets">Masukkan Target:</label>
            <input type="text" id="targets" name="targets" placeholder="Masukkan target..." value="{{ $target_data ?? '' }}">
            <input type="text" id="target2" name="target2" placeholder="Masukkan target kedua..." value="{{ $target2_data ?? '' }}">
            <input type="text" id="target3" name="target3" placeholder="Masukkan target ketiga..." value="{{ $target3_data ?? '' }}">
            
            <!-- Tombol Submit -->
            <button type="button" onclick="submitTargets()">Submit</button>
            <!-- Pesan Submit -->
            <p id="submit-message"></p>
        </form>
    </div>

    <!-- Tombol Mulai dan Berhenti -->
    <button onclick="startAutoStory()">Mulai</button>
    <button onclick="stopAutoStory()">Berhenti</button>
    
    <!-- Indikator Loading Spinner -->
    <div id="loading-spinner">Loading...</div>

    <script>
        function submitTargets() {
            var targetsInput = document.getElementById('targets').value;
            var targetsInput2 = document.getElementById('target2').value;
            var targetsInput3 = document.getElementById('target3').value;
            
            // Kirim permintaan POST ke server untuk menyimpan target
            showLoadingSpinner(); // Tampilkan loading spinner
            fetch('/process-targets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ targets: targetsInput, targets2: targetsInput2, targets3: targetsInput3 })
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingSpinner(); // Sembunyikan loading spinner
                document.getElementById('submit-message').innerHTML = data.message;

                if (data.status === 'success') {
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
        }

        function startAutoStory() {
            showLoadingSpinner();
            fetch('/auto-story-viewer-start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingSpinner();
                document.getElementById('submit-message').innerHTML = data.message;
            });
        }

        function stopAutoStory() {
            showLoadingSpinner();
            fetch('/auto-story-viewer-stop', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingSpinner();
                document.getElementById('submit-message').innerHTML = data.message;
            });
        }

        function autoStoryViewer() {
            fetch('/auto-story-viewer')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('output-container').innerHTML = JSON.stringify(data);
                });
        }

        function showLoadingSpinner() {
            document.getElementById('loading-spinner').style.display = 'block';
        }

        function hideLoadingSpinner() {
            document.getElementById('loading-spinner').style.display = 'none';
        }

        window.onload = autoStoryViewer;
    </script>
</body>
</html>

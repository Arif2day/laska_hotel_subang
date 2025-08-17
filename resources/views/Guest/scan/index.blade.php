@extends('Guest.main')
@section('content')
<main class="l-main">
    <div class="container" style="margin-top: 100px!important">
        <h4 class="text-center mb-4">📷 Scan QR-Code Meja</h4>
    
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center">
                        <div id="reader" style="width:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="scan-result" class="text-center mt-3"></div>
    </div>    
</main>
@endsection
@section('script')
<!-- Library untuk scan QR -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // tampilkan hasil QR
        document.getElementById("scan-result").innerHTML = `
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                QR-Code terbaca: ${decodedText}
            </div>
        `;

        // redirect otomatis jika QR adalah URL
        if(decodedText.startsWith("http")){
            window.location.href = decodedText;
        }
    }

    function onScanFailure(error) {
        // error scanning (bisa diabaikan)
        console.warn(`Scan error: ${error}`);
    }

    // aktifkan scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { fps: 10, qrbox: 250 },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection
<!-- Cards with few info -->
<div>
  <div class="row g-6">
    <div class="col-lg-4 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-1 me-2" wire:poll.keep-alive>{{ $this->Count_Attendance ?? '0'  }}</h5>
            <p class="mb-0">{{ __('Attendance Count') }}</p>
          </div>
          <div class="card-icon">
                        <span class="badge bg-label-success rounded p-2">
                          <i class="ti ti-checks ti-26px"></i>
                        </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-1 me-2" wire:poll.keep-alive>{{ $this->Count_Subject  ?? '0'  }}</h5>
            <p class="mb-0">{{ __('Subject Count') }}</p>
          </div>
          <div class="card-icon">
                        <span class="badge bg-label-primary rounded p-2">
                          <i class="ti ti-books ti-26px"></i>
                        </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-1 me-2" wire:poll.keep-alive>{{ $this->Count_Lecture  ?? '0'  }}</h5>
            <p class="mb-0">{{ __('Total Lectures') }}</p>
          </div>
          <div class="card-icon">
                        <span class="badge bg-label-secondary rounded p-2">
                          <i class="ti ti-library ti-26px"></i>
                        </span>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="d-flex flex-column align-items-center justify-content-center mt-5">

    <h1 class="mb-4 text-center fw-bold">
      {{ __('Scan QR to Attend') }}
    </h1>
    <div id="qr-reader" class="shadow rounded" style="width: 500px;" wire:ignore></div>
    <div id="qr-reader-results" class="mt-3 text-center"  wire:ignore></div>
  </div>
</div>


@section('page-script')
  <script src="{{ asset('html5-qrcode.min.js') }}"></script>
  <script>
    function docReady(fn) {
      if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(fn, 1);
      } else {
        document.addEventListener('DOMContentLoaded', fn);
      }
    }

    docReady(function() {
      var resultContainer = document.getElementById('qr-reader-results');
      var lastResult, countResults = 0;

      function onScanSuccess(decodedText, decodedResult) {
        if (decodedText !== lastResult) {
          ++countResults;
          lastResult = decodedText;

          // Mostrar el resultado escaneado
          resultContainer.classList.remove('d-none');
          resultContainer.textContent = 'QR Code Scanned: ' + decodedText;

          // Enviar el código QR escaneado al servidor
          Livewire.dispatch('qrCodeScanned', { data: decodedText });
        }
      }

      var html5QrcodeConfig = {
        fps: 10,
        qrbox: { width: 100, height: 100 },
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
        rememberLastUsedCamera: true,
        experimentalFeatures: {
          useBarCodeDetectorIfSupported: true
        },
        defaultCameraConfig: {
          facingMode: 'environment' // Prioriza la cámara trasera
        }
      };

      const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        Livewire.dispatch('qrCodeScanned', { data: decodedText });
      };

      var html5QrcodeScanner = new Html5QrcodeScanner('qr-reader', html5QrcodeConfig, /* verbose= */ false);
      html5QrcodeScanner.render(onScanSuccess);
      html5QrcodeScanner.start({ facingMode: 'user' }, html5QrcodeConfig, qrCodeSuccessCallback);
    });
  </script>
@endsection

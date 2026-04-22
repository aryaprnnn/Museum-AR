<x-layout title="{{ $currentItem->name }}" :mainClass="'hide-navbar hide-footer'">

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/information.css') }}">
    <link rel="stylesheet" href="{{ asset('css/overlay.css') }}">
    @endpush

<div class="info-page-wrapper">
    <!-- Start Experience Overlay -->
    <div id="fs-overlay">
        <div class="fs-content">
            <h2>Welcome to Virtual Museum</h2>
            <p>To get the full experience, please enable fullscreen mode!</p>
            <button id="btn-start-fs" class="btn-start-fs">Enable Fullscreen</button>
            <br>
            <button id="btn-skip-fs" class="btn-skip-fs">Continue Normal View</button>
        </div>
    </div>
    <main class="info-page-main">
        <!-- Mobile Info Toggle Button -->
        <button id="mobile-info-btn" class="mobile-info-btn" title="View Information">
            <i class="fas fa-info-circle"></i> Info
        </button>

        <div class="info-wrapper">
            <!-- TEXT SECTION -->
            <div class="info-text" id="infoTextSection">
                <span id="close-info-btn" class="close-info-btn"><i class="fas fa-times"></i></span>
                <h1>{{ $currentItem->name }}</h1>
                <div class="info-description">
                    <p>{{ $currentItem->description }}</p>
                    @if($currentItem->origin || $currentItem->era)
                        <p class="meta-chip"><strong>Asal:</strong> {{ $currentItem->origin ?? '-' }} | <strong>Era:</strong> {{ $currentItem->era ?? '-' }}</p>
                    @endif
                </div>
            </div>

            <!-- 3D MODEL SECTION -->
            <div class="info-model">
                <div class="model-viewer-container" id="modelContainer">
                    @php
                        $modelUrl = $currentItem->model_3d
                            ? (\Illuminate\Support\Str::startsWith($currentItem->model_3d, ['http://', 'https://'])
                                ? $currentItem->model_3d
                                : request()->getSchemeAndHttpHost() . '/storage/models/' . basename($currentItem->model_3d))
                            : 'https://modelviewer.dev/shared-assets/models/Astronaut.glb';
                    @endphp
                    <model-viewer 
                        id="modelViewer"
                        src="{{ $modelUrl }}"
                        alt="{{ $currentItem->name }}"
                        auto-rotate
                        camera-controls
                        shadow-intensity="1"
                        ar
                        ar-modes="webxr scene-viewer quick-look"
                        style="width: 100%; height: 100%; background: transparent; border-radius: 15px;"
                    >
                        <div class="progress-bar" slot="progress-bar">
                            <div class="update-bar"></div>
                        </div>
                    </model-viewer>
                    <button id="arButton" class="ar-button" onclick="viewARMode()" title="{{ __('content.collections_page.view_in_ar') }}">
                        <i class="fas fa-cube"></i> {{ __('content.collections_page.view_in_ar') }}
                    </button>
                </div>
            </div>
        </div>
        <!-- Back button moved outside main to avoid transform traps -->
    </main>
</div>

<div class="back-button-container" style="position: fixed !important; top: 15px !important; left: 20px !important; z-index: 9999 !important; margin: 0 !important; padding: 0 !important;">
    <a href="{{ route('search') }}" class="btnkembali">
        <i class="fas fa-arrow-left"></i>
        <span class="back-btn-text">{{ __('content.collections_page.back_to_collections') }}</span>
    </a>
</div>

{{-- External Stylesheet --}}
<!-- Styles moved to head via stack -->

<!-- Model Viewer Script -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>

{{-- External JavaScript --}}
<script src="{{ asset('js/model-viewer.js') }}"></script>
<script>
    // Initialize model viewer with data from PHP
    // const modelUrl = "{{ $modelUrl }}";
    // const modelName = "{{ $currentItem->name }}";
    // initModelViewer(modelUrl, modelName);

    document.addEventListener('DOMContentLoaded', () => {
        const elem = document.documentElement;
        
        // Function to enter fullscreen
        function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message} (${err.name})`);
                });
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }

        // Function to exit fullscreen
        function closeFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        }

        // Start Button Handler
        const startBtn = document.getElementById('btn-start-fs');
        const skipBtn = document.getElementById('btn-skip-fs'); // New Skip Button
        const overlay = document.getElementById('fs-overlay');

        if(startBtn){
            startBtn.addEventListener('click', () => {
                openFullscreen();
                if(overlay) {
                    overlay.classList.add('hidden');
                }
            });
        }

        // Skip Button Handler
        if(skipBtn){
            skipBtn.addEventListener('click', () => {
                if(overlay) {
                    overlay.classList.add('hidden');
                }
            });
        }

        // Handle Back Button
        const backBtn = document.querySelector('.btnkembali');
        if(backBtn){
            backBtn.addEventListener('click', (e) => {
                // We let the link navigate, but try to close FS first
                closeFullscreen();
            });
        }
        // Mobile Info Button Toggle
        const mobileInfoBtn = document.getElementById('mobile-info-btn');
        const closeInfoBtn = document.getElementById('close-info-btn');
        const infoTextSection = document.getElementById('infoTextSection');

        if(mobileInfoBtn && infoTextSection) {
            mobileInfoBtn.addEventListener('click', () => {
                infoTextSection.classList.add('show-info');
                mobileInfoBtn.style.display = 'none';
            });
        }

        if(closeInfoBtn && infoTextSection) {
            closeInfoBtn.addEventListener('click', () => {
                infoTextSection.classList.remove('show-info');
                mobileInfoBtn.style.display = 'flex';
            });
        }
    });
</script>

</x-layout>

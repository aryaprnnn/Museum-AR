<x-layout title="{{ $currentItem['nama'] }}">

<div class="info-page-wrapper">
    <main class="info-page-main">
        <div class="info-wrapper">
            <!-- TEXT SECTION -->
            <div class="info-text">
                <h1>{{ $currentItem['nama'] }}</h1>
                <div class="info-description">
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
                    <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                </div>
            </div>

            <!-- 3D MODEL SECTION -->
            <div class="info-model">
                <div class="model-viewer-container" id="modelContainer">
                    <model-viewer 
                        id="modelViewer"
                        alt="{{ $currentItem['nama'] }}"
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
                    <button id="arButton" class="ar-button" onclick="viewARMode()" title="Lihat dengan AR">
                        <i class="fas fa-cube"></i> Lihat dengan AR
                    </button>
                </div>
            </div>
        </div>

        <div class="back-button-container">
            <a href="{{ route('search') }}" class="btnkembali">← Kembali ke Koleksi</a>
        </div>
    </main>
</div>

<!-- Model Viewer Script -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>

<script>
    // Data model dari PHP
    const modelUrl = "{{ $currentItem['model'] }}";
    const modelName = "{{ $currentItem['nama'] }}";
    
    console.log('Model URL:', modelUrl);
    console.log('Model Name:', modelName);

    // Setup model viewer setelah DOM ready
    function setupModelViewer() {
        const modelViewer = document.getElementById('modelViewer');
        const arButton = document.getElementById('arButton');
        
        if (!modelViewer) {
            console.error('Model viewer element not found');
            return;
        }

        // Set source
        modelViewer.src = modelUrl;
        console.log('Model src set to:', modelViewer.src);

        // Listen untuk events
        modelViewer.addEventListener('load', function() {
            console.log('✓ Model loaded successfully');
        });

        modelViewer.addEventListener('error', function(e) {
            console.error('✗ Model loading error:', e);
        });

        modelViewer.addEventListener('model-visibility', function(e) {
            console.log('Model visibility changed:', e.detail.visible);
        });

        // AR support check
        if (navigator.xr) {
            navigator.xr.isSessionSupported('immersive-ar').then(supported => {
                if (supported) {
                    console.log('✓ AR is supported');
                    arButton.style.opacity = '1';
                    arButton.style.cursor = 'pointer';
                } else {
                    console.log('✗ AR not supported');
                    arButton.style.opacity = '0.5';
                    arButton.style.cursor = 'not-allowed';
                    arButton.title = 'AR tidak tersedia di perangkat ini';
                }
            }).catch(err => {
                console.log('AR check error:', err);
            });
        } else {
            console.log('WebXR not available');
        }
    }

    function viewARMode() {
        const modelViewer = document.getElementById('modelViewer');
        if (modelViewer && modelViewer.src) {
            console.log('Triggering AR mode...');
            modelViewer.activateAR();
        }
    }

    // Setup when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupModelViewer);
    } else {
        setupModelViewer();
    }

    // Also setup on window load to be sure
    window.addEventListener('load', function() {
        console.log('Window loaded');
        setTimeout(setupModelViewer, 100);
    });
</script>

<style>
    .info-page-wrapper {
        padding-top: 80px;
        min-height: 100vh;
        background-color: #FFF0DC;
    }

    .info-page-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .info-wrapper {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        margin-bottom: 40px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    .info-text {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .info-text h1 {
        color: #543A14;
        font-size: 2.5rem;
        margin-bottom: 25px;
    }

    .info-description p {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
        text-align: justify;
    }

    .info-model {
        min-height: 550px;
        background: transparent;
        border-radius: 15px;
        overflow: visible;
        box-shadow: none;
        position: relative;
    }

    .model-viewer-container {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 550px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
    }

    model-viewer {
        width: 100% !important;
        height: 100% !important;
        min-height: 550px !important;
        display: block !important;
    }

    .ar-button {
        position: absolute;
        bottom: -60px;
        right: 0;
        padding: 12px 24px;
        background-color: #543A14;
        color: #FFF0DC;
        border: none;
        border-radius: 25px;
        font-weight: bold;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(84, 58, 20, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 10;
    }

    .ar-button:hover {
        background-color: #8B6F47;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(84, 58, 20, 0.4);
    }

    .ar-button:active {
        transform: translateY(-1px);
    }

    .ar-button i {
        font-size: 1.1rem;
    }

    .back-button-container {
        text-align: center;
        padding: 20px 0;
    }

    .btnkembali {
        display: inline-block;
        padding: 12px 30px;
        background-color: #543A14;
        color: #FFF0DC;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btnkembali:hover {
        background-color: #3d2a0f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Progress bar for model loading */
    .progress-bar {
        display: block;
        width: 33%;
        height: 10%;
        max-height: 2%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate3d(-50%, -50%, 0);
        border-radius: 25px;
        box-shadow: 0px 3px 10px 3px rgba(0, 0, 0, 0.5), 0px 0px 5px 1px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.9);
        background-color: rgba(0, 0, 0, 0.5);
    }

    .progress-bar.hide {
        visibility: hidden;
        transition: visibility 0.3s;
    }

    .update-bar {
        background-color: rgba(255, 255, 255, 0.9);
        width: 0%;
        height: 100%;
        border-radius: 25px;
        float: left;
        transition: width 0.3s;
    }

    /* Desktop Layout */
    @media (min-width: 851px) {
        .info-wrapper {
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: stretch;
            max-width: 1000px;
        }

        .info-text h1 {
            font-size: 3rem;
        }

        .info-model {
            min-height: 550px;
        }

        .model-viewer-container {
            min-height: 550px;
        }

        model-viewer {
            min-height: 550px !important;
        }
    }

    /* Mobile Optimization */
    @media (max-width: 850px) {
        .info-wrapper {
            grid-template-columns: 1fr;
        }
        
        .info-model {
            order: 1;
            min-height: 400px;
            margin-bottom: 60px;
        }

        .model-viewer-container {
            min-height: 400px;
        }

        model-viewer {
            min-height: 400px !important;
        }
        
        .info-text {
            order: 2;
        }
        
        .info-text h1 {
            font-size: 2rem;
        }

        .ar-button {
            padding: 10px 16px;
            font-size: 0.85rem;
            bottom: -50px;
            right: 0;
        }

        .ar-button i {
            font-size: 0.95rem;
        }
    }
</style>

</x-layout>
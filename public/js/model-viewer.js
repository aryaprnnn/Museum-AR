// 3D Model Viewer with AR support
function initModelViewer(modelUrl, modelName) {
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
}

function viewARMode() {
    const modelViewer = document.getElementById('modelViewer');
    if (modelViewer && modelViewer.src) {
        console.log('Triggering AR mode...');
        modelViewer.activateAR();
    }
}

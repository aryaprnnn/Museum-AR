<x-layout title="{{ $currentItem->name }}" :mainClass="'light-bg hide-navbar'">

<div class="info-page-wrapper">
    <main class="info-page-main">
        <div class="info-wrapper">
            <!-- TEXT SECTION -->
            <div class="info-text">
                <h1>{{ $currentItem->name }}</h1>
                <div class="info-description">
                    <p>{{ $currentItem->description }}</p>
                    @if($currentItem->origin || $currentItem->era)
                        <p><strong>Asal:</strong> {{ $currentItem->origin ?? '-' }} | <strong>Era:</strong> {{ $currentItem->era ?? '-' }}</p>
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
                                : asset('storage/'.$currentItem->model_3d))
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
                    <button id="arButton" class="ar-button" onclick="viewARMode()" title="{{ __('content.collections_page.view_in_ar') }}" style="display: none;">
                        <i class="fas fa-cube"></i> {{ __('content.collections_page.view_in_ar') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="back-button-container">
            <a href="{{ route('search') }}" class="btnkembali">{{ __('content.collections_page.back_to_collections') }}</a>
        </div>
    </main>
</div>

{{-- External Stylesheet --}}
<link rel="stylesheet" href="{{ asset('css/information.css') }}">

<!-- Model Viewer Script -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>

{{-- External JavaScript --}}
<script src="{{ asset('js/model-viewer.js') }}"></script>
<script>
    // Initialize model viewer with data from PHP
    // const modelUrl = "{{ $modelUrl }}";
    // const modelName = "{{ $currentItem->name }}";
    // initModelViewer(modelUrl, modelName);
</script>

</x-layout>

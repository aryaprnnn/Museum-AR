<x-layout title="Home">

    {{-- Video Hero Section --}}
    <section id="video-section" style="height: calc(100vh - 55px); padding-top: 0; background: #000; display: flex; align-items: center; justify-content: center;">
        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
            <div style="position: relative; width: 100%; height: 100%; overflow: hidden;">
                <video 
                    autoplay 
                    muted 
                    loop 
                    playsinline
                    disablepictureinpicture
                    controlslist="nodownload noplaybackrate nofullscreen"
                    oncontextmenu="return false;"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                >
                    <source src="{{ asset('video/museumV.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </section>

    <main>
        @include('frontend.partials.about-preview')

        @include('frontend.partials.artclass-preview')
        @include('frontend.partials.exhibitions-preview')

        @include('frontend.partials.collections-preview')

        <div></div>
        <div></div>

        @include('frontend.partials.cara-penggunaan')

        <div></div>
        <div></div>

        @include('frontend.partials.blogs-preview')

        @include('frontend.partials.cta')
    </main>

</x-layout>

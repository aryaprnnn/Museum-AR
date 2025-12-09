<x-layout title="Home">

    @include('sections.hero')

    <main>
        @include('sections.about-preview')

        <div></div>
        <div></div>

        @include('sections.pengalaman')
        
        <div></div>
        <div></div>

        @include('sections.blogs-preview')

        <div></div>
        <div></div>

        @include('sections.collections-preview')

        <div></div>
        <div></div>

        @include('sections.cara-penggunaan')

        @include('sections.cta')
    </main>

</x-layout>

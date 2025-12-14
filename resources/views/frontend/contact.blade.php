<x-layout title="Contact Us">
<div class="contact-page-wrapper" style="padding-top: 0;">
    <!-- CONTACT INFO SECTION -->
    <section class="contact-info-section">
        <div class="container" style="max-width: 800px;">
            <h1 style="color: #543A14; text-align: center; margin-bottom: 20px;">{{ __('content.contact_page.title') }}</h1>
            <p style="text-align: center; color: #666; font-size: 1.1rem; margin-bottom: 40px;">
                {{ __('content.contact_page.address') }}<br>
                {{ __('content.contact_page.hours') }}
            </p>
            
            <!-- MAP SECTION -->
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666666666667!2d106.82666666666667!3d-6.175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMzAuMCJTIDEwNsKwNDknMzYuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                    width="100%" 
                    height="400" 
                    style="border:0; border-radius: 15px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- SOCIAL MEDIA SECTION -->
            <div class="social-media-section">
                <h2 style="text-align: center; color: #543A14; margin-bottom: 30px;">{{ __('content.contact_page.follow_us') }}</h2>
                <div class="social-links">
                    <a href="https://instagram.com/museumvirtual" target="_blank" class="social-link instagram">
                        <i class="fab fa-instagram"></i>
                        <span>{{ __('content.contact_page.instagram') }}</span>
                    </a>
                    <a href="mailto:info@museumvirtual.com" class="social-link email">
                        <i class="fas fa-envelope"></i>
                        <span>{{ __('content.contact_page.email') }}</span>
                    </a>
                    <a href="https://youtube.com/@museumvirtual" target="_blank" class="social-link youtube">
                        <i class="fab fa-youtube"></i>
                        <span>{{ __('content.contact_page.youtube') }}</span>
                    </a>
                </div>
            </div>

            <!-- TICKET BOOKING SECTION -->
            <div class="ticket-booking-section">
                <div class="ticket-content">
                    <div class="ticket-text">
                        <h3>{{ __('content.contact_page.ticket_title') }}</h3>
                        <p>{{ __('content.contact_page.ticket_description') }}</p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20memesan%20tiket%20kunjungan%20virtual" target="_blank" class="btn-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                        {{ __('content.contact_page.ticket_cta') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</x-layout>


<section class="intro-section slider_section_home">
  <div class="connn">
    <div class="home-slider owl-carousel owl-theme" id="banner-carousel">
      <!-- Dynamic banners will load here -->
    </div>
  </div>
</section>
<style>
  /* ===== Reduce banner slider height ===== */
  .slider_section_home .home-slide {
    height: 450px;           /* desktop height */
  }
  .slider_section_home .home-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain;        /* fills area neatly without distortion */
    background:#ffffff;
  }

  /* smaller on mobile */
  @media (max-width: 768px) {
    .slider_section_home .home-slide {
      height: 220px;
    }
  }
</style>

<script>
  const BASEs_URL = "https://api.stockoutindia.com/api";
  const bannerContainer = $("#banner-carousel");

  fetch(`${BASEs_URL}/banners`)
    .then((res) => res.json())
    .then((res) => {
      if (res.success && Array.isArray(res.data)) {
        // Destroy existing OwlCarousel (if already initialized)
        if (bannerContainer.hasClass("owl-loaded")) {
          bannerContainer.trigger('destroy.owl.carousel');
          bannerContainer.removeClass("owl-loaded owl-carousel owl-theme");
          bannerContainer.html(''); // Clear HTML
        }

        // Add banners
        res.data.forEach((url, index) => {
          const slide = `
            <div class="home-slide banner">
              <img src="${url}" class="img-fluid w-100" alt="Banner ${index + 1}">
            </div>`;
          bannerContainer.append(slide);
        });

        // Re-initialize Owl Carousel
        bannerContainer.addClass("owl-carousel owl-theme").owlCarousel({
          items: 1,
          loop: true,
          margin: 0,
          nav: true,
          dots: false,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          navText: [            // ✅ customize arrow icons
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ]
        });
      } else {
        console.error("Invalid banner data");
      }
    })
    .catch((err) => console.error("Error fetching banners:", err));
</script>

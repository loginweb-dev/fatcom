<!-- Carousel Wrapper -->
        <div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
    
          <!-- Slides -->
          <div class="carousel-inner" role="listbox">
            <!-- First slide -->
            <div class="carousel-item active movil-hidden" style="max-height:600px">
              <div class="view h-100" style="margin-top:-100px">
                <video autoplay width="100%" muted loop>
                    <source src="{{ url('ecommerce_public/templates/restaurante_v1/media/video1.mp4') }}" type="video/mp4">
                Tu navegador no soporta videos.</video>
              </div>
            </div>

            <div class="carousel-item active h-100 movil-show">
                <div class="view h-100">
                    <img class="d-block h-100 w-lg-100" src="{{ url('ecommerce_public/templates/restaurante_v1/media/banner1.jpg') }}" alt="Second slide">
                    <div class="mask">
                    </div>
                </div>
            </div>
            <!-- First slide -->

            <div style="position:absolute;bottom:40px;right:10px;z-index:1">
                <a href="#">
                    <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/btn-google-play.png') }}" width="100px" alt="button google play">
                </a>
                <a href="#">
                    <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/btn-app-store.png') }}" width="100px" alt="button google play">
                </a>
            </div>
    
          </div>
          <!-- Slides -->
    
        </div>
        <!-- Carousel Wrapper -->
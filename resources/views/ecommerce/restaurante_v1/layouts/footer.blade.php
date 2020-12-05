<!-- Footer -->
  <footer class="page-footer text-center text-md-left stylish-color-dark pt-0" style="background-color: black !important">
    <div class="principal-color">

      <div class="container">

        <!-- Grid row -->
        <div class="row py-4 d-flex align-items-center">

          <!-- Grid column -->
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">

            <h6 class="mb-0 black-text">Conéctate con nosotros en las redes sociales!</h6>

          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-6 col-lg-7 text-center text-md-right">
            <!-- Facebook -->
            <a class="fb-ic ml-0 px-2" href="{{ setting('social.facebook') }}" target="_blank">
              <i class="fab fa-facebook-f black-text"> </i>
            </a>
            <!-- Instagram -->
            <a class="ins-ic px-2" href="{{ setting('social.instagram') }}" target="_blank">
              <i class="fab fa-instagram black-text"> </i>
            </a>
            <!-- Whatsapp -->
            <a class="tw-ic px-2" href="{{ setting('social.whatsapp') }}" target="_blank">
                <i class="fab fa-whatsapp black-text"> </i>
              </a>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </div>

    <!-- Footer Links -->
    <div class="container mt-5 mb-4 text-center text-md-left">
      <div class="row mt-3">
        <!-- First column -->
        <div class="col-md-6 col-lg-6 mb-4">
          <h6 class="text-uppercase font-weight-bold">
            <strong>{{ setting('empresa.title') }}</strong>
          </h6>
          <hr class="principal-color mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>{{ setting('empresa.description') }}</p>
        </div>
        <!-- First column -->

        <!-- Second column -->
        <div class="col-md-4 col-lg-4 col-xl-3 mb-4">

          <h6 class="text-uppercase font-weight-bold">
            <strong>Te ofrecemos</strong>
          </h6>
          <hr class="principal-color mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a href="#!">Pizzas</a>
          </p>
          <p>
            <a href="#!">Gaseosas</a>
          </p>
          <p>
            <a href="#!">Refrescos naturales</a>
          </p>
          {{-- <p>
            <a href="#!">Bootstrap Angular</a>
          </p> --}}

        </div>
        <!-- Second column -->

        <!-- Fourth column -->
        <div class="col-md-4 col-lg-4 col-xl-3">

          <h6 class="text-uppercase font-weight-bold">
            <strong>Contacto</strong>
          </h6>
          <hr class="principal-color mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p><i class="fas fa-home mr-3"></i>{{ setting('empresa.direccion') }}</p>
          <p><i class="fas fa-envelope mr-3"></i> {{ setting('empresa.email')  }}</p>
          <p><i class="fas fa-phone mr-3"></i>{{ setting('empresa.celular') }}</p>
          <p><i class="fas fa-map-marker mr-3"></i> {{ setting('empresa.ciudad') }}</p>

        </div>
        <!-- Fourth column -->

      </div>

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright py-3 text-center">

      <div class="container-fluid">
        <h5>&copy; 2019 Copyright <a href="https://pizzastatu.com" target="_blank"> Pizzas Tatu</a></h5>
        <small>Powered By <a href="https://loginweb.net" target="_blank"> LoginWeb</a></small>
      </div>

    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
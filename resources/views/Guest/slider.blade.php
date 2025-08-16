<!-- Slider / Carousel dari URL Website -->
<div id="main-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
      <li data-target="#main-carousel" data-slide-to="1"></li>
      <li data-target="#main-carousel" data-slide-to="2"></li>
      <li data-target="#main-carousel" data-slide-to="3"></li>
      <li data-target="#main-carousel" data-slide-to="4"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img style="object-fit: cover;
        width: 100%;
        height: auto; 
        display: block;" src="{{ asset('img/images/hotel1 (1).png') }}" class="d-block w-100" alt="Banner 1">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('img/images/hotel1 (2).png') }}" class="d-block w-100" alt="Banner 2">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('img/images/hotel1 (3).png') }}" class="d-block w-100" alt="Banner 3">
      </div>

      <div class="carousel-item">
        <img src="{{ asset('img/images/hotel1 (4).png') }}" class="d-block w-100" alt="Banner 4">
      </div><div class="carousel-item">
        <img src="{{ asset('img/images/hotel1 (5).png') }}" class="d-block w-100" alt="Banner 5">
      </div>
    </div>
    <a class="carousel-control-prev" href="#main-carousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Sebelumnya</span>
    </a>
    <a class="carousel-control-next" href="#main-carousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Berikutnya</span>
    </a>
  </div>
  
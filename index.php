<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!DOCTYPE html>
<?php
session_start(); // Asegúrate de iniciar la sesión aquí
?>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="images/favicon.png" />

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link href="css/tiny-slider.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <title>EasyBook</title>
</head>

<body>
  <!-- Start Header/Navigation -->
  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
    <div class="container">
      <a class="navbar-brand" href="index.html">EasyBook<span>.</span></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item active">
            <a class="nav-link" href="index.html">Inicio</a>
          </li>
          <li><a class="nav-link" href="shop.html">Shop</a></li>
          <li><a class="nav-link" href="about.html">Sobre Nosotros</a></li>
          <li><a class="nav-link" href="services.html">Services</a></li>
          <?php if (isset($_SESSION['usuario'])) : ?>
            <li><a class="nav-link" href="php/logout.php">Cerrar Sesión</a></li>
          <?php else : ?>
            <li><a class="nav-link" href="php/login.php">Iniciar sesión</a></li>
            <li><a class="nav-link" href="php/registro.php">Registro</a></li>
          <?php endif; ?>
          <li><a class="nav-link" href="contact.html">Contacto</a></li>
        </ul>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li>
            <a class="nav-link" href="php/profile.php"> <img src="images/user.svg" /></a>
          </li>
          <li>
            <a class="nav-link" href="cart.html"><img src="images/cart.svg" /></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Header/Navigation -->

  <!-- End Header/Navigation -->

  <!-- Start Hero Section -->
  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1>
              Reservar nunca había <span clsas="d-block">sido tan fácil</span>
            </h1>
            <p class="mb-4">
              Realiza tu reserva en pocos minutos con EasyBook, solamente
              tendrás que seleccionar el servicio y confirmarlo. Así de fácil,
              desde cualquier parte, incluso desde el sofá de tu casa.
            </p>
            <p>
              <a href="" class="btn btn-secondary me-2">Explorar</a><a href="#" class="btn btn-white-outline">Ver mis reservas</a>
            </p>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="hero-img-wrap">
            <img src="images/couch.png" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->

  <!-- Start Product Section -->
  <div class="product-section">
    <div class="container">
      <div class="row">
        <!-- Start Column 1 -->
        <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
          <h2 class="mb-4 section-title">
            Echa un ojo a nuestros servicios destacados.
          </h2>
          <p class="mb-4">
            Descubre entre más de 100 servicios diferentes y sus respectiva
            diversidad de ubicaciones y especialidades
          </p>
          <p><a href="php/secciones.php" class="btn">Explore</a></p>
        </div>
        <!-- End Column 1 -->

        <!-- Start Column 2 -->
        <!-- Columna para Peluquerías y barberías -->
        <!-- Columna para Peluquerías y barberías -->
        <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
          <a class="product-item" href="../php/secciones.php?tipo=peluqueria">
            <img src="images/barbero.png" class="img-fluid product-thumbnail" />
            <h3 class="product-title">Peluquerías y barberías</h3>
            <strong class="product-price">desde 50.00€</strong>
            <span class="icon-cross">
              <img src="images/cross.svg" class="img-fluid" />
            </span>
          </a>
        </div>

        <!-- Columna para Entrenadores personales -->
        <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
          <a class="product-item" href="../php/secciones.php?tipo=tipo_entrenador">
            <img src="images/personalTrainer.png" class="img-fluid product-thumbnail" />
            <h3 class="product-title">Entrenadores personales</h3>
            <strong class="product-price">desde 78.00€</strong>
            <span class="icon-cross">
              <img src="images/cross.svg" class="img-fluid" />
            </span>
          </a>
        </div>

        <!-- Columna para Salud y derivados -->
        <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
          <a class="product-item" href="../php/secciones.php?tipo=tipo_salud">
            <img src="images/doctor.png" class="img-fluid product-thumbnail" />
            <h3 class="product-title">Salud y derivados</h3>
            <strong class="product-price">Desde 43.00€</strong>
            <span class="icon-cross">
              <img src="images/cross.svg" class="img-fluid" />
            </span>
          </a>
        </div>

      </div>
    </div>
    <!-- End Product Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-6">
            <h2 class="section-title">¿Por qué EasyBook?</h2>
            <p>
              En EasyBook encontrarás una gran variedad de servicios a tu
              alcance, agrupados por categorías. Simple y cómodo.
            </p>

            <div class="row my-5">
              <div class="col-6 col-md-6">
                <div class="feature">
                  <div class="icon">
                    <img src="images/truck.svg" alt="Image" class="imf-fluid" />
                  </div>
                  <h3>Confirma tu reserva al instante.</h3>
                  <p>
                    Olvida las largas esperas de confirmación. Con nuestro
                    sistema de reservas, tu reserva se confirma al instante.
                  </p>
                </div>
              </div>

              <div class="col-6 col-md-6">
                <div class="feature">
                  <div class="icon">
                    <img src="images/bag.svg" alt="Image" class="imf-fluid" />
                  </div>
                  <h3>Fácil para todo el mundo</h3>
                  <p>
                    Reservar nunca ha sido tan fácil. Nuestro proceso intuitivo
                    te guía paso a paso para una reserva sin complicaciones.
                  </p>
                </div>
              </div>

              <div class="col-6 col-md-6">
                <div class="feature">
                  <div class="icon">
                    <img src="images/support.svg" alt="Image" class="imf-fluid" />
                  </div>
                  <h3>Soporte 24/7</h3>
                  <p>
                    ¿Tienes preguntas o necesitas ayuda con tu reserva? Nuestro
                    equipo de soporte está siempre disponible para asistirte.
                  </p>
                </div>
              </div>

              <div class="col-6 col-md-6">
                <div class="feature">
                  <div class="icon">
                    <img src="images/return.svg" alt="Image" class="imf-fluid" />
                  </div>
                  <h3>Posibilidad de cancelación</h3>
                  <p>
                    Entendemos que los planes pueden cambiar. Ofrecemos
                    políticas de cancelación flexibles para adaptarnos a tus
                    necesidades.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="img-wrap">
              <img src="images/whyUs2.png" alt="Image" class="img-fluid" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start We Help Section -->
    <div class="we-help-section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-7 mb-5 mb-lg-0">
            <div class="imgs-grid">
              <div class="grid grid-1">
                <img src="images/conferencia.png" alt="Untree.co" />
              </div>
              <div class="grid grid-2">
                <img src="images/feliz.png" alt="Untree.co" />
              </div>
              <div class="grid grid-3">

                <img src="images/grafica.png" alt="Untree.co" />
              </div>
            </div>
          </div>
          <div class="col-lg-5 ps-lg-5">
            <h2 class="section-title mb-4">
              ¿Eres una Empresa y Quieres Trabajar con Nosotros?
            </h2>
            <p>
              Amplía tu mercado y haz crecer tu negocio uniéndote a nuestra red de reservas online. Te ofrecemos la plataforma ideal para conectar con miles de clientes interesados en tus servicios.
            </p>

            <ul class="list-unstyled custom-list my-4">
              <li>Acceso a una amplia base de clientes activos.</li>
              <li>Gestión eficiente de tu agenda y disponibilidad.</li>
              <li>Marketing digital para impulsar tu visibilidad.</li>
              <li>Soporte dedicado para tu satisfacción.</li>
            </ul>
            <p><a href="#" class="btn">Descubre Más</a></p>
          </div>

          <!-- End We Help Section -->

          <!-- Start Popular Product -->
          <div class="popular-product">
            <div class="container">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                  <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                      <img src="images/ventas.png" alt="Image" class="img-fluid" />
                    </div>
                    <div class="pt-3">
                      <h3>Impulso de ventas</h3>
                      <p>
                        Con EasyBook, verás un aumento significativo en tus ventas gracias a nuestra extensa red de usuarios activos buscando tus servicios.
                      </p>
                      <p><a href="#">Leer mas</a></p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                  <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                      <img src="images/aumento.png" alt="Image" class="img-fluid" />
                    </div>
                    <div class="pt-3">
                      <h3>Crecimiento empresarial</h3>
                      <p>
                        Propulsa tu negocio al próximo nivel aprovechando nuestras herramientas de marketing y gestión de reservas personalizadas.

                      </p>
                      <p><a href="#">Leer mas</a></p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                  <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                      <img src="images/mapa.png" alt="Image" class="img-fluid" />
                    </div>
                    <div class="pt-3">
                      <h3>Expansion de mercado</h3>
                      <p>
                        Accede a nuevos mercados y clientes con EasyBook. Nuestra plataforma facilita la conexión entre tu oferta y la demanda del cliente.
                      </p>
                      <p><a href="#">Leer más</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Popular Product -->

          <!-- Start Testimonial Slider -->
          <div class="testimonial-section">
            <div class="container">
              <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                  <h2 class="section-title">Opiniones de clientes reales</h2>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-lg-12">
                  <div class="testimonial-slider-wrap text-center">
                    <div id="testimonial-nav">
                      <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                      <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">
                      <div class="item">
                        <div class="row justify-content-center">
                          <div class="col-lg-8 mx-auto">
                            <div class="testimonial-block text-center">
                              <blockquote class="mb-5">
                                <p>
                                  &ldquo;Desde que me uní a EasyBook, el número de citas ha aumentado significativamente. La plataforma es muy fácil de usar y nuestros clientes adoran la comodidad de reservar en línea. El soporte técnico siempre está disponible y dispuesto a ayudar. ¡Definitivamente ha sido un cambio positivo para mi negocio!&rdquo;
                                </p>
                              </blockquote>
                              <div class="author-info">
                                <div class="author-pic">
                                  <img src="images/laura.jpg" alt="Laura Gómez" class="img-fluid" />
                                </div>
                                <h3 class="font-weight-bold">Laura Gómez</h3>
                                <span class="position d-block mb-3">Dueña de "Estética Laura"</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END item -->

                      <div class="item">
                        <div class="row justify-content-center">
                          <div class="col-lg-8 mx-auto">
                            <div class="testimonial-block text-center">
                              <blockquote class="mb-5">
                                <p>
                                  &ldquo;Incorporar EasyBook en nuestro gimnasio ha transformado completamente la forma en que manejamos las reservas de nuestras clases. Los clientes están encantados de poder elegir y reservar sus clases con antelación. Además, la gestión de horarios se ha hecho mucho más eficiente. ¡Recomiendo EasyBook a cualquier empresa que busque mejorar su servicio al cliente.&rdquo;
                                </p>
                              </blockquote>

                              <div class="author-info">
                                <div class="author-pic">
                                  <img src="images/Jorge.png" alt="Jorge Marín" class="img-fluid" />
                                </div>
                                <h3 class="font-weight-bold">Jorge Marín</h3>
                                <span class="position d-block mb-3"> Propietario de "GymFit Energía".</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END item -->

                      <div class="item">
                        <div class="row justify-content-center">
                          <div class="col-lg-8 mx-auto">
                            <div class="testimonial-block text-center">
                              <blockquote class="mb-5">
                                <p>
                                  &ldquo;EasyBook ha sido una revolución para nuestro restaurante. La posibilidad de reservar mesas en línea nos ha ayudado a organizarnos mejor y ofrecer un servicio al cliente de primera. Los comentarios de los clientes han sido excelentes, destacando siempre lo fácil y rápido que es el proceso de reserva. Estamos más que satisfechos con esta colaboración.&rdquo;
                                </p>
                              </blockquote>

                              <div class="author-info">
                                <div class="author-pic">
                                  <img src="images/carmen.jpg" alt="Carmen Ruiz" class="img-fluid" />
                                </div>
                                <h3 class="font-weight-bold">Carmen Ruiz</h3>
                                <span class="position d-block mb-3">Gerente de "La Mesa Redonda"</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END item -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Testimonial Slider -->

          <!-- Start Blog Section -->
          <div class="blog-section">
            <div class="container">
              <div class="row mb-5">
                <div class="col-md-6">
                  <h2 class="section-title">Características Destacadas</h2>
                </div>
                <div class="col-md-6 text-start text-md-end">
                  <a href="#" class="more">Explora Más</a>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                  <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="images/post-1.jpg" alt="Image" class="img-fluid" /></a>
                    <div class="post-content-entry">
                      <h3><a href="#">Seguridad y Confianza</a></h3>
                      <div class="meta">
                        <p>Protegemos tus transacciones con encriptación avanzada. Confía en EasyBook para una experiencia segura.</p>
                        <span>on <a href="#">Dec 19, 2021</a></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                  <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="images/post-2.jpg" alt="Image" class="img-fluid" /></a>
                    <div class="post-content-entry">
                      <h3><a href="#">Integración Fácil</a></h3>
                      <div class="meta">
                        <p>Nuestro soporte técnico garantiza una integración sin complicaciones para que puedas enfocarte en tu negocio.</p>
                        <span>on <a href="#">Dec 15, 2021</a></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                  <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="images/post-3.jpg" alt="Image" class="img-fluid" /></a>
                    <div class="post-content-entry">
                      <h3><a href="#">Personalización de la Oferta</a></h3>
                      <div class="meta">
                        <p>Crea ofertas únicas y atractivas con nuestras herramientas de personalización para captar más clientes.</p>
                        <span>on <a href="#">Dec 12, 2021</a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Blog Section -->

          <!-- Start Footer Section -->
          <footer class="footer-section">
            <div class="container relative">
              <div class="sofa-img">
                <img src="images/sofa.png" alt="Image" class="img-fluid" />
              </div>

              <div class="row">
                <div class="col-lg-8">
                  <div class="subscription-form">
                    <h3 class="d-flex align-items-center">
                      <span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid" /></span><span>¿Tienes alguna duda? Ponte en contacto con nosotros</span>
                    </h3>

                    <form action="#" class="row g-3">
                      <div class="col-auto">
                        <textarea class="form-control" rows="5" placeholder="Escribe aquí tu mensaje" required></textarea>
                        <!-- <input
                    type="text"
                    class="form-control"
					
                    placeholder="Enter your name"
                  /> -->
                      </div>
                      <div class="col-auto">
                        <input type="email" class="form-control" placeholder="Enter your email" />
                      </div>
                      <div class="col-auto">
                        <button class="btn btn-primary">
                          <span class="fa fa-paper-plane"></span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="row g-5 mb-5">
                <div class="col-lg-4">
                  <div class="mb-4 footer-logo-wrap">
                    <a href="#" class="footer-logo">EasyBook<span>.</span></a>
                  </div>
                  <p class="mb-4">
                    Descubre la forma más sencilla y rápida de gestionar tus reservas. Con EasyBook, tienes acceso a un amplio abanico de servicios y la comodidad de reservar desde cualquier lugar.
                  </p>

                  <ul class="list-unstyled custom-social">
                    <li>
                      <a href="#"><span class="fa fa-brands fa-facebook-f"></span></a>
                    </li>
                    <li>
                      <a href="#"><span class="fa fa-brands fa-twitter"></span></a>
                    </li>
                    <li>
                      <a href="#"><span class="fa fa-brands fa-instagram"></span></a>
                    </li>
                    <li>
                      <a href="#"><span class="fa fa-brands fa-linkedin"></span></a>
                    </li>
                  </ul>
                </div>

                <div class="col-lg-8">
                  <div class="row links-wrap">
                    <div class="col-6 col-sm-6 col-md-3">
                      <ul class="list-unstyled">
                        <li><a href="#">Sobre nosotros</a></li>
                        <li><a href="#">Servicios</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contáctanos</a></li>
                      </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                      <ul class="list-unstyled">
                        <li><a href="#">Soporte</a></li>
                        <li><a href="#">Base de conocimiento</a></li>
                        <li><a href="#">Chat en vivo</a></li>
                      </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                      <ul class="list-unstyled">
                        <li><a href="#">Empleos</a></li>
                        <li><a href="#">Nuestro equipo</a></li>
                        <li><a href="#">Liderazgo</a></li>
                        <li><a href="#">Política de privacidad</a></li>
                      </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                      <ul class="list-unstyled">
                        <li><a href="#">Términos y condiciones</a></li>
                        <li><a href="#">Política de privacidad</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border-top copyright">
                <div class="row pt-4">
                  <div class="col-lg-6">
                    <p class="mb-2 text-center text-lg-start">
                      Copyright &copy;
                      <script>
                        document.write(new Date().getFullYear());
                      </script>
                      . Todos los Derechos Reservados. — Diseñado con amor por
                      <a href="https://github.com/dmbalvaroo">Álvaro de Miguel Bea
                        <a href="https://untree.co">Distribuido por Untree.co</a>
                    </p>
                  </div>

                  <div class="col-lg-6 text-center text-lg-end">
                    <ul class="list-unstyled d-inline-flex ms-auto">
                      <li class="me-4"><a href="#">Términos &amp; Condiciones</a></li>
                      <li><a href="#">Política de privacidad</a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- End Footer Section -->

              <script src="js/bootstrap.bundle.min.js"></script>
              <script src="js/tiny-slider.js"></script>
              <script src="js/custom.js"></script>
</body>

</html>
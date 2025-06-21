<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <form id="FormLogin">
              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">AVPC</h2>
                <p class="text-white-50 mb-5">Sistema de Capacitación y Entrenamiento Militar</p>

                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <input type="text" name="usuario_dpi" id="usuario_dpi" class="form-control form-control-lg" placeholder="Ingrese su DPI" maxlength="13" />
                  <label class="form-label" for="usuario_dpi">DPI</label>
                </div>

                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <input type="password" name="usuario_contra" id="usuario_contra" class="form-control form-control-lg" placeholder="Ingrese su contraseña" />
                  <label class="form-label" for="usuario_contra">Contraseña</label>
                </div>

                <button type="submit" id="BtnIniciar" class="btn btn-outline-light btn-lg px-5">
                  <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </button>

                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="#!" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                  <a href="#!" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                  <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                </div>

              </div>


            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="<?= asset('build/js/login/index.js') ?>"></script>

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: #1a2332;
        background: -webkit-linear-gradient(135deg, rgba(26, 35, 50, 1), rgba(46, 125, 50, 1), rgba(27, 94, 32, 1));
        background: linear-gradient(135deg, rgba(26, 35, 50, 1), rgba(46, 125, 50, 1), rgba(27, 94, 32, 1));
    }
    
    body {
        min-height: 100vh;
        height: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .gradient-custom {
        min-height: 100vh;
        height: 100%;
    }
    
    .card {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(0, 0, 0, 0.6) !important;
    }
    
    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #46a545;
        box-shadow: 0 0 0 0.2rem rgba(70, 165, 69, 0.25);
        color: white;
    }
    
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .btn-outline-light:hover {
        background-color: #46a545;
        border-color: #46a545;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(70, 165, 69, 0.3);
    }
    
    .btn-outline-light {
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .text-white-50:hover {
        color: #ffffff !important;
        transition: color 0.3s ease;
    }
    
    /* Animación para el formulario */
    .card-body {
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilo para los datos de prueba */
    .text-start {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.8; }
        50% { opacity: 1; }
        100% { opacity: 0.8; }
    }
</style>


<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <form id="FormLogin">
              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">PEREZ COMISIONES</h2>
                <p class="text-white-50 mb-5">Sistema de Gestión de Comisiones</p>

                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <input type="text" name="usuario_dpi" id="usuario_dpi" class="form-control form-control-lg" />
                  <label class="form-label" for="usuario_dpi">DPI</label>
                </div>

                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <input type="password" name="usuario_contra" id="usuario_contra" class="form-control form-control-lg" />
                  <label class="form-label" for="usuario_contra">Contraseña</label>
                </div>

                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">¿Olvidaste tu contraseña?</a></p>

                <button type="submit" id="BtnIniciar" class="btn btn-outline-light btn-lg px-5">Iniciar Sesión</button>

                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                  <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                  <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                </div>

              </div>

              <div>
                <p class="mb-0">¿No tienes cuenta? <a href="#!" class="text-white-50 fw-bold">Contacta al administrador</a>
                </p>
              </div>
            </form>

          </div>
<<<<<<< HEAD
=======
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet">
</head>
<body>

<section class="text-center vh-100">
  <div class="p-5 bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 400px;
        "></div>
  <div class="card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary" style="
        margin-top: -150px;
        backdrop-filter: blur(30px);
        ">
    <div class="card-body py-5 px-md-5">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-md-8">
          
          <form id="FormLogin">
            <div class="mb-md-5 mt-md-4 pb-5">
              
              <h2 class="fw-bold mb-2 text-uppercase">INICIO DE SESION</h2>
              <p class="text-muted mb-5">INGRESA USUARIO Y CONTRASEÑA</p>

        
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="usu_codigo" id="usu_codigo" class="form-control form-control-lg" />
                <label class="form-label" for="usu_codigo">DPI</label>
              </div>

       
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="usu_password" id="usu_password" class="form-control form-control-lg" />
                <label class="form-label" for="usu_password">Password</label>
              </div>

       
              <button type="submit" id="BtnIniciar" class="btn btn-primary btn-lg px-5 mb-4">
                Iniciar Sesion
              </button>

  

            </div>
          </form>

>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
        </div>
      </div>
    </div>
  </div>
</section>

<<<<<<< HEAD
<script src="<?= asset('build/js/login/index.js') ?>"></script>
=======
<<<<<<< HEAD
<script src="<?= asset('build/js/login/index.js') ?>"></script>
=======
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>

<script src="<?= asset('build/js/login/login.js') ?>"></script>
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
        background: #2c3e50;
        background: -webkit-linear-gradient(to right, rgba(44, 62, 80, 1), rgba(52, 152, 219, 1));
        background: linear-gradient(to right, rgba(44, 62, 80, 1), rgba(52, 152, 219, 1));
    }
    body {
        min-height: 100vh;
        height: 100%;
    }
    .gradient-custom {
        min-height: 100vh;
        height: 100%;
    }
<<<<<<< HEAD
</style>
=======
</style>
=======
    }
    
    body {
        min-height: 100vh;
        background: #f8f9fa;
    }
    
    .bg-image {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    

    .card {
        background: rgba(255, 255, 255, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }

    
    .btn-floating:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
   
    .form-control:focus {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        background: linear-gradient(45deg, #764ba2 0%, #667eea 100%);
    }
</style>

</body>
</html>
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

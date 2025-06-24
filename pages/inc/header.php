<?php

$instagram_url = $_settings->info('instagram_footer');

$user_id = $_settings->userdata('id');
$user_type = $_settings->userdata('type');
$logo = validate_image($_settings->info('logo'));
$favicon = validate_image($_settings->info('favicon'));
$enable_password = $_settings->info('enable_password');
$enable_pixel = $_settings->info('enable_pixel');
$enable_ga4 = $_settings->info('enable_ga4');
$google_ga4_id = $_settings->info('google_ga4_id');
$enable_gtm = $_settings->info('enable_gtm');
$google_gtm_id = $_settings->info('google_gtm_id');
$facebook_access_token = $_settings->info('facebook_access_token');
$facebook_pixel_id = $_settings->info('facebook_pixel_id');
$affiliate = $_settings->userdata('is_affiliate');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
$path_name = $parts['path'];
$path = explode('/', $path_name);
$page = $path[1];

if (isset($parts['query'])) {
  parse_str($parts['query'], $query);
  $ref = $query['ref'];

  if (isset($ref)) {
    $_SESSION['ref'] = $ref;
  }
}

echo '<html translate="no">' . "\r\n" . '<html lang="pt-br">' . "\r\n" . '<head>' . "\r\n" . '   <meta charset="utf-8">' . "\r\n" . '   <meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\r\n" . '   <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">' . "\r\n" . '   ';
echo exibir_cabecalho($conn);
echo '   ';

if ($favicon) {
  echo '   <link rel="shortcut icon" href="';
  echo $favicon;
  echo '" />' . "\r\n" . '   <link rel="apple-touch-icon" sizes="180x180" href="';
  echo validate_image($_settings->info('favicon'));
  echo '"> ' . "\r\n" . '   <link rel="icon" type="image/png" sizes="32x32" href="';
  echo validate_image($_settings->info('favicon'));
  echo '">' . "\r\n" . '   <link rel="icon" type="image/png" sizes="16x16" href="';
  echo validate_image($_settings->info('favicon'));
  echo '">' . "\r\n" . '   ';
}

echo '   <meta name="theme-color" content="#000000">' . "\r\n" . '   <link rel="stylesheet" href="';
echo BASE_URL;
echo 'assets/css/style.css">' . "\r\n" . '   <script src="';
echo BASE_URL;
echo 'includes/jquery/jquery.min.js"></script>   ' . "\r\n" . '   <script> var _base_url_ = \'';
echo BASE_URL;
echo '\'; </script>' . "\r\n" . '   ';
if ($enable_pixel == 1 && !empty($facebook_pixel_id)) {
  echo '   <script>' . "\r\n" . '      !function (f, b, e, v, n, t, s) {' . "\r\n" . '         if (f.fbq) return; n = f.fbq = function () {' . "\r\n" . '               n.callMethod ?' . "\r\n" . '               n.callMethod.apply(n, arguments) : n.queue.push(arguments)' . "\r\n" . '         };' . "\r\n" . '         if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = \'2.0\';' . "\r\n" . '         n.queue = []; t = b.createElement(e); t.async = !0;' . "\r\n" . '         t.src = v; s = b.getElementsByTagName(e)[0];' . "\r\n" . '         s.parentNode.insertBefore(t, s)' . "\r\n" . '      }(window, document, \'script\',' . "\r\n" . '         \'https://connect.facebook.net/en_US/fbevents.js\');' . "\r\n" . '      fbq(\'init\', \'';
  echo $facebook_pixel_id;
  echo '\');' . "\r\n" . '      fbq(\'track\', \'PageView\');' . "\r\n" . '   </script>' . "\r\n" . '   <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=';
  echo $facebook_pixel_id;
  echo '&ev=PageView&noscript=1" /></noscript>' . "\r\n" . '   ';
}

echo '   ';
if ($enable_ga4 == 1 && !empty($google_ga4_id)) {
  echo '   <script async src="https://www.googletagmanager.com/gtag/js?id=';
  echo $google_ga4_id;
  echo '"></script>' . "\r\n" . '   <script>' . "\r\n" . '      window.dataLayer = window.dataLayer || [];' . "\r\n" . '      function gtag(){dataLayer.push(arguments);}' . "\r\n" . '      gtag(\'js\', new Date());' . "\r\n\r\n" . '      gtag(\'config\', \'';
  echo $google_ga4_id;
  echo '\');' . "\r\n" . '   </script>' . "\r\n" . '   ';
}

echo '   ';
if ($enable_gtm == 1 && !empty($google_gtm_id)) {
  echo '      <!-- Google Tag Manager -->' . "\r\n" . '      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':' . "\r\n" . '      new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],' . "\r\n" . '      j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=' . "\r\n" . '      \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);' . "\r\n" . '      })(window,document,\'script\',\'dataLayer\',\'';
  echo $google_gtm_id;
  echo '\');</script>' . "\r\n" . '      <!-- End Google Tag Manager -->' . "\r\n" . '   ';
}

echo '</head>' . "\r\n" . '<body>' . "\r\n";
if ($enable_gtm == 1 && !empty($google_gtm_id)) {
  echo '   <!-- Google Tag Manager (noscript) -->' . "\r\n" . '   <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=';
  echo $google_gtm_id;
  echo '"' . "\r\n" . '   height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\r\n" . '   <!-- End Google Tag Manager (noscript) -->' . "\r\n";
}

echo '<div id="__next">';
echo $user_type == '1'

  ? '
    <style>
    .header-app-header {
top:30px;
}
    </style>    
    <div class="text-center" style="background-color: #282828; font-size:.7em; padding: 10px; position: relative;color:#fff">
		<a href="/admin" style="text-align:center;color:#fff;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="margin-top: -3px;" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"></path>
  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"></path>
</svg> Ir para o painel administrativo.</a>
	</div>'
  : '';

echo '   <header class="header-app-header ' . $page . ' ">' . "\r\n" . '      <div class="header-app-header-container">' . "\r\n" . '         <div class="container container-600 font-mdd">' . "\r\n" . '            <div style="text-align-last: justify; padding: 10 0 10 0;">' . "\r\n" . '                <button type="button" aria-label="Menu" class="btn btn-link text-white font-lgg ps-0" data-bs-toggle="modal" data-bs-target="#mobileMenu" style="margin-top:5px">' . "\r\n" . '                    <i class="bi bi-filter-left"></i>' . "\r\n" . '                </button>' . "\r\n" . '                <a class="flex-grow-1 text-center" href="/">' . "\r\n" . '                ';

if ($logo) {
  echo '                     <img src="';
  echo $logo;
  echo '" class="header-app-brand"></a>' . "\r\n" . '                  ';
} else {
  echo '                     <img src="';
  echo BASE_URL;
  echo 'assets/img/logo.png" class="header-app-brand"></a>' . "\r\n" . '                  ';
}

echo '                </a>' . "\r\n" . '                ';

if (CONTACT_TYPE == '1') {
  echo '                <a class="btn btn-link text-white pe-0 text-right text-decoration-none" href="/contato">' . "\r\n" . '                ';
} else {
  echo '                <a class="btn btn-link text-white pe-0 text-right text-decoration-none" href="';
  echo 'https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone');
  echo '">' . "\r\n" . '                ';
}

echo '                    <div class="suporte d-flex justify-content-end opacity-50"><i class="bi bi-chat-right-dots-fill"></i></div>' . "\r\n" . '                    <div class="suporte text-yellow font-xss">Suporte</div>' . "\r\n" . '                </a>' . "\r\n" . '            </div>' . "\r\n" . '               </div>' . "\r\n" . '            </header>' . "\r\n" . '            <div class="black-bar ' . $page . ' fuse"></div>' . "\r\n" . '            <menu id="mobileMenu" class="modal fade modal-fluid" tabindex="-1" aria-labelledby="mobileMenuLabel" aria-hidden="true">' . "\r\n" . '               <div class="modal-dialog modal-fullscreen">' . "\r\n" . '                  <div class="modal-content bg-cor-primaria">' . "\r\n" . '                     <header class="app-header app-header-mobile--show">' . "\r\n" . '                        <div class="container container-600 h-100 d-flex align-items-center justify-content-between">' . "\r\n\r\n" . '                         ';

if ($logo) {
  echo '                           <a href="/">' . "\r\n" . '                              <img src="';
  echo $logo;
  echo '" class="app-brand img-fluid">' . "\r\n" . '                           </a>' . "\r\n" . '                        ';
} else {
  echo '                           <a href="/">' . "\r\n" . '                              <img src="';
  echo BASE_URL;
  echo 'assets/img/logo.png" class="app-brand img-fluid">' . "\r\n" . '                           </a>' . "\r\n" . '                        ';
}

echo "\r\n" . '                        <div class="app-header-mobile"><button type="button" class="btn btn-link text-white menu-mobile--button pe-0 font-lgg" data-bs-dismiss="modal" aria-label="Fechar"><i class="bi bi-x-circle"></i></button></div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </header>' . "\r\n" . '                  <div class="modal-body">' . "\r\n" . '                     <div class="container container-600">' . "\r\n" . '                        ';

if ($user_id) {
  echo '                           <div class="card-usuario mb-2">' . "\r\n" . '                              <picture>' . "\r\n" . '                                 <img src="';
  echo $_settings->userdata('avatar') ? validate_image($_settings->userdata('avatar')) : BASE_URL . 'assets/img/avatar.png';
  echo '" class="img-fluid img-perfil">' . "\r\n" . '                              </picture>' . "\r\n" . '                              <div class="card-usuario--informacoes">' . "\r\n" . '                               <h3>Olá, ';
  $firstname = ucwords($_settings->userdata('firstname'));
  $lastname = ucwords($_settings->userdata('lastname'));
  echo $firstname . ' ' . $lastname . '';
  echo '                            </h3>' . "\r\n" . '                            <div class="email font-xss saldo-value"></div>' . "\r\n" . '                         </div>' . "\r\n" . '                         <div class="card-usuario--sair">' . "\r\n" . '                            <a href="';
  echo BASE_URL . 'logout?' . $_SERVER['REQUEST_URI'];
  echo '"> ' . "\r\n" . '                              <button type="button" class="btn btn-link text-center text-white-50 ps-1 pe-0 pt-0 pb-0 font-lg">' . "\r\n" . '                                 <i class="bi bi-box-arrow-left"></i>' . "\r\n" . '                              </button>' . "\r\n" . '                           </a>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  ';
}

echo "\r\n" . '                  <nav class="nav-vertical nav-submenu font-xs mb-2">' . "\r\n" . '                     <ul>' . "\r\n\r\n" . '                        <li>' . "\r\n" . '                           <a class="text-white" alt="Página Principal" href="/"><i class="icone bi bi-house"></i><span>Início</span></a>' . "\r\n" . '                        </li>' . "\r\n\r\n" . '                        <li>' . "\r\n" . '                           <a class="text-white" alt="Campanhas" href="/campanhas"><i class="icone bi bi-megaphone"></i><span>Campanhas</span></a>' . "\r\n" . '                        </li>' . "\r\n\r\n" . '                        <li>' . "\r\n" . '                           <a class="text-white" alt="Meus Números" href="/meus-numeros"><i class="icone bi bi-card-list"></i><span>Meus números</span>' . "\r\n" . '                           </a>' . "\r\n" . '                        </li>' . "\r\n" . '                        ';

if ($user_id) {
  echo '   ' . "\r\n" . '                          <li>' . "\r\n" . '                             <a alt="Atualizar cadastro" class="text-white" href="/user/atualizar-cadastro"><i class="icone bi bi-person-circle"></i><span>Cadastro</span>' . "\r\n" . '                             </a>' . "\r\n" . '                          </li>' . "\r\n\r\n" . '                          <li>' . "\r\n" . '                           <a alt="Minhas compras" class="text-white" href="/user/compras"><i class="icone bi bi-cart-check"></i><span>Minhas compras</span>' . "\r\n" . '                           </a>' . "\r\n" . '                        </li>' . "\r\n" . '                         ';

  if ($enable_password == 1) {
    echo '                        <li><a alt="Alterar senha" class="text-white" href="/user/alterar-senha"><i class="icone bi bi-key-fill"></i><span>Alterar senha</span></a></li>' . "\r\n" . '                         ';
  }

  echo '                     ';
} else {
  echo '                       <li>' . "\r\n" . '                        <a alt="Cadastre-se" class="text-white" href="/cadastrar"><i class="icone bi bi-box-arrow-in-right"></i><span>Cadastro</span>' . "\r\n" . '                        </a>' . "\r\n" . '                     </li>' . "\r\n\r\n" . '                  ';
}

echo "\r\n" . '                  <li>' . "\r\n" . '                     <a alt="Ganhadores" class="text-white" href="/ganhadores"><i class="icone bi bi-trophy"></i><span>Ganhadores</span>' . "\r\n" . '                     </a>' . "\r\n" . '                  </li>' . "\r\n" . '                  ' . "\r\n" . '                  ';

if (!!$_settings->info('terms')) {
  echo '                     <li>' . "\r\n" . '                        <a alt="Termos de Uso" class="text-white" href="/termos-de-uso"><i class="icone bi bi-blockquote-right"></i><span>Termos de uso</span>' . "\r\n" . '                        </a>' . "\r\n" . '                     </li>' . "\r\n" . '                  ';
}

echo '                  ' . "\r\n" . '                  ';

if (CONTACT_TYPE == 1) {
  echo '                  <li class="col-contato-display">' . "\r\n" . '                     <a alt="Entre em contato conosco" class="text-white" href="/contato"><i class="icone bi bi-envelope"></i><span>Entrar em contato</span>' . "\r\n" . '                     </a>' . "\r\n" . '                  </li>' . "\r\n" . '                  ';
} else {
  echo '                  <li class="col-contato-display">' . "\r\n" . '                     <a alt="Entre em contato conosco" class="text-white" href="';
  echo 'https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone');
  echo '"><i class="icone bi bi-envelope"></i><span>Entrar em contato</span>' . "\r\n" . '                     </a>' . "\r\n" . '                  </li>' . "\r\n" . '                  ';
}

echo "\r\n" . '                  ';

if ($affiliate) {
  echo '                     <li class="col-contato-display">' . "\r\n" . '                        <a alt="Painel de afiliado" class="text-white" href="/user/afiliado"><i class="icone bi bi-wallet"></i></i><span>Painel de afiliado</span>' . "\r\n" . '                        </a>' . "\r\n" . '                     </li>' . "\r\n" . '                  ';
}

echo "\r\n\r\n" . '               </ul>' . "\r\n" . '            </nav>' . "\r\n" . '            ';

if (!$user_id) {
  echo '               <div class="text-center">' . "\r\n" . '                  <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-primary w-100 rounded-pill"><i class="icone bi bi-box-arrow-in-right"></i> Entrar</button>' . "\r\n" . '               ';
} else {
  echo '                  <a href="';
  echo BASE_URL . 'logout?' . $_SERVER['REQUEST_URI'];
  echo '">' . "\r\n" . '                     <button type="button" class="btn btn-primary w-100 rounded-pill"><i class="icone bi bi-box-arrow-in-right"></i> Sair</button>' . "\r\n" . '                  </a>' . "\r\n\r\n" . '               ';
}

echo '            </div>' . "\r\n\r\n" . '         </div>' . "\r\n" . '      </div>' . "\r\n" . '      ';
$disabled = true;
if (!$user_id && !$disabled) {
  echo '         <div class="modal-footer text-white"><small class="text-uppercase">Compartilhe</small><ul class="lista-horizontal"><li><a href="" alt="Acompanhe nosso Facebook" class="rede-social-item"><i class="bi bi-facebook"></i></a></li><li><a href="" alt="Acompanhe nosso Instagram" class="rede-social-item"><i class="bi bi-instagram"></i></a></li><li><a href="" alt="Fale conosco no whatsapp" class="rede-social-item"><i class="bi bi-whatsapp"></i></a></li></ul></div>' . "\r\n" . '      ';
}

echo '   </div>' . "\r\n" . '</div>' . "\r\n" . '</menu>' . "\r\n" . '<div class="modal fade" id="modal-contas-bancarias">' . "\r\n" . '   <div class="modal-dialog modal-dialog-centered">' . "\r\n" . '      <div class="modal-content">' . "\r\n" . '         <div class="modal-header">' . "\r\n" . '            <h5 class="modal-title">Contas bancárias</h5>' . "\r\n" . '            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>' . "\r\n" . '         </div>' . "\r\n" . '         <div class="modal-body pb-1">' . "\r\n" . '            <p>Faça sua transferência e anexe o comprovante.</p>' . "\r\n" . '            <div id="contas-group-collapse"></div>' . "\r\n" . '         </div>' . "\r\n" . '      </div>' . "\r\n" . '   </div>' . "\r\n" . '</div>';

?>

<style>
  .fixed-plugin .fixed-plugin-button {
    background: #fff;
    border-radius: 50%;
    bottom: 30px;
    right: 30px;
    font-size: 1.25rem;
    z-index: 990;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, .16);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;

  }

  /* From Uiverse.io by ahmed150up */
  .cardin {
    display: flex;
    height: 70px;
    width: 70px;
    bottom: 30px;
    right: 30px;
    position: fixed;
  }

  .cardwp {
    display: flex;
    height: 70px;
    width: 70px;
    bottom: 60px;
    right: 30px;
    position: fixed;
  }

  .cardin svg {
    position: absolute;
    display: flex;
    width: 60%;
    height: 100%;
    font-size: 24px;
    font-weight: 700;
    opacity: 1;
    transition: opacity 0.25s;
    z-index: 2;
    cursor: pointer;

  }

  .cardin .social-link1,
  .cardin .social-link2,
  .cardin .social-link3,
  .cardin .social-link4 {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    color: whitesmoke;
    font-size: 24px;
    text-decoration: none;
    transition: 0.25s;
    border-radius: 50px;

  }

  .cardin .social-link1 svg {
    transform: scale(1);
    color: #cc2366;
  }

  .cardin .social-link2 svg {
    transform: scale(1);
    color: #00ccff;
  }

  .cardin .social-link3 svg {
    transform: scale(1);
    color: #5865f2;
  }

  .cardin .social-link4 svg {
    transform: scale(1);
    color: #12a50b;
  }


  .cardin .social-link1:hover {
    background: #f09433;
    background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f09433', endColorstr='#bc1888', GradientType=1);
    animation: bounce_613 0.4s linear;
  }

  .cardin .social-link1:hover svg {
    color: #fff;
  }

  .cardin .social-link4:hover svg {
    color: #fff
  }

  .cardin .social-link2:hover {
    background-color: #00ccff;
    animation: bounce_613 0.4s linear;
  }

  .cardin .social-link3:hover {
    background-color: #5865f2;
    animation: bounce_613 0.4s linear;
  }

  .cardin .social-link4:hover {
    background-color: #12a50b;
    animation: bounce_613 0.4s linear;
  }

  @keyframes bounce_613 {
    40% {
      transform: scale(1.4);
    }

    60% {
      transform: scale(0.8);
    }

    80% {
      transform: scale(1.2);
    }

    100% {
      transform: scale(1);
    }
  }
</style>
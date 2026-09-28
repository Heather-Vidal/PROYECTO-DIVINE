 
<?php

/*
    DIVINE - Página informativa / Contáctanos

    Documento visual independiente.
    No utiliza base de datos ni guarda información.
*/

/* =========================================================
   INICIO DE SESIÓN PARA VALIDAR EL ROL
   ========================================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DIVINE | Beauty Store</title>

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {

            --rosa: #c9879e;
            --rosa-oscuro: #9b5d76;
            --rosa-claro: #ead0d9;
            --rosa-palido: #f7e9ed;

            --crema: #fbf7f1;
            --beige: #eee3d6;

            --vino: #704052;
            --vino-oscuro: #4e2c3a;

            --cafe: #765c50;
            --gris: #6f6866;

            --blanco: #ffffff;

            --sombra:
                0 12px 35px rgba(91, 55, 67, .10);
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            font-family: "DM Sans", sans-serif;

            background: var(--crema);

            color: var(--vino-oscuro);

            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {

            position: sticky;

            top: 0;

            z-index: 1000;

            background: rgba(251, 247, 241, .96);

            backdrop-filter: blur(10px);

            border-bottom:
                1px solid rgba(112, 64, 82, .10);
        }

        .nav-container {

            width: min(1180px, 92%);

            margin: auto;

            min-height: 76px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 25px;
        }

        .logo {

            font-family: "Playfair Display", serif;

            font-size: 31px;

            font-weight: 700;

            letter-spacing: 5px;

            color: var(--vino);
        }

        .logo span {
            color: var(--rosa-oscuro);
        }

        .nav-links {

            display: flex;

            align-items: center;

            gap: 28px;

            list-style: none;

            font-size: 14px;

            font-weight: 600;
        }

        .nav-links a {

            color: var(--cafe);

            transition: .25s;
        }

        .nav-links a:hover {
            color: var(--rosa-oscuro);
        }

        .nav-button {

            background: var(--vino);

            color: white !important;

            padding: 10px 19px;

            border-radius: 30px;
        }

        .nav-button:hover {
            background: var(--rosa-oscuro);
        }

        /* =====================================================
           HERO
        ===================================================== */

        .hero {

            min-height: 610px;

            display: flex;

            align-items: center;

            position: relative;

            overflow: hidden;

            background:

                radial-gradient(
                    circle at 90% 20%,
                    rgba(201,135,158,.20),
                    transparent 27%
                ),

                radial-gradient(
                    circle at 10% 80%,
                    rgba(238,227,214,.75),
                    transparent 30%
                ),

                var(--crema);
        }

        .hero::before {

            content: "DIVINE";

            position: absolute;

            right: -80px;

            bottom: -75px;

            font-family: "Playfair Display", serif;

            font-size: 220px;

            color: rgba(112,64,82,.035);

            font-weight: 700;
        }

        .hero-container {

            width: min(1180px, 92%);

            margin: auto;

            display: grid;

            grid-template-columns: 1.1fr .9fr;

            gap: 70px;

            align-items: center;
        }

        .eyebrow {

            color: var(--rosa-oscuro);

            text-transform: uppercase;

            letter-spacing: 4px;

            font-size: 12px;

            font-weight: 700;

            margin-bottom: 16px;
        }

        h1 {

            font-family: "Playfair Display", serif;

            font-size: clamp(55px, 7vw, 88px);

            line-height: .98;

            color: var(--vino-oscuro);

            margin-bottom: 25px;
        }

        h1 span {

            color: var(--rosa-oscuro);

            font-style: italic;
        }

        .hero-text {

            max-width: 590px;

            color: var(--gris);

            font-size: 17px;

            margin-bottom: 32px;
        }

        .hero-buttons {

            display: flex;

            flex-wrap: wrap;

            gap: 13px;
        }

        .btn {

            display: inline-block;

            padding: 13px 24px;

            border-radius: 30px;

            font-weight: 700;

            font-size: 14px;

            transition: .25s;
        }

        .btn-primary {

            background: var(--vino);

            color: white;

            box-shadow:
                0 8px 20px rgba(78,44,58,.18);
        }

        .btn-primary:hover {

            transform: translateY(-2px);

            background: var(--rosa-oscuro);
        }

        .btn-light {

            border: 1px solid var(--rosa-claro);

            color: var(--vino);

            background: rgba(255,255,255,.55);
        }

        .btn-light:hover {
            background: var(--rosa-palido);
        }

        .hero-card {

            min-height: 430px;

            border-radius:
                180px 180px 25px 25px;

            background:
                linear-gradient(
                    145deg,
                    #efd9df,
                    #f8eee9
                );

            box-shadow: var(--sombra);

            display: flex;

            align-items: center;

            justify-content: center;

            position: relative;

            overflow: hidden;
        }

        .hero-card::before {

            content: "";

            width: 270px;

            height: 270px;

            border-radius: 50%;

            background: rgba(255,255,255,.42);

            position: absolute;

            top: 55px;
        }

        .hero-brand {

            position: relative;

            text-align: center;

            z-index: 1;
        }

        .hero-brand .symbol {

            width: 105px;

            height: 105px;

            margin:
                auto auto 20px;

            border:
                2px solid var(--vino);

            border-radius: 50%;

            display: grid;

            place-items: center;

            font-family:
                "Playfair Display", serif;

            font-size: 43px;

            color: var(--vino);
        }

        .hero-brand h2 {

            font-family:
                "Playfair Display", serif;

            letter-spacing: 7px;

            font-size: 35px;
        }

        .hero-brand p {

            margin-top: 6px;

            letter-spacing: 3px;

            font-size: 10px;

            text-transform: uppercase;

            color: var(--rosa-oscuro);
        }

        /* =====================================================
           GENERAL
        ===================================================== */

        section {
            padding: 90px 0;
        }

        .section-container {

            width: min(1120px, 92%);

            margin: auto;
        }

        .section-title {

            text-align: center;

            margin-bottom: 52px;
        }

        .section-title small {

            color: var(--rosa-oscuro);

            text-transform: uppercase;

            letter-spacing: 3px;

            font-weight: 700;

            font-size: 11px;
        }

        .section-title h2 {

            font-family:
                "Playfair Display", serif;

            font-size:
                clamp(35px, 5vw, 50px);

            color:
                var(--vino-oscuro);

            margin:
                8px 0 12px;
        }

        .section-title p {

            color: var(--gris);

            max-width: 680px;

            margin: auto;
        }

        /* =====================================================
           ABOUT
        ===================================================== */

        .about {
            background: white;
        }

        .about-grid {

            display: grid;

            grid-template-columns:
                .9fr 1.1fr;

            gap: 65px;

            align-items: center;
        }

        .about-box {

            background:
                var(--rosa-palido);

            padding: 48px;

            border-radius: 30px;

            position: relative;

            overflow: hidden;
        }

        .about-box::after {

            content: "✦";

            position: absolute;

            right: 25px;

            top: 15px;

            font-size: 80px;

            color:
                rgba(155,93,118,.10);
        }

        .about-box h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 32px;

            margin-bottom: 14px;
        }

        .about-box p {
            color: var(--gris);
        }

        .about-content h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 34px;

            margin-bottom: 17px;
        }

        .about-content p {

            color: var(--gris);

            margin-bottom: 16px;
        }

        .quote {

            margin-top: 28px;

            padding-left: 20px;

            border-left:
                3px solid var(--rosa);

            color: var(--vino);

            font-family:
                "Playfair Display", serif;

            font-style: italic;

            font-size: 19px;
        }

        /* =====================================================
           FEATURES
        ===================================================== */

        .features {
            background: var(--crema);
        }

        .feature-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;
        }

        .feature-card {

            background: white;

            padding: 28px 23px;

            border-radius: 22px;

            box-shadow: var(--sombra);

            border:
                1px solid rgba(112,64,82,.06);

            transition: .25s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .icon {

            width: 50px;

            height: 50px;

            border-radius: 15px;

            background:
                var(--rosa-palido);

            display: grid;

            place-items: center;

            font-size: 22px;

            margin-bottom: 17px;
        }

        .feature-card h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 21px;

            margin-bottom: 7px;
        }

        .feature-card p {

            font-size: 13px;

            color: var(--gris);
        }

        /* =====================================================
           MODULES
        ===================================================== */

        .modules {

            background:
                var(--vino-oscuro);

            color: white;
        }

        .modules .section-title h2 {
            color: white;
        }

        .modules .section-title p {
            color: #dfcfd4;
        }

        .module-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;
        }

        .module {

            padding: 27px;

            border:
                1px solid rgba(255,255,255,.13);

            border-radius: 22px;

            background:
                rgba(255,255,255,.055);
        }

        .module-number {

            color:
                var(--rosa-claro);

            font-size: 12px;

            letter-spacing: 2px;

            font-weight: 700;
        }

        .module h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 23px;

            margin: 8px 0;
        }

        .module p {

            color: #d9cbd0;

            font-size: 13px;
        }

        /* =====================================================
           TEAM
        ===================================================== */

        .team {
            background: white;
        }

        .team-grid {

            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 16px;
        }

        .member {

            text-align: center;

            padding: 25px 13px;

            background:
                var(--crema);

            border-radius: 24px;

            border:
                1px solid var(--beige);
        }

        .avatar {

            width: 82px;

            height: 82px;

            margin:
                0 auto 16px;

            border-radius: 50%;

            background:
                var(--rosa-palido);

            border:
                1px solid var(--rosa-claro);

            display: grid;

            place-items: center;

            color: var(--vino);

            font-family:
                "Playfair Display", serif;

            font-size: 25px;
        }

        .member h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 18px;

            margin-bottom: 5px;
        }

        .member p {

            font-size: 12px;

            color: var(--gris);
        }

        /* =====================================================
           PROJECT
        ===================================================== */

        .project {
            background: var(--beige);
        }

        .project-content {

            background:
                rgba(255,255,255,.68);

            padding: 50px;

            border-radius: 30px;

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 50px;
        }

        .project-content h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 29px;

            margin-bottom: 15px;
        }

        .project-content p {

            color: var(--gris);

            font-size: 14px;

            margin-bottom: 13px;
        }

        .mini-list {

            list-style: none;
        }

        .mini-list li {

            padding: 9px 0;

            border-bottom:
                1px solid rgba(112,64,82,.10);

            color: var(--cafe);

            font-size: 14px;
        }

        .mini-list li::before {

            content: "✦";

            color:
                var(--rosa-oscuro);

            margin-right: 10px;
        }

        /* =====================================================
           CONTACT
        ===================================================== */

        .contact {
            background: var(--crema);
        }

        .contact-box {

            display: grid;

            grid-template-columns:
                .8fr 1.2fr;

            background: white;

            border-radius: 32px;

            overflow: hidden;

            box-shadow:
                var(--sombra);
        }

        .contact-info {

            background:
                var(--vino);

            color: white;

            padding: 48px;
        }

        .contact-info h2 {

            font-family:
                "Playfair Display", serif;

            font-size: 39px;

            line-height: 1.1;

            margin-bottom: 18px;
        }

        .contact-info > p {

            color: #e4d6da;

            font-size: 14px;

            margin-bottom: 30px;
        }

        .contact-item {

            display: flex;

            gap: 14px;

            align-items: flex-start;

            margin: 20px 0;
        }

        .contact-item .contact-icon {

            width: 40px;

            height: 40px;

            flex-shrink: 0;

            border-radius: 12px;

            background:
                rgba(255,255,255,.10);

            display: grid;

            place-items: center;
        }

        .contact-item strong {

            display: block;

            font-size: 13px;

            margin-bottom: 2px;
        }

        .contact-item span {

            color: #d8c8ce;

            font-size: 13px;
        }

        .contact-form {
            padding: 48px;
        }

        .contact-form h3 {

            font-family:
                "Playfair Display", serif;

            font-size: 29px;

            margin-bottom: 5px;
        }

        .contact-form > p {

            color: var(--gris);

            font-size: 13px;

            margin-bottom: 23px;
        }

        .form-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 15px;
        }

        .field {
            margin-bottom: 15px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {

            display: block;

            font-size: 12px;

            font-weight: 700;

            color: var(--cafe);

            margin-bottom: 6px;
        }

        input,
        textarea {

            width: 100%;

            border:
                1px solid #e5d8d0;

            background:
                #fdfbf8;

            border-radius: 12px;

            padding: 12px 14px;

            outline: none;

            font-family: inherit;

            color: var(--vino);
        }

        input:focus,
        textarea:focus {

            border-color:
                var(--rosa);
        }

        textarea {

            resize: vertical;

            min-height: 125px;
        }

        .fake-submit {

            border: 0;

            cursor: pointer;

            margin-top: 3px;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        footer {

            background:
                #3d2630;

            color: white;

            padding:
                38px 0 25px;
        }

        .footer-container {

            width: min(1120px, 92%);

            margin: auto;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 25px;
        }

        .footer-logo {

            font-family:
                "Playfair Display", serif;

            font-size: 28px;

            letter-spacing: 4px;
        }

        .footer-text {

            color: #cbb9bf;

            font-size: 12px;

            max-width: 460px;
        }

        .copyright {

            width: min(1120px, 92%);

            margin:
                28px auto 0;

            padding-top: 20px;

            border-top:
                1px solid rgba(255,255,255,.10);

            color: #aa989e;

            font-size: 11px;

            text-align: center;
        }

        /* =====================================================
           SWEETALERT2 - DISEÑO DIVINE
        ===================================================== */

        .divine-alert {

            width: 430px !important;

            max-width: 92% !important;

            border-radius: 30px !important;

            padding:
                38px 34px 32px !important;

            background:
                linear-gradient(
                    145deg,
                    #fffdfb,
                    #fff7f9
                ) !important;

            border:
                1px solid #ead0d9 !important;

            box-shadow:
                0 25px 70px
                rgba(78,44,58,.20) !important;

            font-family:
                "DM Sans", sans-serif !important;
        }

        .divine-title {

            font-family:
                "Playfair Display", serif !important;

            color:
                #4e2c3a !important;

            font-size:
                30px !important;

            font-weight:
                700 !important;

            margin-top:
                12px !important;
        }

        .divine-text {

            color:
                #765c50 !important;

            font-size:
                15px !important;

            line-height:
                1.7 !important;

            margin-top:
                8px !important;
        }

        .divine-confirm {

            background:
                #704052 !important;

            color:
                #ffffff !important;

            border:
                none !important;

            border-radius:
                30px !important;

            padding:
                12px 30px !important;

            font-family:
                "DM Sans", sans-serif !important;

            font-size:
                14px !important;

            font-weight:
                700 !important;

            box-shadow:
                0 8px 22px
                rgba(112,64,82,.22) !important;

            transition:
                all .25s ease !important;
        }

        .divine-confirm:hover {

            background:
                #9b5d76 !important;

            transform:
                translateY(-2px) !important;

            box-shadow:
                0 12px 28px
                rgba(112,64,82,.28) !important;
        }

        .divine-icon {

            border-width:
                3px !important;

            margin-bottom:
                8px !important;
        }

        /* SUCCESS */

        .swal2-icon.swal2-success {

            border-color:
                #c9879e !important;

            color:
                #9b5d76 !important;
        }

        .swal2-icon.swal2-success
        .swal2-success-ring {

            border-color:
                #ead0d9 !important;
        }

        .swal2-icon.swal2-success
        [class^="swal2-success-line"] {

            background-color:
                #9b5d76 !important;
        }

        /* WARNING */

        .swal2-icon.swal2-warning {

            border-color:
                #c9879e !important;

            color:
                #c9879e !important;
        }

        /* ERROR */

        .swal2-icon.swal2-error {

            border-color:
                #9b5d76 !important;
        }

        .swal2-icon.swal2-error
        [class^="swal2-x-mark-line"] {

            background-color:
                #9b5d76 !important;
        }

        /* ANIMACIÓN */

        .swal2-show {

            animation:
                divineEntrada .38s ease-out !important;
        }

        @keyframes divineEntrada {

            from {

                opacity: 0;

                transform:
                    translateY(18px)
                    scale(.94);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .nav-links {
                gap: 13px;
            }

            .hero-container,
            .about-grid,
            .contact-box,
            .project-content {

                grid-template-columns:
                    1fr;
            }

            .hero {
                padding: 70px 0;
            }

            .hero-card {
                min-height: 350px;
            }

            .feature-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .module-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .team-grid {

                grid-template-columns:
                    repeat(3, 1fr);
            }
        }

        @media (max-width: 620px) {

            .nav-container {
                min-height: 68px;
            }

            .nav-links li:not(:last-child) {
                display: none;
            }

            .logo {
                font-size: 25px;
            }

            section {
                padding: 65px 0;
            }

            .feature-grid,
            .module-grid,
            .team-grid,
            .form-grid {

                grid-template-columns:
                    1fr;
            }

            .field.full {
                grid-column: auto;
            }

            .about-box,
            .project-content,
            .contact-info,
            .contact-form {

                padding: 30px;
            }

            .footer-container {

                flex-direction:
                    column;

                text-align:
                    center;
            }

            .divine-alert {

                padding:
                    30px 22px 26px !important;
            }

            .divine-title {

                font-size:
                    26px !important;
            }

            .divine-text {

                font-size:
                    14px !important;
            }
        }

    </style>

</head>

<body>


<?php

include 'submenu.php';

?>


<!-- =========================================================
     HERO
========================================================= -->

<header class="hero" id="inicio">

    <div class="hero-container">

        <div>

            <div class="eyebrow">
                Beauty · Skincare · Haircare
            </div>

            <h1>

                La belleza de<br>

                <span>
                    organizarlo todo.
                </span>

            </h1>

            <p class="hero-text">

                DIVINE es un proyecto de sistema web desarrollado para apoyar la
                gestión de un emprendimiento dedicado a productos de belleza,
                skincare y haircare, integrando en un solo espacio productos,
                pedidos, carritos, ventas, stock y usuarios.

            </p>

            <div class="hero-buttons">

                <a
                    href="#nosotros"
                    class="btn btn-primary"
                >
                    Conocer DIVINE
                </a>

                <a
                    href="#contacto"
                    class="btn btn-light"
                >
                    Contáctanos
                </a>

            </div>

        </div>


        <div class="hero-card">

            <div class="hero-brand">

                <div class="symbol">
                    D
                </div>

                <h2>
                    DIVINE
                </h2>

                <p>
                    Beauty Store · Sistema Web
                </p>

            </div>

        </div>

    </div>

</header>


<!-- =========================================================
     NOSOTROS
========================================================= -->

<section
    class="about"
    id="nosotros"
>

    <div class="section-container">

        <div class="section-title">

            <small>
                Sobre el proyecto
            </small>

            <h2>
                ¿Qué es DIVINE?
            </h2>

            <p>

                Una propuesta digital pensada para transformar y facilitar
                la administración de un emprendimiento de belleza.

            </p>

        </div>


        <div class="about-grid">

            <div class="about-box">

                <h3>
                    De lo manual a lo digital.
                </h3>

                <p>

               El sistema busca mejorar la administración de productos, usuarios y ventas, reemplazando el manejo
                de registros físicos de productos, pedidos e inventario por una gestión organizada mediante una base de 
                datos y módulos web, facilitando el proceso de compra de los clientes y optimizando la gestión del 
                emprendimiento DIVINE.

                </p>

            </div>


            <div class="about-content">

                <h3>
                    Una solución creada para DIVINE.
                </h3>

                <p>

                    El proyecto fue planteado a partir de las necesidades
                    identificadas en el emprendimiento, considerando tanto la
                    organización interna como la presentación de la información.

                </p>

                <p>

                    La propuesta combina una interfaz femenina y elegante con
                    funcionalidades orientadas a la administración de usuarios,
                    productos, pedidos, carritos, ventas, stock y reportes.

                </p>

                <div class="quote">

                    “Tecnología, organización y belleza en un mismo espacio.”

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     CARACTERÍSTICAS
========================================================= -->

<section class="features">

    <div class="section-container">

        <div class="section-title">

            <small>
                Características
            </small>

            <h2>
                Un sistema pensado para crecer
            </h2>

            <p>

                DIVINE reúne diferentes funciones para facilitar las tareas
                administrativas y comerciales del emprendimiento.

            </p>

        </div>


        <div class="feature-grid">

            <div class="feature-card">

                <div class="icon">
                    ♡
                </div>

                <h3>
                    Diseño elegante
                </h3>

                <p>

                    Interfaz con tonos rosa, crema, beige y detalles suaves
                    para mantener la identidad visual de DIVINE.

                </p>

            </div>


            <div class="feature-card">

                <div class="icon">
                    ▣
                </div>

                <h3>
                    Gestión organizada
                </h3>

                <p>

                    Información centralizada para administrar productos,
                    pedidos, ventas y usuarios de forma más ordenada.

                </p>

            </div>


            <div class="feature-card">

                <div class="icon">
                    ✦
                </div>

                <h3>
      Pedidos virtuales

                </h3>

                <p>
El cliente puede seleccionar productos, 
agregarlos al carrito y realizar pedidos de manera virtual, agilizando el proceso de compra.

                </p>

            </div>


            <div class="feature-card">

                <div class="icon">
                    ↗
                </div>

                <h3>
                    Información digital
                </h3>

                <p>

                    Uso de registros digitales para disminuir la dependencia
                    de documentos físicos en diferentes procesos.

                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     SISTEMA / MÓDULOS
========================================================= -->

<section
    class="modules"
    id="sistema"
>

    <div class="section-container">

        <div class="section-title">

            <small>
                Funcionalidades
            </small>

            <h2>
                ¿Qué integra el sistema?
            </h2>

            <p>

                DIVINE está estructurado en módulos que trabajan de manera
                relacionada para apoyar la gestión del emprendimiento.

            </p>

        </div>


        <div class="module-grid">


            <div class="module">

                <span class="module-number">
                    01
                </span>

                <h3>
                    Usuarios y roles
                </h3>

                <p>

                    Registro, acceso y administración de usuarios, con roles
                    de administrador y vendedor.

                </p>

            </div>


            <div class="module">

                <span class="module-number">
                    02
                </span>

                <h3>
                    Productos
                </h3>

                <p>

                    Registro, modificación, eliminación y consulta de productos
                    de las categorías SkinCare y SkinHair.

                </p>

            </div>


            <div class="module">

                <span class="module-number">
                    03
                </span>

                <h3>
                    Pedidos
                </h3>

                <p>

                    Gestión de pedidos, estados, datos del cliente y vendedor
                    responsable del pedido.

                </p>

            </div>


            <div class="module">

                <span class="module-number">
                    04
                </span>

                <h3>
                    Carrito
                </h3>

                <p>

                    Organización de los productos seleccionados y cantidades
                    relacionadas con cada pedido.

                </p>

            </div>


            <div class="module">

                <span class="module-number">
                    05
                </span>

                <h3>
                    Ventas
                </h3>

                <p>

                    Registro y consulta de ventas relacionadas con los pedidos
                    aceptados, incluyendo costos y métodos de pago.

                </p>

            </div>


            <div class="module">

                <span class="module-number">
                    06
                </span>

                <h3>
                    Stock y reportes
                </h3>

                <p>

                    Consulta de existencias, identificación de stock bajo y
                    visualización de información para apoyar la administración.

                </p>

            </div>

        </div>
<br>
         <div class="module">

                <span class="module-number">
                    07
                </span>

                <h3>
                  Pedidos virtuales
                </h3>

                <p>

                   El cliente puede seleccionar los productos de su preferencia, agregarlos al carrito y realizar
                    pedidos de manera virtual, sin necesidad de asistir personalmente a una tienda física. Esta funcionalidad 
                    facilita el proceso de compra,
                    permite gestionar las solicitudes de forma más organizada y brinda mayor comodidad al cliente.
                </p>

            </div>
            

        </div>

    </div>

</section>


<!-- =========================================================
     PROYECTO
========================================================= -->

<section class="project">

    <div class="section-container">

        <div class="section-title">

            <small>
                Desarrollo
            </small>

            <h2>
                Construcción de DIVINE
            </h2>

            <p>

                El desarrollo se organizó utilizando una metodología ágil y
                se dividió progresivamente para facilitar el seguimiento.

            </p>

        </div>


        <div class="project-content">


            <div>

                <h3>
                    Metodología Scrum
                </h3>

                <p>

                    El proyecto fue organizado mediante cinco sprints. Cada
                    etapa permitió avanzar de forma progresiva, revisar
                    los resultados y realizar ajustes de acuerdo con las
                    necesidades identificadas.

                </p>

                <p>

                    Las integrantes iniciaron el proyecto con responsabilidades
                    definidas de acuerdo con sus fortalezas y conocimientos,
                    trabajando de manera colaborativa durante el desarrollo.

                </p>

            </div>


            <div>

                <h3>
                    Áreas de trabajo
                </h3>

                <ul class="mini-list">

                    <li>
                        Base de datos y estructura de información
                    </li>

                    <li>
                        Diseño y maquetación web
                    </li>

                    <li>
                        Pruebas y verificación del sistema
                    </li>

                    <li>
                        Coordinación y seguimiento del proyecto
                    </li>

                    <li>
                        Trabajo colaborativo mediante GitHub
                    </li>

                </ul>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     EQUIPO
========================================================= -->

<section
    class="team"
    id="equipo"
>

    <div class="section-container">

        <div class="section-title">

            <small>
                Equipo DIVINE
            </small>

            <h2>
                Conoce a las integrantes
            </h2>

            <p>

                Cinco integrantes, diferentes responsabilidades y un mismo
                proyecto desarrollado de manera colaborativa.

            </p>

        </div>


        <div class="team-grid">


            <div class="member">

                <div class="avatar">
                    HV
                </div>

                <h3>
                    Heather Vidal
                </h3>

                <p>
                    Base de datos
                </p>

            </div>


            <div class="member">

                <div class="avatar">
                    LT
                </div>

                <h3>
                    Lesly Tolino
                </h3>

                <p>
                    Pruebas y verificación
                </p>

            </div>


            <div class="member">

                <div class="avatar">
                    PT
                </div>

                <h3>
                    Paola Tordoya
                </h3>

                <p>
                    Diseño y maquetación web
                </p>

            </div>


            <div class="member">

                <div class="avatar">
                    LG
                </div>

                <h3>
                    Lorena Gonzales
                </h3>

                <p>
                    Diseño y maquetación web
                </p>

            </div>


            <div class="member">

                <div class="avatar">
                    AS
                </div>

                <h3>
                    Aileen Sivila
                </h3>

                <p>
                    Coordinación y seguimiento
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     CONTACTO
========================================================= -->

<section
    class="contact"
    id="contacto"
>

    <div class="section-container">

        <div class="section-title">

            <small>
                Estamos para escucharte
            </small>

            <h2>
                Contáctanos
            </h2>

            <p>

                Un espacio visual para presentar los medios de contacto del
                proyecto y recibir consultas o comentarios.

            </p>

        </div>


        <div class="contact-box">


            <div class="contact-info">

                <h2>
                    Hablemos de DIVINE.
                </h2>

                <p>

                    ¿Tienes una consulta sobre el proyecto, el sistema o sus
                    funcionalidades? Este espacio está pensado para ti.

                </p>


                <div class="contact-item">

                    <div class="contact-icon">
                        ⌂
                    </div>

                    <div>

                        <strong>
                            Proyecto
                        </strong>

                        <span>
                            DIVINE · Beauty Store
                        </span>

                    </div>

                </div>


                <div class="contact-item">

                    <div class="contact-icon">
                        ✉
                    </div>

                    <div>

                        <strong>
                            Correo
                        </strong>

                        <span>
                            contacto@divine.com
                        </span>

                    </div>

                </div>


                <div class="contact-item">

                    <div class="contact-icon">
                        ⌕
                    </div>

                    <div>

                        <strong>
                            Área
                        </strong>

                        <span>
                            Skincare · Haircare · Belleza
                        </span>

                    </div>

                </div>


                <div class="contact-item">

                    <div class="contact-icon">
                        ✦
                    </div>

                    <div>

                        <strong>
                            Sistema DIVINE
                        </strong>

                        <span>
                            Sistema web para gestión del emprendimiento.
                        </span>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 FORMULARIO FUNCIONAL
            ================================================== -->

            <div class="contact-form">

                <h3>
                    Déjanos tu comentario
                </h3>

                <p>

                    Queremos conocer tu opinión sobre DIVINE.
                    Escribe tu nombre y déjanos un mensaje.

                </p>


                <form
                    action="comentar.php"
                    method="POST"
                >

                    <div class="form-grid">


                        <div class="field full">

                            <label for="autor">
                                Nombre
                            </label>

                            <input
                                type="text"
                                id="autor"
                                name="autor"
                                placeholder="Tu nombre"
                                autocomplete="name"
                                required
                            >

                        </div>


                        <div class="field full">

                            <label for="contenido">
                                Comentario
                            </label>

                            <textarea
                                id="contenido"
                                name="contenido"
                                placeholder="Escribe tu comentario..."
                                required
                            ></textarea>

                        </div>


                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary fake-submit"
                    >

                        Publicar comentario ♡

                    </button>

                </form>


                <!-- ==================================================
                     VER COMENTARIOS
                     SOLO APARECE SI LA SESIÓN ES ADMINISTRADOR
                =================================================== -->

                <?php

                if (
                    isset($_SESSION['rol']) &&
                    $_SESSION['rol'] === 'administrador'
                ):

                ?>

                    <a
                        href="comentar.php"
                        class="btn btn-light"
                        style="display:inline-block; margin-top:12px;"
                    >

                        Ver comentarios

                    </a>

                <?php endif; ?>


            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer>

    <div class="footer-container">

        <div class="footer-logo">
            DIVINE
        </div>

        <p class="footer-text">

            Sistema web desarrollado para apoyar la organización,
            administración y digitalización de un emprendimiento de belleza,
            skincare y haircare.

        </p>

    </div>


    <div class="copyright">

        © <?php echo date("Y"); ?>

        DIVINE · Todos los derechos reservados · Proyecto académico

    </div>

</footer>


<!-- =========================================================
     SWEETALERT2
     FUNCIÓN GENERAL
========================================================= -->

<script>

function divineAlert(icono, titulo, mensaje) {

    Swal.fire({

        icon: icono,

        title: titulo,

        text: mensaje,

        confirmButtonText: 'Aceptar',

        customClass: {

            popup: 'divine-alert',

            title: 'divine-title',

            htmlContainer: 'divine-text',

            confirmButton: 'divine-confirm',

            icon: 'divine-icon'

        },

        buttonsStyling: false,

        showConfirmButton: true,

        allowOutsideClick: true,

        allowEscapeKey: true,

        focusConfirm: false

    });

}

</script>


<!-- =========================================================
     SWEETALERT:
     COMENTARIO ENVIADO CORRECTAMENTE
========================================================= -->

<?php if (

    isset($_GET['comentario']) &&

    $_GET['comentario'] === 'ok'

): ?>

<script>

document.addEventListener('DOMContentLoaded', function() {

    divineAlert(

        'success',

        '¡Comentario enviado!',

        'Tu comentario fue enviado correctamente. Solo el administrador puede ver los comentarios.'

    );

});

</script>

<?php endif; ?>


<!-- =========================================================
     SWEETALERT:
     CAMPOS INCOMPLETOS
========================================================= -->

<?php if (

    isset($_GET['error']) &&

    $_GET['error'] === '1'

): ?>

<script>

document.addEventListener('DOMContentLoaded', function() {

    divineAlert(

        'warning',

        'Campos incompletos',

        'Por favor, completa tu nombre y tu comentario.'

    );

});

</script>

<?php endif; ?>


<!-- =========================================================
     SWEETALERT:
     ERROR AL GUARDAR
========================================================= -->

<?php if (

    isset($_GET['error']) &&

    $_GET['error'] === '2'

): ?>

<script>

document.addEventListener('DOMContentLoaded', function() {

    divineAlert(

        'error',

        'No se pudo guardar',

        'No se pudo guardar el comentario. Inténtalo nuevamente.'

    );

});

</script>

<?php endif; ?>


</body>

</html>
 
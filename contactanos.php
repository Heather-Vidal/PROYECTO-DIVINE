<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DIVINE | Belleza y cuidado personal</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --negro: #38272f;
    --negro-suave: #503843;
    --champagne: #f0cedb;
    --dorado: #b87993;
    --crema: #fff7fa;
    --beige: #f6e7ed;
    --blanco: #ffffff;
    --gris: #796a72;
    --borde: #eed7e1;
    --sombra: 0 15px 40px rgba(101,55,75,.10);
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}

body {
    font-family: "DM Sans", sans-serif;
    background: var(--crema);
    color: var(--negro);
    line-height: 1.7;
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    display: block;
    max-width: 100%;
}

button,
input,
textarea {
    font: inherit;
}

/* BARRA DE NAVEGACIÓN */

.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,247,250,.96);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--borde);
}

.nav-container {
    width: min(1180px,92%);
    min-height: 78px;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
}

.logo {
    font-family: "Playfair Display",serif;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 5px;
    white-space: nowrap;
}

.logo span,
.footer-logo span {
    color: var(--dorado);
}

.nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 28px;
    font-size: 13px;
    font-weight: 600;
}

.nav-links a {
    color: var(--negro-suave);
    transition: color .25s ease;
}

.nav-links a:hover {
    color: var(--dorado);
}

.nav-links .nav-button {
    background: var(--negro);
    color: #fff;
    padding: 11px 21px;
    border-radius: 30px;
    transition: background .25s ease;
}

.nav-links .nav-button:hover {
    background: var(--dorado);
    color: #fff;
}

/* PORTADA */

.hero {
    min-height: 620px;
    display: flex;
    align-items: center;
    padding: 65px 0;
    overflow: hidden;
    background:
        radial-gradient(
            circle at 8% 10%,
            rgba(184,121,147,.17),
            transparent 35%
        ),
        var(--crema);
}

.hero-container {
    width: min(1180px,92%);
    margin: auto;
    display: grid;
    grid-template-columns: 1.05fr .95fr;
    align-items: center;
    gap: 65px;
}

.eyebrow {
    display: inline-block;
    color: #a5637f;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

h1 {
    font-family: "Playfair Display",serif;
    font-size: clamp(48px,6vw,79px);
    line-height: 1.08;
    font-weight: 500;
    margin-bottom: 24px;
}

h1 span {
    display: block;
    color: #b87993;
    font-style: italic;
}

.hero-text {
    max-width: 560px;
    color: var(--gris);
    font-size: 16px;
    margin-bottom: 30px;
}

.hero-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 13px 24px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .25s ease,color .25s ease;
    border: 1px solid transparent;
}

.btn-primary {
    background: var(--negro);
    color: #fff;
}

.btn-primary:hover {
    background: var(--dorado);
}

.btn-light {
    color: var(--negro);
    background: transparent;
    border-color: #d5a9bb;
}

.btn-light:hover {
    background: var(--champagne);
}

.hero-image {
    position: relative;
    min-height: 490px;
    border-radius: 220px 220px 20px 20px;
    overflow: hidden;
    background: var(--beige);
    box-shadow: var(--sombra);
}

.hero-image > img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-caption {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    padding: 19px 22px;
    background: rgba(255,247,250,.93);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.6);
    border-radius: 15px;
}

.image-caption strong {
    display: block;
    font-family: "Playfair Display",serif;
    font-size: 22px;
    font-weight: 500;
}

.image-caption span {
    color: var(--gris);
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* CONFIGURACIÓN GENERAL */

section {
    padding: 90px 0;
}

.container {
    width: min(1120px,92%);
    margin: auto;
}

.section-title {
    max-width: 730px;
    margin: 0 auto 48px;
    text-align: center;
}

.section-title small {
    color: #a5637f;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 11px;
    font-weight: 700;
}

.section-title h2 {
    font-family: "Playfair Display",serif;
    font-size: clamp(34px,5vw,49px);
    line-height: 1.2;
    font-weight: 500;
    margin: 10px 0 15px;
}

.section-title p {
    color: var(--gris);
    font-size: 14px;
}

/* SOBRE DIVINE */

.about {
    background: var(--blanco);
}

.about-grid {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    gap: 65px;
    align-items: center;
}

.about-image {
    height: 440px;
    overflow: hidden;
    border-radius: 18px;
    background: var(--beige);
}

.about-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.about-content h3 {
    font-family: "Playfair Display",serif;
    font-size: 34px;
    line-height: 1.25;
    font-weight: 500;
    margin-bottom: 20px;
}

.about-content p {
    color: var(--gris);
    font-size: 14px;
    margin-bottom: 16px;
}

.about-note {
    border-left: 3px solid var(--dorado);
    padding: 13px 0 13px 19px;
    margin-top: 24px;
    color: #80566a;
    font-family: "Playfair Display",serif;
    font-size: 19px;
    font-style: italic;
}

.about-label {
    display: inline-block;
    margin-top: 10px;
    padding: 7px 13px;
    background: var(--crema);
    border: 1px solid var(--borde);
    border-radius: 20px;
    color: #966078;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* ESENCIA */

.essence {
    background: var(--crema);
}

.essence-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 22px;
}

.essence-card {
    padding: 35px 27px;
    background: #fff;
    border: 1px solid var(--borde);
    border-radius: 18px;
    transition: border-color .25s,box-shadow .25s;
}

.essence-card:hover {
    border-color: var(--dorado);
    box-shadow: var(--sombra);
}

.essence-icon {
    width: 53px;
    height: 53px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    border: 1px solid #dfb5c6;
    color: #b87993;
    font-size: 24px;
    margin-bottom: 22px;
}

.essence-card h3 {
    font-family: "Playfair Display",serif;
    font-size: 25px;
    font-weight: 500;
    margin-bottom: 12px;
}

.essence-card p {
    color: var(--gris);
    font-size: 13px;
}

/* TRES CAJAS DE CATEGORÍAS */

.categories {
    background: #fff;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 28px;
    align-items: stretch;
    width: 100%;
    max-width: 960px;
    margin: 0 auto;
}

.category-card {
    position: relative;
    height: 410px;
    min-height: 350px;
    overflow: hidden;
    border-radius: 22px;
    background: var(--beige);
    isolation: isolate;
    box-shadow: 0 12px 32px rgba(101,55,75,.09);
}

/* Carruseles laterales */

.category-slides,
.category-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}

.category-slide {
    object-fit: cover;
    opacity: 0;
    transform: scale(1.025);
    transition: opacity .35s ease,transform 1.4s ease;
}

.category-slide.active {
    opacity: 1;
    transform: scale(1);
}

.category-overlay {
    position: absolute;
    z-index: 2;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 25px;
    color: #fff;
    background: linear-gradient(
        to top,
        rgba(56,39,47,.88),
        rgba(56,39,47,.04) 80%
    );
    pointer-events: none;
}

.category-overlay span {
    color: #f5dce6;
    font-size: 10px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-weight: 700;
}

.category-overlay h3 {
    font-family: "Playfair Display",serif;
    font-size: 30px;
    font-weight: 500;
    margin: 5px 0;
}

.category-overlay p {
    font-size: 12px;
    color: #fff0f5;
}

.carousel-dots {
    position: absolute;
    z-index: 3;
    top: 17px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 7px;
}

.carousel-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(255,255,255,.55);
    border: 1px solid rgba(255,255,255,.85);
    transition: background .25s,transform .25s;
}

.carousel-dot.active {
    background: #fff;
    transform: scale(1.25);
}

/* CAJA CENTRAL ESTÁTICA, SIN CARRUSEL */

.category-static {
    background: linear-gradient(
        160deg,
        #fcecf2 0%,
        #f6dce6 48%,
        #ead0db 100%
    );
    border: 1px solid #efd1de;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 25px;
    color: #503843;
}

.category-static::before,
.category-static::after {
    content: "";
    position: absolute;
    border: 1px solid rgba(184,121,147,.32);
    border-radius: 50%;
    pointer-events: none;
}

.category-static::before {
    width: 275px;
    height: 275px;
    top: -90px;
    right: -95px;
}

.category-static::after {
    width: 210px;
    height: 210px;
    bottom: -80px;
    left: -65px;
}

.static-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 20px;
}

.static-flower {
    font-size: 38px;
    color: #b87993;
    line-height: 1;
    margin-bottom: 24px;
}

.static-eyebrow {
    font-size: 10px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #9e637d;
    font-weight: 700;
    margin-bottom: 13px;
}

.static-title {
    font-family: "Playfair Display",serif;
    font-size: clamp(30px,3vw,39px);
    font-weight: 500;
    line-height: 1.12;
    color: #503843;
    margin-bottom: 15px;
}

.static-title em {
    display: block;
    font-weight: 400;
    color: #b87993;
}

.static-description {
    max-width: 245px;
    color: #796a72;
    font-size: 12px;
    line-height: 1.8;
    margin-bottom: 22px;
}

.static-divider {
    height: 1px;
    width: 65px;
    background: #c58ca4;
    margin-bottom: 18px;
}

.static-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #c58ca4;
    border-radius: 30px;
    padding: 10px 17px;
    color: #684352;
    font-size: 11px;
    font-weight: 700;
    transition: background .25s,color .25s;
}

.static-link:hover {
    background: #b87993;
    color: #fff;
}

/* VALORES */

.values {
    background: #38272f;
    color: #fff;
}

.values .section-title h2 {
    color: #fff;
}

.values .section-title p {
    color: #eadce2;
}

.values .section-title small {
    color: #f0cedb;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 25px;
}

.value-item {
    text-align: center;
    padding: 20px 10px;
}

.value-number {
    font-family: "Playfair Display",serif;
    color: var(--champagne);
    font-size: 37px;
    margin-bottom: 10px;
}

.value-item h3 {
    font-family: "Playfair Display",serif;
    font-size: 21px;
    font-weight: 500;
    margin-bottom: 9px;
}

.value-item p {
    color: #eadce2;
    font-size: 12px;
}

/* EXPERIENCIA DIVINE */

.experience {
    background: var(--beige);
}

.experience-box {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 45px;
    background: rgba(255,255,255,.7);
    border: 1px solid rgba(184,121,147,.24);
    border-radius: 25px;
    padding: 45px;
}

.experience-box h2 {
    font-family: "Playfair Display",serif;
    font-size: 37px;
    line-height: 1.2;
    font-weight: 500;
    margin-bottom: 17px;
}

.experience-box p {
    color: var(--gris);
    font-size: 14px;
    margin-bottom: 15px;
}

.experience-list {
    list-style: none;
}

.experience-list li {
    padding: 13px 0;
    border-bottom: 1px solid var(--borde);
    color: var(--negro-suave);
    font-size: 13px;
}

.experience-list li::before {
    content: "✦";
    color: var(--dorado);
    margin-right: 12px;
}

/* CONTACTO Y FORMULARIO */

.contact {
    background: var(--crema);
}

.contact-box {
    display: grid;
    grid-template-columns: .85fr 1.15fr;
    background: #fff;
    border: 1px solid var(--borde);
    border-radius: 25px;
    overflow: hidden;
    box-shadow: var(--sombra);
}

.contact-info {
    background: #503843;
    color: #fff;
    padding: 45px;
}

.contact-info h2 {
    font-family: "Playfair Display",serif;
    font-size: 38px;
    line-height: 1.2;
    font-weight: 500;
    margin-bottom: 16px;
}

.contact-info > p {
    color: #eadce2;
    font-size: 13px;
    margin-bottom: 28px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin: 22px 0;
}

.contact-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border: 1px solid rgba(240,206,219,.4);
    border-radius: 12px;
    color: var(--champagne);
    font-size: 18px;
}

.contact-item strong {
    display: block;
    font-size: 13px;
    margin-bottom: 3px;
}

.contact-item span {
    color: #eadce2;
    font-size: 12px;
}

.contact-form {
    padding: 45px;
}

.contact-form h3 {
    font-family: "Playfair Display",serif;
    font-size: 30px;
    font-weight: 500;
    margin-bottom: 5px;
}

.contact-form > p {
    color: var(--gris);
    font-size: 13px;
    margin-bottom: 25px;
}

.field {
    margin-bottom: 18px;
}

.field label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 7px;
    color: var(--negro-suave);
}

.field input,
.field textarea {
    display: block;
    width: 100%;
    padding: 13px 14px;
    border: 1px solid var(--borde);
    border-radius: 10px;
    background: #fffafd;
    color: var(--negro);
    outline: none;
    transition: border-color .2s ease;
}

.field input:focus,
.field textarea:focus {
    border-color: var(--dorado);
}

.field textarea {
    min-height: 130px;
    resize: vertical;
}

.field input::placeholder,
.field textarea::placeholder {
    color: #a69aa0;
}

.label-error {
    display: block;
    color: #a94462;
    font-size: 12px;
    margin-top: 5px;
}

input.error,
textarea.error {
    border-color: #a94462 !important;
}

input.valid,
textarea.valid {
    border-color: #9caa8c;
}

.admin-link {
    display: inline-block;
    margin-top: 15px;
    font-size: 13px;
    color: #a5637f;
    text-decoration: underline;
    text-underline-offset: 4px;
}

/* PIE DE PÁGINA */

footer {
    background: #302129;
    color: #fff;
    padding: 38px 0 22px;
}

.footer-container {
    width: min(1120px,92%);
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.footer-logo {
    font-family: "Playfair Display",serif;
    font-size: 30px;
    letter-spacing: 5px;
}

.footer-text {
    max-width: 480px;
    color: #eadce2;
    font-size: 12px;
}

.copyright {
    width: min(1120px,92%);
    margin: 28px auto 0;
    padding-top: 18px;
    border-top: 1px solid rgba(255,255,255,.12);
    color: #d8c5ce;
    font-size: 11px;
    text-align: center;
}

/* ALERTAS */

.divine-alert {
    border-radius: 22px !important;
    border: 1px solid var(--borde) !important;
    background: var(--crema) !important;
    font-family: "DM Sans",sans-serif !important;
    box-shadow: 0 20px 60px rgba(0,0,0,.16) !important;
}

.divine-title {
    font-family: "Playfair Display",serif !important;
    color: var(--negro) !important;
    font-size: 28px !important;
}

.divine-text {
    color: var(--gris) !important;
    font-size: 14px !important;
    line-height: 1.7 !important;
}

.divine-confirm {
    background: var(--negro) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 25px !important;
    padding: 12px 28px !important;
    font-family: "DM Sans",sans-serif !important;
    font-weight: 700 !important;
    transition: background .2s !important;
}

.divine-confirm:hover {
    background: #b87993 !important;
}

.swal2-show {
    animation: divineEntrada .3s ease-out !important;
}

@keyframes divineEntrada {
    from {
        opacity: 0;
        transform: translateY(12px) scale(.97);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* DISEÑO RESPONSIVE */

@media(max-width:950px) {
    .nav-links { gap: 15px; }
    .hero-container { gap: 35px; }
    .hero-image { min-height: 400px; }
    .about-grid { gap: 35px; }
    .values-grid { grid-template-columns: repeat(2,1fr); }
    .experience-box { gap: 25px; padding: 30px; }
    .contact-info,.contact-form { padding: 30px; }
    .category-card { height: 350px; }
}

@media(max-width:720px) {
    .nav-container {
        flex-direction: column;
        padding: 15px 0;
        gap: 12px;
    }

    .nav-links {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px 20px;
        font-size: 12px;
    }

    .logo { font-size: 28px; }
    .hero { padding: 45px 0; }

    .hero-container,
    .about-grid,
    .experience-box,
    .contact-box {
        grid-template-columns: 1fr;
    }

    .hero-container { gap: 35px; }

    .hero-image {
        min-height: 390px;
        border-radius: 170px 170px 18px 18px;
    }

    section { padding: 65px 0; }
    .about-image { height: 330px; }

    .essence-grid,
    .category-grid {
        grid-template-columns: 1fr;
    }

    .category-card {
        height: 390px;
        min-height: 340px;
    }

    .values-grid { grid-template-columns: 1fr 1fr; }
    .experience-box { padding: 28px; }
    .contact-info,.contact-form { padding: 30px 24px; }
    .footer-container { flex-direction: column; text-align: center; }
}

@media(max-width:400px) {
    .nav-links { gap: 10px 14px; }
    .nav-links .nav-button { padding: 8px 13px; }
    .hero-buttons { flex-direction: column; align-items: stretch; }
    .values-grid { grid-template-columns: 1fr; }
    .hero-image { min-height: 330px; }
    .category-card { height: 340px; }
}

@media(prefers-reduced-motion:reduce) {
    html { scroll-behavior: auto; }
    .category-slide { transition: none; }
}
</style>
</head>
<body>

<?php include 'submenu.php'; ?>

<header class="hero" id="inicio">
    <div class="hero-container">
        <div class="hero-content">
            <span class="eyebrow">Belleza · Cuidado · Bienestar</span>
            <h1>Tu belleza,<span>tu esencia.</span></h1>

            <p class="hero-text">
                En DIVINE creemos que el cuidado personal es una forma de
                expresar lo mejor de ti. Somos un emprendimiento boliviano
                dedicado al cuidado de la piel y el cabello, con una propuesta
                que une belleza, bienestar y atención personal.
            </p>

            <div class="hero-buttons">
                <a href="#nosotros" class="btn btn-primary">Conoce nuestra marca</a>
                <a href="#categorias" class="btn btn-light">Descubre nuestras categorías</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="./imagenes/vvvv.png"
                 alt="Productos de belleza y cuidado personal" fetchpriority="high">

            <div class="image-caption">
                <strong>La belleza está en cuidarte.</strong>
                <span>DIVINE · Beauty Store</span>
            </div>
        </div>
    </div>
</header>

<section class="about" id="nosotros">
    <div class="container">
        <div class="section-title">
            <small>Conoce nuestra esencia</small>
            <h2>¿Quiénes somos?</h2>
            <p>Una marca que busca acompañarte en tus momentos de cuidado personal y belleza.</p>
        </div>

        <div class="about-grid">
            <div class="about-image">
                <img src="https://i.pinimg.com/1200x/22/4b/c1/224bc1e2a7a32fb95a694695d6f608b7.jpg"
                     alt="Productos y elementos para el cuidado personal" loading="lazy">
            </div>

            <div class="about-content">
                <h3>Belleza que nace del cuidado.</h3>

                <p>
                    DIVINE es un emprendimiento boliviano que inició sus
                    actividades en 2024 en la ciudad de Cochabamba. Está
                    dedicado al cuidado facial, capilar y la belleza personal.
                </p>

                <p>
                    Nuestra propuesta se centra en productos artesanales y
                    naturales orientados al cuidado de la piel y el cabello,
                    buscando que cada persona encuentre opciones para
                    incorporar el cuidado personal a su rutina.
                </p>

                <p>
                    Contamos con una tienda física y buscamos ofrecer un
                    espacio donde nuestros clientes puedan conocer nuestros
                    productos y descubrir alternativas relacionadas con sus
                    necesidades de belleza.
                </p>

                <div class="about-note">
                    “Cada rutina de cuidado es una oportunidad para dedicarte
                    tiempo a ti misma.”
                </div>

                <span class="about-label">COCHABAMBA · BOLIVIA</span>
            </div>
        </div>
    </div>
</section>

<section class="essence" id="esencia">
    <div class="container">
        <div class="section-title">
            <small>Nuestra esencia</small>
            <h2>Lo que nos inspira</h2>
            <p>
                Trabajamos para que el cuidado personal sea una experiencia
                agradable, accesible y especial.
            </p>
        </div>

        <div class="essence-grid">
            <article class="essence-card">
                <div class="essence-icon">✦</div>
                <h3>Cuidado personal</h3>
                <p>
                    Promovemos la importancia de dedicar tiempo a la piel,
                    el cabello y al bienestar personal, respetando las
                    necesidades de cada persona.
                </p>
            </article>

            <article class="essence-card">
                <div class="essence-icon">❋</div>
                <h3>Inspiración natural</h3>
                <p>
                    Nuestra propuesta contempla productos artesanales y
                    naturales orientados al cuidado de la piel y el cabello.
                </p>
            </article>

            <article class="essence-card">
                <div class="essence-icon">♡</div>
                <h3>Atención cercana</h3>
                <p>
                    Buscamos brindar una experiencia amable, ayudando a
                    nuestros clientes a conocer las opciones disponibles
                    para su rutina de belleza.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="categories" id="categorias">
    <div class="container">
        <div class="section-title">
            <small>Descubre DIVINE</small>
            <h2>Nuestras categorías</h2>
            <p>
                Descubre el cuidado capilar, un mensaje especial de DIVINE
                y nuestra selección de cuidado facial.
            </p>
        </div>

        <div class="category-grid">
            <!-- CAJA IZQUIERDA: HAIRCARE, CARRUSEL DE 7 IMÁGENES -->

<article class="category-card carousel" aria-label="Carrusel de haircare">
    <div class="category-slides">
        <img class="category-slide active"
             src="https://i.pinimg.com/736x/f3/20/c5/f320c57ddced30d4d0c9c1bce0132e7d.jpg"
             alt="Cuidado capilar 1" loading="lazy">

        <img class="category-slide"
             src="https://i.pinimg.com/1200x/22/1c/f0/221cf0775099845b9e403fbbe267153b.jpg"
             alt="Cuidado del cabello 2" loading="lazy">

        <img class="category-slide"
             src="https://i.pinimg.com/736x/8f/9b/0d/8f9b0d28097c14223454723ad03aa817.jpg"
             alt="Productos capilares 3" loading="lazy">

        <img class="category-slide"
             src="https://i.pinimg.com/736x/27/10/2f/27102f02e44820e7542253fe8b225b78.jpg"
             alt="Rutina para el cabello 4" loading="lazy">

        <img class="category-slide"
             src="https://i.pinimg.com/736x/c4/10/64/c41064ddf3985794a84981276c28f066.jpg"
             alt="Cuidado capilar 5" loading="lazy">

             <img class="category-slide"
             src="https://i.pinimg.com/1200x/e3/5f/e9/e35fe926ae9ec49a1de2d3c84350d625.jpg"
             alt="Cuidado capilar 5" loading="lazy">

    </div>

    <div class="carousel-dots" aria-hidden="true"></div>

    <div class="category-overlay">
        <span>01 · Cuidado capilar</span>
        <h3>Haircare</h3>
        <p>Un ritual de cuidado y cariño para tu cabello.</p>
    </div>
</article>

<!-- CAJA DERECHA: SKINCARE, CARRUSEL DE 7 IMÁGENES -->

<article class="category-card carousel" aria-label="Carrusel de skincare">
    <div class="category-slides">
        <img class="category-slide active"
             src="https://i.pinimg.com/736x/45/22/c0/4522c0094a1f9d092b33a3d692466795.jpg"
             alt="Cuidado facial 1" loading="lazy">

        <img class="category-slide"
             src="https://i.pinimg.com/736x/82/8a/7e/828a7eb3fb5f4177b08d654478320f84.jpg"
             alt="Productos de cuidado facial 2" loading="lazy">

        <img    class="category-slide"
                src="./imagenes/chatimg.png"
               alt="Cosméticos de cuidado facial 3 " loading="lazy">
            >

         <img    class="category-slide"
                src="./imagenes/pppp.png"
               alt="Cosméticos de cuidado facial 4" loading="lazy">


        <img class="category-slide"
             src="https://i.pinimg.com/736x/6a/78/d2/6a78d29eaa12b163a1c1963f203e99b1.jpg"
             alt="Productos para la piel 5" loading="lazy">

       <img    class="category-slide"
                src="./imagenes/kkpis.png"
               alt="Cosméticos de cuidado facial 6" loading="lazy">
            >

    </div>

    <div class="carousel-dots" aria-hidden="true"></div>

    <div class="category-overlay">
        <span>02 · Cuidado facial</span>
        <h3>Skincare</h3>
        <p>Detalles que acompañan tu rutina de cuidado para la piel.</p>
    </div>
</article>

        </div>
    </div>
</section>


<!-- VALORES -->

<section class="values" id="valores">
    <div class="container">
        <div class="section-title">
            <small>La experiencia DIVINE</small>
            <h2>Más que productos, momentos de cuidado</h2>
            <p>
                Nuestra marca busca acompañar a las personas en la
                construcción de sus propias rutinas de belleza.
            </p>
        </div>

        <div class="values-grid">
            <article class="value-item">
                <div class="value-number">01</div>
                <h3>Bienestar</h3>
                <p>Un espacio para dedicarte tiempo y cuidar de ti.</p>
            </article>

            <article class="value-item">
                <div class="value-number">02</div>
                <h3>Variedad</h3>
                <p>Diferentes categorías relacionadas con la piel y el cabello.</p>
            </article>

            <article class="value-item">
                <div class="value-number">03</div>
                <h3>Inspiración</h3>
                <p>Ideas para incorporar el cuidado personal a tu día.</p>
            </article>

            <article class="value-item">
                <div class="value-number">04</div>
                <h3>Cercanía</h3>
                <p>Atención orientada a las necesidades de nuestros clientes.</p>
            </article>
        </div>
    </div>
</section>


<!-- EXPERIENCIA DIVINE -->

<section class="experience" id="experiencia">
    <div class="container">
        <div class="experience-box">
            <div>
                <span class="eyebrow">Un momento para ti</span>

                <h2>Haz del cuidado personal un hábito especial.</h2>

                <p>
                   En DIVINE creemos que cada opinión es una oportunidad para mejorar. Queremos conocer tu experiencia, escuchar tus sugerencias y saber qué te gustaría encontrar en nuestro emprendimiento.

Este espacio está pensado para que puedas compartir tus comentarios de manera privada, expresar tus ideas y ayudarnos a ofrecer una mejor experiencia en el cuidado de la piel y el cabello.
                </p>

                <p>
                    Tu voz es importante para nosotros
                </p>

                <a href="#contacto" class="btn btn-primary">
                    Escríbenos
                </a>
            </div>

            <div>
                <ul class="experience-list">
                    <li>Comparte tus sugerencias para mejorar DIVINE.</li>
                    <li>Cuéntanos qué productos o novedades te gustaría encontrar.</li>
                    <li>Expresa tus dudas, ideas o recomendaciones.</li>
                    <li>Ayúdanos a crear una experiencia cada vez mejor para nuestros clientes.</li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- CONTACTO Y COMENTARIOS -->

<section class="contact" id="contacto">
    <div class="container">
        <div class="section-title">
            <small>Estamos para escucharte</small>
            <h2>Conectemos</h2>
            <p>
                Queremos conocer tu opinión y ayudarte a descubrir más
                sobre DIVINE y nuestra propuesta de belleza.
            </p>
        </div>

        <div class="contact-box">
            <div class="contact-info">
                <h2>Hablemos de belleza.</h2>

                <p>
                    Tu opinión es importante para nosotros. Será un gusto
                    recibir tus consultas y comentarios.
                </p>

                <div class="contact-item">
                    <div class="contact-icon">⌂</div>
                    <div>
                        <strong>Nuestra ubicación</strong>
                        <span>Cochabamba, Bolivia</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">✦</div>
                    <div>
                        <strong>Nuestro emprendimiento</strong>
                        <span>DIVINE · Beauty Store</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">♡</div>
                    <div>
                        <strong>Áreas de cuidado</strong>
                        <span>Skincare · Haircare · Belleza personal</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">✉</div>
                    <div>
                        <strong>Tu opinión cuenta</strong>
                        <span>Déjanos un comentario en el formulario.</span>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h3>Déjanos tu comentario</h3>

                <p>
                    Cuéntanos qué piensas sobre DIVINE. Completa los
                    campos para enviar tu mensaje.
                </p>

                <form id="formComentario" action="comentar.php" method="POST">
                    <div class="field">
                        <label for="autor">Nombre</label>

                        <input
                            type="text"
                            id="autor"
                            name="autor"
                            placeholder="Escribe tu nombre"
                            autocomplete="name"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="contenido">Comentario</label>

                        <textarea
                            id="contenido"
                            name="contenido"
                            placeholder="Escribe tu opinión..."
                            maxlength="2000"
                            required
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Enviar comentario
                    </button>
                </form>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
                    <a href="comentar.php" class="admin-link">
                        Ver comentarios recibidos
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<!-- PIE DE PÁGINA -->

<footer>
    <div class="footer-container">
        <div class="footer-logo">DIVINE<span>.</span></div>

        <p class="footer-text">
            Un emprendimiento boliviano dedicado al cuidado facial,
            capilar y la belleza personal. Queremos acompañarte a
            descubrir una forma especial de cuidar de ti.
        </p>
    </div>

    <div class="copyright">
        © <?php echo date("Y"); ?> DIVINE · Beauty Store ·
        Cochabamba, Bolivia. Todos los derechos reservados.
    </div>
</footer>


<!-- JAVASCRIPT, VALIDACIÓN Y CARRUSELES -->

<script>
function divineAlert(icono, titulo, mensaje) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: mensaje,
        confirmButtonText: "Aceptar",

        customClass: {
            popup: "divine-alert",
            title: "divine-title",
            htmlContainer: "divine-text",
            confirmButton: "divine-confirm"
        },

        buttonsStyling: false
    });
}

$(document).ready(function () {

    /* Validación del formulario de comentarios */

    $("#formComentario").validate({
        rules: {
            autor: {
                required: true,
                minlength: 2,
                maxlength: 100
            },

            contenido: {
                required: true,
                minlength: 2,
                maxlength: 2000
            }
        },

        messages: {
            autor: {
                required: "Por favor, escribe tu nombre.",
                minlength: "El nombre debe tener al menos 2 caracteres.",
                maxlength: "El nombre no puede superar los 100 caracteres."
            },

            contenido: {
                required: "Por favor, escribe tu comentario.",
                minlength: "El comentario debe tener al menos 2 caracteres.",
                maxlength: "El comentario no puede superar los 2000 caracteres."
            }
        },

        errorElement: "label",
        errorClass: "label-error",

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        onkeyup: function (element) {
            $(element).valid();
        },

        onfocusout: function (element) {
            $(element).valid();
        },

        submitHandler: function (form) {
            form.submit();
        }
    });


    /*
       SOLO LAS CAJAS LATERALES SON CARRUSELES.
       La caja central no tiene la clase .carousel y permanece estática.
       Cada carrusel cambia cada 1500 milisegundos = 1,5 segundos.
    */

    document.querySelectorAll(".carousel").forEach(function (carrusel) {

        const imagenes = Array.from(
            carrusel.querySelectorAll(".category-slide")
        );

        const puntos = carrusel.querySelector(".carousel-dots");

        let indice = 0;

        if (imagenes.length === 0 || !puntos) {
            return;
        }

        /* Crear los pequeños indicadores de imágenes */

        imagenes.forEach(function (imagen, i) {
            const punto = document.createElement("span");

            punto.className =
                "carousel-dot" + (i === 0 ? " active" : "");

            puntos.appendChild(punto);
        });

        const indicadores = Array.from(
            puntos.querySelectorAll(".carousel-dot")
        );

        /* Mostrar la siguiente imagen */

        function mostrarImagen(n) {
            imagenes[indice].classList.remove("active");
            indicadores[indice].classList.remove("active");

            indice = (n + imagenes.length) % imagenes.length;

            imagenes[indice].classList.add("active");
            indicadores[indice].classList.add("active");
        }

        /* Iniciar el carrusel rápido */

        let temporizador = setInterval(function () {
            mostrarImagen(indice + 1);
        }, 1500);

        /* Pausar cuando el cursor esté sobre la caja */

        carrusel.addEventListener("mouseenter", function () {
            clearInterval(temporizador);
        });

        /* Reanudar cuando el cursor salga */

        carrusel.addEventListener("mouseleave", function () {
            clearInterval(temporizador);

            temporizador = setInterval(function () {
                mostrarImagen(indice + 1);
            }, 1500);
        });

    });
});


/* ALERTAS DE RESPUESTA DEL FORMULARIO */

<?php if (isset($_GET['comentario']) && $_GET['comentario'] === 'ok'): ?>

document.addEventListener("DOMContentLoaded", function () {
    divineAlert(
        "success",
        "¡Gracias por tu opinión!",
        "Tu comentario fue enviado correctamente. Solo el administrador puede ver los comentarios."
    );
});

<?php endif; ?>


<?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>

document.addEventListener("DOMContentLoaded", function () {
    divineAlert(
        "warning",
        "Campos incompletos",
        "Por favor, completa tu nombre y tu comentario."
    );
});

<?php endif; ?>


<?php if (isset($_GET['error']) && $_GET['error'] === '2'): ?>

document.addEventListener("DOMContentLoaded", function () {
    divineAlert(
        "error",
        "No se pudo guardar",
        "No se pudo guardar tu comentario. Inténtalo nuevamente."
    );
});

<?php endif; ?>
</script>

</body>
</html>
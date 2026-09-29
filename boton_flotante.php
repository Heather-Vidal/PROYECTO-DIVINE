<style>

/* =====================================================
   BOTÓN VOLVER DIVINE
   ===================================================== */

.divine-back {
    position: fixed;
    left: 28px;
    bottom: 28px;

    width: 58px;
    height: 58px;

    border: none;
    border-radius: 50%;

    background: linear-gradient(
        145deg,
        #a96f87,
        #925f76
    );

    color: #fff8fa;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
    z-index: 99999;

    box-shadow:
        0 8px 20px rgba(115, 65, 84, 0.22),
        inset 0 1px 3px rgba(255,255,255,0.35);

    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease,
        background 0.35s ease;
}


/* =====================================================
   CORAZÓN
   ===================================================== */

.divine-back-heart {
    width: 27px;
    height: 27px;

    fill: none;
    stroke: #fff8fa;

    stroke-width: 1.8;

    stroke-linecap: round;
    stroke-linejoin: round;

    transition:
        transform 0.35s ease,
        fill 0.35s ease,
        stroke-width 0.35s ease;
}


/* =====================================================
   FLECHA DEBAJO DEL CÍRCULO
   ===================================================== */

.divine-back-arrow {
    position: absolute;

    top: 56px;
    left: 50%;

    transform: translateX(-50%);

    color: #925f76;

    font-family: Arial, sans-serif;

    font-size: 31px;
    font-weight: 700;

    line-height: 1;

    text-shadow:
        0 1px 1px rgba(146, 95, 118, 0.15);

    transition:
        transform 0.3s ease,
        color 0.3s ease;
}


/* =====================================================
   HOVER DEL CÍRCULO
   ===================================================== */

.divine-back:hover {
    transform: translateY(-5px) scale(1.07);

    background: linear-gradient(
        145deg,
        #b67d93,
        #9c667e
    );

    box-shadow:
        0 13px 28px rgba(115, 65, 84, 0.30),
        inset 0 1px 3px rgba(255,255,255,0.45);
}


/* =====================================================
   CORAZÓN AL PASAR EL MOUSE
   ===================================================== */

.divine-back:hover .divine-back-heart {
    transform: scale(1.13);

    fill: rgba(255, 245, 248, 0.22);

    stroke-width: 2;
}


/* =====================================================
   FLECHA AL PASAR EL MOUSE
   ===================================================== */

.divine-back:hover .divine-back-arrow {
    transform: translateX(-55%);

    color: #925f76;
}


/* =====================================================
   TEXTO "VOLVER"
   ===================================================== */

.divine-back-text {
    position: absolute;

    top: 88px;
    left: 50%;

    transform:
        translateX(-50%)
        translateY(-5px);

    color: #925f76;

    font-family: "Poppins", Arial, sans-serif;

    font-size: 12px;
    font-weight: 500;

    letter-spacing: 0.4px;

    white-space: nowrap;

    opacity: 0;
    visibility: hidden;

    transition:
        opacity 0.3s ease,
        transform 0.3s ease;
}


/* =====================================================
   MOSTRAR "VOLVER"
   ===================================================== */

.divine-back:hover .divine-back-text {
    opacity: 1;
    visibility: visible;

    transform:
        translateX(-50%)
        translateY(0);
}


/* =====================================================
   CLICK
   ===================================================== */

.divine-back:active {
    transform: scale(0.93);
}


/* =====================================================
   CELULAR
   ===================================================== */

@media (max-width: 600px) {

    .divine-back {
        width: 52px;
        height: 52px;

        left: 18px;
        bottom: 18px;
    }


    .divine-back-heart {
        width: 24px;
        height: 24px;
    }


    .divine-back-arrow {
        top: 51px;

        font-size: 27px;
        font-weight: 700;
    }


    .divine-back-text {
        top: 79px;

        font-size: 11px;
    }

}

</style>


<!-- =====================================================
     BOTÓN VOLVER DIVINE
     ===================================================== -->

<button
    type="button"
    class="divine-back"
    onclick="history.back()"
    aria-label="Volver"
    title="Volver"
>


    <!-- =================================================
         CORAZÓN
         ================================================= -->

    <svg
        class="divine-back-heart"
        viewBox="0 0 24 24"
        aria-hidden="true"
    >

        <path
            d="M20.84 8.61
               C20.84 13.42 12 19 12 19
               S3.16 13.42 3.16 8.61
               C3.16 6.12 5.13 4.5 7.35 4.5
               C9.05 4.5 10.56 5.43 12 7.12
               C13.44 5.43 14.95 4.5 16.65 4.5
               C18.87 4.5 20.84 6.12 20.84 8.61Z"
        />

    </svg>


    <!-- =================================================
         FLECHA HACIA LA IZQUIERDA
         ================================================= -->

    <span class="divine-back-arrow">
        ←
    </span>


    <!-- =================================================
         TEXTO
         ================================================= -->

    <span class="divine-back-text">
        Volver
    </span>


</button>
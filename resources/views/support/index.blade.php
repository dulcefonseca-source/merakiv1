@extends('layouts.app')

@section('title', 'Soporte técnico')

@section('page-title', 'Centro de soporte')

@section('content')

@php
    $whatsappMessage = rawurlencode('Hola, necesito asistencia con Meraki Signature. ¿Podrían ayudarme?');
    $whatsappUrl = 'https://wa.me/50256935792?text=' . $whatsappMessage;

    $supportTopics = [
        [
            'title' => 'Agenda y citas',
            'icon' => 'bi-calendar2-check',
            'description' => 'Organización de citas, horarios, estados y seguimiento de reservas.',
        ],
        [
            'title' => 'Clientas',
            'icon' => 'bi-people',
            'description' => 'Registro, actualización y consulta de la información de tus clientas.',
        ],
        [
            'title' => 'Pagos y recibos',
            'icon' => 'bi-credit-card',
            'description' => 'Registro de abonos, saldos pendientes y comprobantes de pago.',
        ],
        [
            'title' => 'Servicios',
            'icon' => 'bi-stars',
            'description' => 'Administración de servicios, precios, duración y disponibilidad.',
        ],
        [
            'title' => 'Reportes',
            'icon' => 'bi-graph-up',
            'description' => 'Consulta de ingresos, citas, servicios y actividad de clientas.',
        ],
        [
            'title' => 'Configuración',
            'icon' => 'bi-sliders',
            'description' => 'Datos del estudio, información de contacto, identidad y perfil.',
        ],
    ];
@endphp

<style>

    .support-page {

        --support-ink: #403735;

        --support-muted: #8b7d78;

        --support-line: #eee6e1;

        --support-rose: #a97878;

        color: var(--support-ink);

    }

    .support-intro {

        position: relative;

        overflow: hidden;

        padding: 34px 38px;

        border: 1px solid #eee5df;

        border-radius: 20px;

        background: linear-gradient(115deg, #fbf7f3 0%, #f7efeb 58%, #f3e8e4 100%);

    }

    .support-intro::after {

        content: '?';

        position: absolute;

        right: 35px;

        top: -35px;

        color: rgba(169, 120, 120, .09);

        font-family: Georgia, serif;

        font-size: 230px;

        line-height: 1;

        pointer-events: none;

    }

    .support-eyebrow {

        margin-bottom: 10px;

        color: var(--support-rose);

        font-size: .7rem;

        font-weight: 700;

        letter-spacing: .19em;

        text-transform: uppercase;

    }

    .support-heading {

        position: relative;

        z-index: 1;

        margin: 0 0 10px;

        color: #493d3a;

        font-family: Georgia, 'Times New Roman', serif;

        font-size: clamp(1.8rem, 3vw, 2.45rem);

        font-weight: 400;

    }

    .support-description {

        position: relative;

        z-index: 1;

        max-width: 570px;

        margin: 0;

        color: #796d68;

        font-size: .94rem;

        line-height: 1.8;

    }

    .support-section-title {

        margin: 0 0 6px;

        color: #493d3a;

        font-family: Georgia, 'Times New Roman', serif;

        font-size: 1.45rem;

        font-weight: 400;

    }

    .support-section-subtitle {

        margin: 0;

        color: var(--support-muted);

        font-size: .86rem;

    }

    .support-topic {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        height: 100%;
        padding: 20px;
        border: 1px solid var(--support-line);
        border-radius: 15px;
        background: #fff;
        color: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .support-topic:hover {
        transform: translateY(-2px);
        border-color: #d9c4bf;
        background: #fffdfc;
        box-shadow: 0 9px 22px rgba(94, 67, 60, .07);
        color: inherit;
    }

    .support-topic:focus-visible {
        outline: 3px solid rgba(169, 120, 120, .28);
        outline-offset: 3px;
    }

    .support-topic-content {
        flex: 1;
        min-width: 0;
    }

    .support-topic-arrow {
        align-self: center;
        flex: 0 0 auto;
        margin-left: auto;
        color: #b18b83;
        font-size: .9rem;
        transition: transform .2s ease, color .2s ease;
    }

    .support-topic:hover .support-topic-arrow {
        transform: translate(2px, -2px);
        color: #946b67;
    }

    .support-topic-icon {

        display: grid;

        flex: 0 0 42px;

        width: 42px;

        height: 42px;

        place-items: center;

        border-radius: 13px;

        background: #f7efec;

        color: var(--support-rose);

        font-size: 1.1rem;

    }

    .support-topic h3 {

        margin: 1px 0 6px;

        color: #514541;

        font-size: .94rem;

        font-weight: 650;

    }

    .support-topic p {

        margin: 0;

        color: #8b7d78;

        font-size: .81rem;

        line-height: 1.65;

    }

    .support-contact {

        height: 100%;

        padding: 27px;

        border: 1px solid #eaded9;

        border-radius: 18px;

        background: #fbf7f4;

    }

    .support-contact-icon {

        display: grid;

        width: 48px;

        height: 48px;

        margin-bottom: 17px;

        place-items: center;

        border-radius: 15px;

        background: #efe3df;

        color: #98716f;

        font-size: 1.3rem;

    }

    .support-contact h3 {

        margin-bottom: 8px;

        color: #493d3a;

        font-family: Georgia, 'Times New Roman', serif;

        font-size: 1.45rem;

        font-weight: 400;

    }

    .support-contact p {

        color: #81736e;

        font-size: .87rem;

        line-height: 1.7;

    }

    .btn-support {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 9px;

        padding: 11px 18px;

        border: 1px solid #98716f;

        border-radius: 9px;

        background: #98716f;

        color: #fff;

        font-size: .84rem;

        font-weight: 600;

        text-decoration: none;

        transition: background .2s ease, border-color .2s ease;

    }

    .btn-support:hover {

        border-color: #805d5b;

        background: #805d5b;

        color: #fff;

    }

    .support-faq .accordion-item {

        overflow: hidden;

        margin-bottom: 10px;

        border: 1px solid var(--support-line);

        border-radius: 12px !important;

        background: #fff;

    }

    .support-faq .accordion-button {

        padding: 17px 19px;

        background: #fff;

        color: #514541;

        font-size: .9rem;

        font-weight: 600;

        box-shadow: none;

    }

    .support-faq .accordion-button:not(.collapsed) {

        background: #fcf8f6;

        color: #98716f;

    }

    .support-faq .accordion-button::after {

        opacity: .65;

    }

    .support-faq .accordion-body {

        padding: 0 19px 18px;

        color: #817570;

        font-size: .86rem;

        line-height: 1.75;

    }

    .support-note {

        padding: 15px 18px;

        border-left: 3px solid #c9aaa2;

        border-radius: 0 10px 10px 0;

        background: #faf6f3;

        color: #827570;

        font-size: .82rem;

        line-height: 1.7;

    }

    @media (max-width: 767.98px) {

        .support-intro { padding: 27px 23px; }

        .support-intro::after { right: 8px; font-size: 170px; }

        .support-contact { padding: 23px; }

    }

</style>

<div class="support-page">

    <section class="support-intro mb-4">

        <div class="support-eyebrow">Meraki Signature · Asistencia</div>

        <h1 class="support-heading">Estamos aquí para ayudarte.</h1>

        <p class="support-description">

            Encuentra orientación para utilizar Meraki Signature y mantener organizada

            la administración de tu estudio. Si necesitas ayuda adicional, puedes

            comunicarte directamente con soporte.

        </p>

    </section>

    <section class="mb-4">

        <div class="mb-3">

            <h2 class="support-section-title">¿Con qué necesitas ayuda?</h2>

            <p class="support-section-subtitle">Selecciona el tema relacionado con tu consulta.</p>

        </div>

        <div class="row g-3">
            @foreach ($supportTopics as $topic)
                @php
                    $topicMessage = 'Hola, necesito ayuda con el módulo ' . $topic['title']
                        . ' de Meraki Signature. ¿Podrían orientarme, por favor?';
                    $topicWhatsAppUrl = 'https://wa.me/50256935792?text=' . rawurlencode($topicMessage);
                @endphp

                <div class="col-md-6 col-xl-4">
                    <a
                        href="{{ $topicWhatsAppUrl }}"
                        class="support-topic"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Solicitar soporte sobre {{ $topic['title'] }} por WhatsApp"
                    >
                        <div class="support-topic-icon">
                            <i class="bi {{ $topic['icon'] }}"></i>
                        </div>

                        <div class="support-topic-content">
                            <h3>{{ $topic['title'] }}</h3>
                            <p>{{ $topic['description'] }}</p>
                        </div>

                        <span class="support-topic-arrow" aria-hidden="true">
                            <i class="bi bi-arrow-up-right"></i>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>

    </section>

    <div class="row g-4 mb-4">

        <div class="col-lg-7">

            <section>

                <div class="mb-3">

                    <h2 class="support-section-title">Preguntas frecuentes</h2>

                    <p class="support-section-subtitle">Respuestas rápidas a algunas consultas comunes.</p>

                </div>

                <div class="accordion support-faq" id="supportFaq">

                    <div class="accordion-item">

                        <h3 class="accordion-header" id="faqHeadingOne">

                            <button class="accordion-button collapsed" type="button"

                                data-bs-toggle="collapse" data-bs-target="#faqOne"

                                aria-expanded="false" aria-controls="faqOne">

                                ¿Cómo registro una nueva cita?

                            </button>

                        </h3>

                        <div id="faqOne" class="accordion-collapse collapse"

                            aria-labelledby="faqHeadingOne" data-bs-parent="#supportFaq">

                            <div class="accordion-body">

                                Ingresa al módulo Agenda y selecciona la opción para crear una cita.

                                Completa los datos de la clienta, el servicio, la fecha y la hora,

                                y guarda el registro.

                            </div>

                        </div>

                    </div>

                    <div class="accordion-item">

                        <h3 class="accordion-header" id="faqHeadingTwo">

                            <button class="accordion-button collapsed" type="button"

                                data-bs-toggle="collapse" data-bs-target="#faqTwo"

                                aria-expanded="false" aria-controls="faqTwo">

                                ¿Cómo registro un abono de una clienta?

                            </button>

                        </h3>

                        <div id="faqTwo" class="accordion-collapse collapse"

                            aria-labelledby="faqHeadingTwo" data-bs-parent="#supportFaq">

                            <div class="accordion-body">

                                Abre la cita correspondiente y utiliza la sección de pagos para

                                registrar el monto recibido. El sistema actualizará el saldo pendiente.

                            </div>

                        </div>

                    </div>

                    <div class="accordion-item">

                        <h3 class="accordion-header" id="faqHeadingThree">

                            <button class="accordion-button collapsed" type="button"

                                data-bs-toggle="collapse" data-bs-target="#faqThree"

                                aria-expanded="false" aria-controls="faqThree">

                                ¿Dónde puedo consultar los ingresos del estudio?

                            </button>

                        </h3>

                        <div id="faqThree" class="accordion-collapse collapse"

                            aria-labelledby="faqHeadingThree" data-bs-parent="#supportFaq">

                            <div class="accordion-body">

                                Dirígete al módulo Reportes y selecciona el reporte de ingresos

                                para consultar la información disponible.

                            </div>

                        </div>

                    </div>

                    <div class="accordion-item">

                        <h3 class="accordion-header" id="faqHeadingFour">

                            <button class="accordion-button collapsed" type="button"

                                data-bs-toggle="collapse" data-bs-target="#faqFour"

                                aria-expanded="false" aria-controls="faqFour">

                                ¿Cómo actualizo los datos del estudio?

                            </button>

                        </h3>

                        <div id="faqFour" class="accordion-collapse collapse"

                            aria-labelledby="faqHeadingFour" data-bs-parent="#supportFaq">

                            <div class="accordion-body">

                                Entra en Administración del estudio para editar la información

                                general y los datos de contacto que aparecen en el sistema.

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        <div class="col-lg-5">

            <aside class="support-contact">

                <div class="support-contact-icon"><i class="bi bi-chat-dots"></i></div>

                <div class="support-eyebrow">Atención directa</div>

                <h3>¿Necesitas asistencia personalizada?</h3>

                <p>

                    Si no encontraste la respuesta que buscabas o tienes algún inconveniente

                    con el sistema, escríbenos por WhatsApp. Cuéntanos qué sucede y, si es

                    posible, adjunta una captura de pantalla.

                </p>

                <a href="{{ $whatsappUrl }}" class="btn-support" target="_blank" rel="noopener noreferrer">

                    <i class="bi bi-whatsapp"></i>

                    Contactar soporte

                </a>

            </aside>

        </div>

    </div>

    <div class="support-note">

        <i class="bi bi-info-circle me-1"></i>

        Para recibir ayuda más rápido, indica qué estabas haciendo cuando apareció el inconveniente

        y comparte el mensaje de error si se muestra alguno.

    </div>

</div>

@endsection

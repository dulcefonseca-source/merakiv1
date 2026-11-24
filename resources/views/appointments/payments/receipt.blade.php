
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprobante de pago | Meraki Estudio de Belleza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        :root {
            --primary: #BD8980;
            --primary-dark: #A96F68;
            --rose: #F7E9E8;
            --champagne: #D5B69C;
            --ivory: #FBF9F7;
            --text: #55464A;
            --muted: #9C8D91;
            --border: #EFE6E5;
            --success: #6E9B7B;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--ivory);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            padding: 35px 15px;
        }

        .receipt {
            max-width: 720px;
            margin: auto;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(85, 70, 74, .07);
        }

        .receipt-header {
            text-align: center;
            padding: 38px 35px 30px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, #fff 0%, #FFFCFB 100%);
        }

        .brand-logo {
            width: 115px;
            height: auto;
            max-height: 100px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 35px;
            letter-spacing: 5px;
            color: var(--primary-dark);
        }

        .brand-subtitle {
            font-size: 10px;
            letter-spacing: 4px;
            color: var(--muted);
            margin-top: 3px;
        }

        .receipt-heading {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            margin-top: 27px;
            margin-bottom: 5px;
        }

        .receipt-number {
            color: var(--muted);
            font-size: 12px;
        }

        .paid-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #EDF5EF;
            color: #527E60;
            border: 1px solid #D8E9DC;
            border-radius: 30px;
            padding: 8px 17px;
            margin-top: 18px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .receipt-body {
            padding: 32px 35px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            margin-bottom: 14px;
            color: var(--text);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .detail-label {
            color: var(--muted);
        }

        .detail-value {
            font-weight: 600;
            text-align: right;
        }

        .service-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 13px 0;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
        }

        .service-name {
            font-weight: 600;
        }

        .service-category {
            color: var(--muted);
            font-size: 11px;
            margin-top: 3px;
        }

        .payment-highlight {
            background: var(--rose);
            border: 1px solid #F0DAD8;
            border-radius: 14px;
            padding: 27px 20px;
            text-align: center;
            margin: 28px 0 20px;
        }

        .payment-highlight small {
            color: var(--primary-dark);
            letter-spacing: 2px;
            font-size: 10px;
            font-weight: 700;
        }

        .payment-highlight h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-dark);
            font-size: 38px;
            margin: 8px 0 0;
        }

        .payment-highlight p {
            font-size: 11px;
            color: var(--muted);
            margin: 7px 0 0;
        }

        .balance-box {
            background: var(--ivory);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 17px 20px;
            margin-top: 20px;
        }

        .balance-box .detail-row:last-child {
            border-bottom: none;
        }

        .balance-box .final-row {
            color: var(--success);
            font-weight: 700;
        }

        .receipt-footer {
            text-align: center;
            padding: 27px 35px 35px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            color: var(--primary-dark);
            font-size: 19px;
            margin-bottom: 5px;
        }

        .footer-message {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-style: italic;
            margin-top: 12px;
        }

        .receipt-actions {
            max-width: 720px;
            margin: 22px auto;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-meraki {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 9px;
            padding: 12px 21px;
            font-size: 13px;
        }

        .btn-meraki:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-light-meraki {
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 12px 21px;
            font-size: 13px;
        }

        @media print {
            @page {
                size: A5 portrait;
                margin: 8mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                border: 1px solid var(--border);
                max-width: 100%;
                width: 100%;
                border-radius: 10px;
            }

            .receipt-actions {
                display: none !important;
            }
        }

        @media(max-width: 576px) {
            .receipt-header,
            .receipt-body,
            .receipt-footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .detail-row,
            .service-row {
                font-size: 12px;
            }

            .payment-highlight h2 {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

<div class="receipt">

    <header class="receipt-header">

        <img
            src="{{ asset('images/meraki-logo.png') }}"
            alt="Meraki Estudio de Belleza"
            class="brand-logo"
            onerror="this.style.display='none'"
        >

        <div class="brand">MERAKI</div>
        <div class="brand-subtitle">ESTUDIO DE BELLEZA</div>

        <h1 class="receipt-heading">Comprobante de pago</h1>

        <div class="receipt-number">
            Reserva No. {{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}
        </div>

        <div class="paid-badge">
            <i class="bi bi-check-circle-fill"></i>
            RESERVA PAGADA
        </div>

    </header>

    <main class="receipt-body">

        <!-- Información de la clienta -->
        <section class="mb-4">

            <h5 class="section-title">Información de la clienta</h5>

            <div class="detail-row">
                <span class="detail-label">Nombre</span>
                <span class="detail-value">
                    {{ $appointment->client->name }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Teléfono</span>
                <span class="detail-value">
                    {{ $appointment->client->phone ?: 'No registrado' }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Fecha de la cita</span>
                <span class="detail-value">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Fecha del comprobante</span>
                <span class="detail-value">
                    {{ now()->format('d/m/Y') }}
                </span>
            </div>

        </section>

        <!-- Servicios de la reserva -->
        <section class="mb-4">

            <h5 class="section-title">Servicios de la reserva</h5>

            @foreach($appointment->appointmentServices as $service)

                <div class="service-row">

                    <div>
                        <div class="service-name">
                            {{ $service->service_name }}
                        </div>

                        <div class="service-category">
                            {{ $service->category ?? 'Servicio' }}

                            @if($service->staff)
                                · {{ $service->staff->name }}
                            @endif
                        </div>
                    </div>

                    <strong>
                        Q{{ number_format($service->price ?? 0, 2) }}
                    </strong>

                </div>

            @endforeach

        </section>

        <!-- Resumen final de la reserva -->
        <section>

            <div class="payment-highlight">

                <small>TOTAL DE LA RESERVA</small>

                <h2>
                    Q{{ number_format($total, 2) }}
                </h2>

                <p>Importe total de los servicios reservados</p>

            </div>

            <div class="balance-box">

                <div class="detail-row">
                    <span class="detail-label">Total de la reserva</span>
                    <strong>
                        Q{{ number_format($total, 2) }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Total recibido</span>
                    <strong class="text-success">
                        Q{{ number_format($paid, 2) }}
                    </strong>
                </div>

                <div class="detail-row final-row">
                    <span>Saldo pendiente</span>
                    <strong>
                        Q{{ number_format($balance, 2) }}
                    </strong>
                </div>

            </div>

        </section>

    </main>

    <footer class="receipt-footer">

        <div class="footer-brand">
            Meraki Estudio de Belleza
        </div>

        Gracias por elegirnos y confiar en nuestro trabajo.

        <div class="footer-message">
            ¡Es un placer servirte!
        </div>

    </footer>

</div>

<div class="receipt-actions">

    <button onclick="window.print()" class="btn-meraki">
        <i class="bi bi-printer me-1"></i>
        Imprimir / Guardar PDF
    </button>

    <button onclick="downloadReceiptPNG()" class="btn-light-meraki">
        <i class="bi bi-image me-1"></i>
        Descargar PNG
    </button>

    <button onclick="window.close()" class="btn-light-meraki">
        Cerrar
    </button>

</div>

<script>
    async function downloadReceiptPNG() {
        const receipt = document.querySelector('.receipt');
        const button = document.querySelector('[onclick="downloadReceiptPNG()"]');

        if (typeof html2canvas === 'undefined') {
            alert('No se pudo cargar la herramienta para generar la imagen. Verifica tu conexión e inténtalo nuevamente.');
            return;
        }

        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Generando...';

        try {
            const canvas = await html2canvas(receipt, {
                scale: 3,
                backgroundColor: '#FFFFFF',
                useCORS: true,
                logging: false
            });

            const link = document.createElement('a');
            link.download = 'Comprobante-Meraki-{{ $appointment->id }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        } catch (error) {
            alert('No fue posible generar la imagen. Inténtalo nuevamente.');
        } finally {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }
</script>

</body>
</html>

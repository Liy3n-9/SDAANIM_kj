<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Revisada</title>
    <link rel="stylesheet" href="{{ asset('css/shared/email.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Actualización sobre tu solicitud</h1>
            <p>Esperanza Animal BQ</p>
        </div>

        <div class="content">
            <div class="greeting">
                <strong>Hola {{ $nombre }},</strong>
            </div>

            <div class="info-box info-box-rejected">
                <h3>Información sobre tu solicitud</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Después de una cuidadosa revisión, tu solicitud como {{ $rol }} ha sido <strong>rechazada</strong> en esta oportunidad.
                </p>
            </div>

            <div class="message-section">
                <h3>¿Qué pasó?</h3>
                <p class="message-text">
                    Revisamos cuidadosamente tu solicitud y consideramos que, en este momento, no se ajusta completamente a lo que estamos buscando en nuestro equipo.
                </p>
                <p class="message-text">
                    Esto no significa que no tengas el potencial para ser parte de nosotros. Te animamos a volver a postularte en el futuro o contactarnos si tienes preguntas al respecto.
                </p>
            </div>

            <div class="encouragement">
                <strong>🐾 No desistas</strong><br>
                La pasión por los animales es lo que nos une. Si tienes dudas sobre cómo mejorar tu solicitud, nos encantaría ayudarte. Contáctanos para conocer más opciones de colaboración.
            </div>

            <div class="contact-info">
                <strong>📧 Contáctanos:</strong><br>
                Email: contacto@esperanzaanimalbq.com<br>
                Teléfono: +57 1 XXXX XXXX
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #888; line-height: 1.6;">
                <p>
                    Agradecemos sinceramente tu interés en ser parte de <strong>Esperanza Animal BQ</strong> y el tiempo que dedicaste a completar tu solicitud. 
                </p>
                <p style="margin-top: 10px;">
                    Esperamos poder trabajar contigo en el futuro. 🤝
                </p>
            </div>
        </div>

        <div class="footer">
            <p>© 2025 Esperanza Animal BQ. Todos los derechos reservados.</p>
            <p>Estamos aquí para proteger y cuidar a nuestros peluditos con tu ayuda.</p>
        </div>
    </div>
</body>
</html>

// Variáveis globais
let countdown = 10;
let countdownElement;
let timer;
let userInteracted = false;

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    initializeParticles();
    initializeCountdown();
    setupUserInteractionListeners();
});

/**
 * Criar partículas de fundo animadas
 */
function initializeParticles() {
    const particles = document.getElementById('particles');
    
    if (!particles) return;
    
    // Criar 50 partículas com propriedades aleatórias
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        
        const size = 2 + Math.random() * 3;
        const opacity = 0.3 + Math.random() * 0.5;
        const left = Math.random() * 100;
        const top = Math.random() * 100;
        const duration = 3 + Math.random() * 4;
        
        particle.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: rgba(255,255,255,${opacity});
            border-radius: 50%;
            left: ${left}%;
            top: ${top}%;
            animation: float ${duration}s ease-in-out infinite;
        `;
        
        particles.appendChild(particle);
    }
}

/**
 * Inicializar contador regressivo para redirecionamento
 */
function initializeCountdown() {
    countdownElement = document.getElementById('countdown');
    
    if (!countdownElement) return;
    
    // Iniciar o timer
    timer = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;
        
        // Verificar se chegou a zero
        if (countdown <= 0) {
            clearInterval(timer);
            redirectToLogin();
        }
    }, 1000);
}

/**
 * Redirecionar para a página de login
 */
function redirectToLogin() {
    window.location.href = 'login.php';
}

/**
 * Pausar contador quando o usuário interagir com a página
 */
function pauseCountdown() {
    if (!userInteracted && timer) {
        clearInterval(timer);
        countdownElement.textContent = 'cancelado';
        userInteracted = true;
        
        // Mostrar mensagem visual de que o contador foi pausado
        showCountdownPausedMessage();
    }
}

/**
 * Mostrar mensagem de que o contador foi pausado
 */
function showCountdownPausedMessage() {
    const redirectInfo = document.querySelector('.redirect-info');
    if (redirectInfo) {
        const pausedMessage = document.createElement('p');
        pausedMessage.textContent = 'Redirecionamento automático cancelado.';
        pausedMessage.style.color = '#ffeb3b';
        pausedMessage.style.fontWeight = 'bold';
        pausedMessage.style.marginTop = '10px';
        redirectInfo.appendChild(pausedMessage);
    }
}

/**
 * Configurar listeners para interação do usuário
 */
function setupUserInteractionListeners() {
    // Pausar contador ao clicar em qualquer lugar
    document.addEventListener('click', pauseCountdown);
    
    // Pausar contador ao pressionar qualquer tecla
    document.addEventListener('keydown', pauseCountdown);
    
    // Pausar contador ao mover o mouse (opcional, mais sensível)
    // document.addEventListener('mousemove', pauseCountdown);
    
    // Pausar contador ao fazer scroll
    document.addEventListener('scroll', pauseCountdown);
    
    // Pausar contador ao tocar na tela (dispositivos touch)
    document.addEventListener('touchstart', pauseCountdown);
}

/**
 * Funções utilitárias para interação com botões
 */
function handleLoginRedirect() {
    if (timer) {
        clearInterval(timer);
    }
    window.location.href = 'login.php';
}

function handleHomeRedirect() {
    if (timer) {
        clearInterval(timer);
    }
    window.location.href = 'index.php';
}

/**
 * Função para limpar recursos quando a página for fechada
 */
window.addEventListener('beforeunload', function() {
    if (timer) {
        clearInterval(timer);
    }
});

/**
 * Função para pausar/resumir contador (para uso futuro)
 */
function toggleCountdown() {
    if (userInteracted) return;
    
    if (timer) {
        clearInterval(timer);
        timer = null;
        countdownElement.textContent = 'pausado';
    } else {
        initializeCountdown();
    }
}

/**
 * Resetar contador (para uso futuro)
 */
function resetCountdown() {
    if (timer) {
        clearInterval(timer);
    }
    countdown = 10;
    userInteracted = false;
    initializeCountdown();
}
<template>
    <li class="nav-item position-relative">
      <a class="nav-link chat-link" :href="chatRoute">
        <i class="fab fa-whatsapp chat-icon"></i>
        <span class="chat-text">{{ ('Chat') }}</span>
        <!-- Mostrar notificação somente se showNotification for true e unreadMessagesCount for maior que 0 -->
        <span v-if="showNotification && unreadMessagesCount > 0" class="notification-badge">@{{ unreadMessagesCount }}</span>
      </a>
    </li>
  </template>
  
  <script>
  import Echo from 'laravel-echo';
  export default {
    data() {
      return {
        unreadMessagesCount: 0,
        showNotification: false,
      };
    },
    computed: {
      chatRoute() {
        return '/chat'; // Rota para a página de chat
      },
      currentUserId() {
        return window.Laravel.userId; // Obtendo o userId do objeto global Laravel
      }
    },
    mounted() {
      if (this.currentUserId) {
        this.setupWebSocket();
      }
    },
    methods: {
      setupWebSocket() {
        if (window.Echo) {
          window.Echo.private(`user.${this.currentUserId}`)
            .listen('.SendMessage', (e) => {
              let messageData = JSON.parse(e.message);
              this.unreadMessagesCount++;
              this.showNotification = true;
              console.log(`Mensagem recebida de usuário: ${messageData.sender_id}`);
            });
        } else {
          console.error('Echo não está configurado.');
        }
      },
    },
    watch: {
      unreadMessagesCount(newCount) {
        this.showNotification = newCount > 0;
      }
    }
  }
  </script>
  
  <style scoped>
  .notification-badge {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 0.75rem;
    position: absolute;
    top: -10px;
    right: -10px;
  }
  
  .chat-link {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    background-color: #007bff; /* Cor de fundo azul */
    color: white; /* Cor do texto */
    border-radius: 4px;
    text-decoration: none;
    position: relative;
    transition: background-color 0.3s, box-shadow 0.3s;
  }
  
  .chat-link:hover {
    background-color: #0056b3; /* Cor de fundo ao passar o mouse */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra ao passar o mouse */
  }
  
  .chat-icon {
    margin-right: 8px;
    font-size: 1.25rem; /* Tamanho do ícone */
  }
  
  .chat-text {
    margin-left: 5px;
  }
  </style>
  
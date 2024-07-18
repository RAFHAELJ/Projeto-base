<template>
    <div class="chat-app">
        <div class="sidebar">
            <UserList :users="users" @userSelected="userSelected" />
        </div>
        <div class="chat-content">
            <ChatMessenger :selectedUser="selectedUser" @messageReceived="handleMessageReceived" />

        </div>
    </div>
</template>

<script>

import UserList from './UserList.vue';
import ChatMessenger from './ChatMessenger.vue';

export default {
    components: {
        UserList,
        ChatMessenger
    },
    data() {
        return {
            users: [],
            selectedUser: null
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await axios.get('/users');
                this.users = response.data;   

                // Fetch unread messages count for each user
                const fetchUnreadPromises = this.users.map(async user => {
                    const unreadCount = await this.fetchUnreadMessages(user.id);
                    this.$set(user, 'unreadCount', unreadCount);
                    this.$set(user, 'hasUnreadMessages', unreadCount > 0);
                    console.log('Usuários carregados:', this.users);
                });
                await Promise.all(fetchUnreadPromises);
               
            } catch (error) {
                console.log('Erro ao carregar usuários:', error);
            }
        },
        async fetchUnreadMessages(userId) {
            try {
                const response = await axios.get(`/messages/unread-count/${userId}`);                
                return response.data.unreadCount || 0;
            } catch (error) {
                console.error(`Error fetching unread messages for user ${userId}:`, error);
                return 0;
            }
        },
        userSelected(user) {
            this.selectedUser = user;
            console.log('Usuário selecionado:', user);
            this.refreshUserList();
        },
        handleMessageReceived(senderId) {
            console.log('Mensagem recebida do usuário:', senderId);
            const user = this.users.find(user => user.id === senderId);
            if (user) {
                user.unreadCount++;
                user.hasUnreadMessages = true;
            }
            this.refreshUserList();
        },
        async refreshUserList() {
            await this.fetchUsers();
        }
    }
};
</script>

<style scoped>
.chat-app {
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 40%;
    border-right: 1px solid #ccc;
}

.chat-content {
    width: 60%;
}
</style>

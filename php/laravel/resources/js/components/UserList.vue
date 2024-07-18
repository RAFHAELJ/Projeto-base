<template>
    <div class="user-list">
        <div v-for="user in users" :key="user.id" @click="selectUser(user)" class="user-item">
            <div class="user-card">
                <span>{{ user.name }}</span>
                <div v-if="user.hasUnreadMessages" class="unread-badge">
                    <span>{{ user.unreadCount }} </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['users'],
    methods: {
        selectUser(user) {
            this.$emit('userSelected', user);
        }
    }
};
</script>

<style scoped>
.user-list {
    width: 100%;
    height: 100%;
    overflow-y: auto;
    border-right: 1px solid #ccc;
}

.user-item {
    padding: 10px;
    cursor: pointer;
}

.user-item:hover {
    background-color: #f0f0f0;
}

.user-card {
    padding: 10px;
    border-radius: 10px;
    width: 70%;
    background-color: #ffffff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-card span {
    flex: 1;
}

.unread-badge {
    background-color: #78ff47;
   
    color: #ffffff;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 0.8em;
}
</style>

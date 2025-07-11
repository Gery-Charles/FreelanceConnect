import { defineStore } from 'pinia';

export const useConversationStore = defineStore('conversation', {
    state: () => ({
        conversations: [],
        selectedConversation: null,
    }),
    actions: {
        setConversations(conversations) {
            this.conversations = conversations;
        },
        selectConversation(conversation) {
            this.selectedConversation = conversation;
        },
    },
});

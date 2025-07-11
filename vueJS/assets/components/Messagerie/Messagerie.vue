<template>
  <div class="messagerie">
    <div class="conversations-pane">
      <ConversationList :user-id="userId" />
    </div>
    <div class="messages-pane" v-if="conversationStore.selectedConversation">
      <ListMessages
          :conversation-id="conversationStore.selectedConversation.id"
          :receveur-id="conversationStore.selectedConversation.destinataire.id"
      />
    </div>
  </div>
</template>

<script setup>
import { useConversationStore } from '../../stores/conversationStore';
import ConversationList from './ConversationList.vue';
import ListMessages from './ListMessages.vue';

const conversationStore = useConversationStore();

const props = defineProps({
  userId: [String, Number],
});
</script>

<style scoped>
.messagerie {
  display: flex;
  height: 100%;
  width: 100%;
}

.conversations-pane {
  width: 300px;
  border-right: 1px solid #ddd;
  background-color: #f4f4f4;
  overflow-y: auto;
}

.messages-pane {
  flex: 1;
  padding: 1rem;
  background-color: #fff;
}
</style>


<style scoped>
.messagerie {
  display: flex;
  height: 100%; /* Important pour qu'il remplisse le parent */
  width: 100%;
  overflow: hidden;
}

.conversations-pane {
  width: 300px;
  border-right: 1px solid #ddd;
  background-color: #f4f4f4;
  overflow-y: auto;
}

.messages-pane {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
  background-color: #fff;
}
</style>

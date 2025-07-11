<template>
  <div class="box">
    <h3>Conversations</h3>
    <ul class="conversation-list">
      <li
          v-for="conversation in conversationStore.conversations"
          :key="conversation.id"
          @click="conversationStore.selectConversation(conversation)"
          class="conversation-item cursor-pointer"
      >
        {{ conversation.destinataire.nom }} {{ conversation.destinataire.prenom }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { useConversationStore } from '../../stores/conversationStore';
import { onMounted } from 'vue';

const conversationStore = useConversationStore();

const props = defineProps({
  userId: [String, Number],
});

onMounted(() => {
  fetch('/api/conversations')
      .then((res) => res.json())
      .then((data) => {
        conversationStore.setConversations(data);
      });
});
</script>

<style scoped>
.conversation-item {
  border: solid 1px #2c2929;
  border-radius: 15px;
  padding: 8px;
  margin-bottom: 5px;
}
</style>

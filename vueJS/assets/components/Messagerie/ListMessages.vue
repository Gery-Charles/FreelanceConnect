<template>
  <div>
    <h4>Messages</h4>
    <div v-for="msg in messages" :key="msg.id">
      <strong>{{ msg.emetteur.nom }}:</strong> {{ msg.contenu }}
    </div>
    <form @submit.prevent="sendMessage">
      <input v-model="newMessage" placeholder="Votre message" />
      <button>Envoyer</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['conversationId', 'receveurId'],
  data() {
    return {
      messages: [],
      newMessage: ''
    };
  },
  watch: {
    conversationId: {
      immediate: true,
      handler(id) {
        if (id) {
          this.loadMessages(id);
        }
      }
    }
  },
  methods: {
    loadMessages(id) {
      fetch(`/api/conversations/${id}/messages`)
          .then(res => res.json())
          .then(data => this.messages = data);
    },
    sendMessage() {
      if (!this.newMessage || !this.receveurId) return;

      fetch('/api/messages', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          contenu: this.newMessage,
          receveur_id: this.receveurId
        })
      }).then(() => {
        this.newMessage = '';
        this.loadMessages(this.conversationId);
      });
    }
  }
};
</script>

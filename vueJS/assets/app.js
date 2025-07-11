import { createApp } from 'vue'
import { createPinia } from 'pinia';
import App from './App.vue'
import Messagerie from "./components/Messagerie/Messagerie.vue";
import MissionCarousel from './components/Profil/MissionCarousel.vue';

const pinia = createPinia();

const vueApp = document.getElementById('vue-app');
if (vueApp) {
    const app = createApp(App);
    app.mount('#vue-app');
}

const vueAppMessagerie = document.getElementById('vue-appMessagerie')
if (vueAppMessagerie) {
    const userId = vueAppMessagerie.dataset.userId;
    const appMessagerie = createApp(Messagerie, { userId });
    appMessagerie.use(pinia);
    appMessagerie.mount('#vue-appMessagerie');
}


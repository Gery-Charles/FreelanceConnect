<template>
  <section class="container">
    <div class="row">
      <div class="col-12">
        <MissionFiltres v-model:selectedCategory="selectedCategory" />
      </div>
    </div>
  </section>
  <br>
  <br>
  <br>
  <MissionList :selectedCategory="selectedCategory" />
</template>

<script>
import MissionFiltres from './MissionFiltres.vue';
import MissionList from './MissionList.vue';
import {defineComponent} from "vue";

export default defineComponent({
  components: {MissionFiltres, MissionList},

  data() {
    return {
      selectedCategory: '' // valeur initiale
    };
  }
})


</script>

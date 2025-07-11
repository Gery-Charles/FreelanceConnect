<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <section>
          <div class="row">
            <div
                v-for="mission in filteredMissions"
                :key="mission.id"
                class="col-6 col-12-small"
            >
              <MissionCard :mission="mission" />
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <v-infinite-scroll
      height="300"
      mode="manual"
      @load="load"
  >
    <template v-for="(item, index) in items" :key="item">
      <div :class="['px-2', index % 2 === 0 ? 'bg-grey-lighten-2' : '']">
        Item number {{ item }}
      </div>
    </template>
  </v-infinite-scroll>
</template>

<script>
import MissionCard from './MissionCard.vue';

export default {
  props: {
    selectedCategory: String // catégorie passée depuis le filtre
  },
  components: { MissionCard },
  data() {
    return {
      missions: []
    };
  },
  computed: {
    filteredMissions() {
      if (!this.selectedCategory) return this.missions;
      return this.missions.filter(m => m.categorie === this.selectedCategory);
    }
  },
  mounted() {
    fetch('/api/missions')
        .then(res => res.json())
        .then(data => {
          this.missions = data;
        });
  }
};
</script>

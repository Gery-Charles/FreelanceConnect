<template>

  <p>affichage des missions</p>
  <div v-if="missions.length" class="col-4 col-12-medium">
    <section class="first">
      <a
          class="image featured"
          :href="`/postuler/${currentMission.id}`"
      >
        <img
            :src="getImageSrc(currentMission)"
            :alt="`Image ${currentMission.titre}`"
        />
      </a>
      <header>
        <h3>{{ currentMission.titre }}</h3>
        <p>Publiée le {{ formatDate(currentMission.datePublication) }}</p>
      </header>
      <p>
        {{ currentMission.description.length > 30
          ? currentMission.description.substring(0, 30) + '...'
          : currentMission.description }}
      </p>
      <footer>
        <a
            :href="`/mission/${currentMission.id}`"
            class="button icon solid fa-file-alt"
        >
          En savoir plus
        </a>
      </footer>
      <div class="navigation">
        <button @click="prevMission" :disabled="index === 0">Précédent</button>
        <button @click="nextMission" :disabled="index === missions.length - 1">Suivant</button>
      </div>
    </section>
  </div>
</template>

<script>
</script>


<style scoped>
</style>

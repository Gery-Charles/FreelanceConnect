<template>
  <section class="box">
    <a class="image featured" :href="`/mission_n°${mission.id}/en-savoir-plus`">
      <img :src="getImageUrl(mission)" :alt="`Image ${mission.titre}`" />
    </a>
    <header>
      <h3>{{ mission.titre }}</h3>
      <p>Publiée le {{ formatDate(mission.datePublication) }}</p>
    </header>
    <p>
      {{ mission.description.length > 50
        ? mission.description.slice(0, 50) + '...'
        : mission.description }}
    </p>
    <footer>
      <a :href="`/mission_n°${mission.id}/en-savoir-plus`" class="button icon solid fa-file-alt">
        En savoir plus
      </a>
    </footer>
  </section>
</template>

<script>
export default {
  props: {
    mission: { type: Object, required: true }
  },
  methods: {
    getImageUrl(mission) {
      return mission.isImageUploaded
          ? `/uploads/images/${mission.imageName}`
          : `/images/${mission.imageName}`;
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return new Intl.DateTimeFormat('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date);
    }
  }
};
</script>

<template>
  <div>
    <label for="categorie">Catégorie :</label>
    <select id="categorie" v-model="category" @change="emitSelectedCategory">
      <option value="">-- Choisir une catégorie --</option>
      <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    selectedCategory: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      category: this.selectedCategory
    };
  },
  methods: {
    emitSelectedCategory() {
      this.$emit('update:selectedCategory', this.category);
    }
  },
  computed: {
    categories() {
      return [
        'site e-commerce',
        'application mobile',
        'logo professionnel',
        'stratégie SEO',
        'article de blog',
        'dashboard analytique'
      ];
    }
  }
};
</script>

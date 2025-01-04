<template>
  <div class="about">
    <h1>This is an about page Test</h1>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      data: null,
      error: null,
      loading: false
    };
  },
  methods: {
    fetchData() {
      this.loading = true;
      axios.get('http://localhost:8000/api/test')
        .then(response => {
          console.log('RESPONSE', response)
          this.data = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.log('RESPONSE', error)
          this.error = error.message;
          this.loading = false;
        });
    }
  },
  mounted() {
    this.fetchData();
  }
};
</script>

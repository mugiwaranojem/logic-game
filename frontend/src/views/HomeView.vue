<template>
  <div class="about">
    <div class="inner">
      <h1>Select your move</h1>
      <div class="choices">
        <button @click="executeMove('rock')" :disabled="loading">Rock</button>
        <button @click="executeMove('paper')" :disabled="loading">Paper</button>
        <button @click="executeMove('scissors')" :disabled="loading">Scissors</button>
        <div v-show="loading" class="loader spinner-border text-secondary" role="status"></div>
      </div>


      <div v-if="playerMove && !loading" class="results">
        <h3 v-show="result === 'win'" class="text-success">You Won</h3>
        <h3 v-show="result === 'lose'" class="text-danger">You Lose</h3>
        <h3 v-show="result === 'draw'" class="text-warning">Draw</h3>

        <p>Your Move: <strong>{{ playerMove }}</strong></p>
        <p>Computer Move: <strong>{{ computerMove }}</strong></p>
      </div>
    </div>
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
.choices {
  margin: 20px 0;
}

button {
  padding: 10px 20px;
  font-size: 18px;
  margin: 0 10px;
  cursor: pointer;
}

button:hover {
  background-color: #ddd;
}

.results {
  margin-top: 30px;
}
</style>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      data: null,
      error: null,
      loading: false,
      playerMove: null,
      computerMove: null,
      result: null,
    };
  },
  methods: {
    async fetchConfig() {
      await axios.get('http://localhost:8000/api/config')
        .then(response => {
          console.log('RESPONSE', response)
        })
        .catch(error => {
        });
    },
    async executeMove(move) {
      this.loading = true;
      this.playerMove = move;
      await axios.post('http://localhost:8000/api/execute', {move: this.playerMove})
        .then(response => {
          const { data } = response;
          console.log('data', data)
          this.data = data
          this.computerMove = data?.result.computer_move.name;
          this.result = data?.result.outcome;
          this.loading = false;
        })
        .catch(error => {
          this.error = error.message;
          this.loading = false;
        });
    },
  },
  mounted() {
    this.fetchConfig();
  }
};
</script>

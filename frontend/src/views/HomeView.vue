<template>
  <div class="about">
    <div class="inner">
      <div v-if="gameState === 'initial'" class="d-flex">
        <div class="loader spinner-border text-secondary" role="status"></div>
        <div class="mx-3">Preparing...</div>
      </div>
      <section v-else>
        <div v-for="player in players" class="mb-4">
          <PlayerMove :player="player" :gameConfig="gameConfig" :moveOptions="moveOptions" />
        </div>
      </section>
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
import axios from 'axios'
import PlayerMove from '@/components/PlayerMove.vue'

// can be done on ENV var
const API_URL = 'http://localhost:8000/api'

export default {
  components: {
    PlayerMove,
  },
  data() {
    return {
      data: null,
      loading: false,
      playerMove: null,
      computerMove: null,
      result: null,
      gameState: 'initial',
      gameConfig: {},
      moveOptions: [],
      currentRound: 1,
      playerWinCount: 0,
      computerWinCount: 0,
      drawCount: 0,
      analysing: false,
      players: [],
    }
  },
  methods: {
    async fetchConfig() {
      await axios.get(API_URL + '/config').then((response) => {
        const { data } = response
        this.gameConfig = data?.config
        const playerCount = parseInt(this.gameConfig?.players_count) - 1
        for (let i = 1; i <= playerCount; i++) {
          this.players.push(i)
        }
      })
    },
    async fetchMoves() {
      await axios.get(API_URL + '/moves').then((response) => {
        this.moveOptions = response?.data
      })
    },
    async executeMove(move) {
      this.loading = true
      this.playerMove = this.moveOptions.find((moveOption) => moveOption.slug === move)?.name
      await axios
        .post(API_URL + '/execute', { move })
        .then((response) => {
          const { data } = response
          this.data = data
          this.computerMove = data?.result.computer_move.name
          this.result = data?.result.outcome
          this.loading = false
          if (this.currentRound === parseInt(this.gameConfig?.rounds)) {
            this.analyse()
          } else {
            this.currentRound = this.currentRound + 1
          }

          if (this.result === 'win') {
            this.playerWinCount = this.playerWinCount + 1
          } else if (this.result === 'lose') {
            this.computerWinCount = this.computerWinCount + 1
          } else if (this.result === 'draw') {
            this.drawCount = this.drawCount + 1
          }
        })
        .catch((error) => {
          this.error = error.message
          this.loading = false
        })
    },
  },
  async mounted() {
    await this.fetchConfig()
    await this.fetchMoves()
    this.gameState = 'started'
  },
}
</script>

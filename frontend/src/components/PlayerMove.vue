<template>
  <div class="player-move">
    <div class="inner-player-move">
      <h2>Player {{ player }}</h2>
      <Analyse
        v-if="gameState === 'analyse'"
        :history="moveHistory"
        :rounds="parseInt(gameConfig?.rounds)"
      />
      <section v-else>
        <div class="choices">
          <button
            v-for="move in moveOptions"
            @click="executeMove(move.slug)"
            :disabled="loading || analysing"
          >
            {{ move.name }}
          </button>
          <div v-show="loading" class="loader spinner-border text-secondary" role="status"></div>
        </div>

        <p class="my-2">
          Round: <strong>{{ currentRound }} / {{ gameConfig?.rounds }}</strong>
        </p>

        <div v-if="playerMove && !loading" class="results">
          <h3 v-show="result === 'win'" class="text-success">You Won</h3>
          <h3 v-show="result === 'lose'" class="text-danger">You Lose</h3>
          <h3 v-show="result === 'draw'" class="text-warning">Draw</h3>

          <p class="mt-4">
            Your Move: <strong>{{ playerMove }}</strong>
          </p>
          <p>
            Opponent Move: <strong>{{ computerMove }}</strong>
          </p>
        </div>

        <div v-show="this.error" class="alert alert-danger" role="alert">
          {{ this.error }}
        </div>
      </section>
    </div>
  </div>
</template>

<style>
.player-move {
  border-bottom: 1px solid #ddd;
  padding-bottom: 34px;
  margin-bottom: 34px;
}
@media (min-width: 1024px) {
  .player-move {
    min-height: 20vh;
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
import Analyse from '@/components/Analyse.vue'

// can be done on ENV var
const API_URL = 'http://localhost:8000/api'

export default {
  props: {
    player: {
      type: Number,
      required: true,
    },
    gameConfig: {
      type: Object,
    },
    moveOptions: {
      type: Array,
    },
  },
  components: {
    Analyse,
    Analyse,
  },
  data() {
    return {
      data: null,
      loading: false,
      playerMove: null,
      computerMove: null,
      result: null,
      gameState: 'initial',
      currentRound: 1,
      playerWinCount: 0,
      computerWinCount: 0,
      drawCount: 0,
      analysing: false,
      moveHistory: [],
      error: null,
    }
  },
  methods: {
    async executeMove(move) {
      this.error = null
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

          this.moveHistory.push({
            player_move: move,
            computer_move: data?.result.computer_move.slug,
            outcome: data?.result.outcome,
          })

          if (this.result === 'win') {
            this.playerWinCount = this.playerWinCount + 1
          } else if (this.result === 'lose') {
            this.computerWinCount = this.computerWinCount + 1
          } else if (this.result === 'draw') {
            this.drawCount = this.drawCount + 1
          }

          if (this.currentRound === parseInt(this.gameConfig?.rounds)) {
            this.gameState = 'analyse'
          } else {
            this.currentRound = this.currentRound + 1
          }
        })
        .catch((error) => {
          this.error = error.response.data.message
          if (error?.response?.data?.missing_rules) {
            this.error =
              this.error + ' Missing rules: ' + error?.response?.data?.missing_rules.join(', ')
          }
          console.log('error.response.data')
          this.loading = false
          this.drawCount = this.drawCount + 1
          this.moveHistory.push({
            player_move: '--',
            computer_move: '--',
            outcome: 'draw',
          })

          if (this.currentRound === parseInt(this.gameConfig?.rounds)) {
            this.gameState = 'analyse'
          } else {
            this.currentRound = this.currentRound + 1
          }
        })
    },
  },
}
</script>

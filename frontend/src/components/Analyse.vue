<template>
  <div class="analyse">
    <h5 class="mt-3 mb-3">Statistics</h5>
    <ul class="list-group mb-3">
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Your total win
        <span class="font-weight-bold">{{ result.player_win_count }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Opponent total win
        <span class="font-weight-bold">{{ result.computer_win_count }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Draw count
        <span class="font-weight-bold">{{ result.draw_count }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Total Round
        <span class="font-weight-bold">{{ rounds }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Your winning percentage
        <span class="font-weight-bold">%{{ result.player_win_percentage }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Opponent winning percentage
        <span class="font-weight-bold">%{{ result.computer_win_percentage }}</span>
      </li>
    </ul>

    <h5 class="mt-3 mb-3">Move history</h5>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Round #</th>
          <th scope="col">Your Move</th>
          <th scope="col">Opponent Move</th>
          <th scope="col">Outcome</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in history" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td class="capitalize">{{ item.player_move }}</td>
          <td class="capitalize">{{ item.computer_move }}</td>
          <td class="capitalize">
            <span v-if="item.outcome === 'win'" class="text-success">Won</span>
            <span v-else-if="item.outcome === 'lose'" class="text-danger">Lose</span>
            <span v-else-if="item.outcome === 'draw'" class="text-warning">Draw</span>
            <span v-else class="text-muted">Unknown</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<style scoped>
.capitalize {
  text-transform: capitalize;
}
.badge-primary {
  color: #fff;
  background-color: #007bff;
}
</style>
<script>
import axios from 'axios'
const API_URL = 'http://localhost:8000/api'

export default {
  props: {
    history: {
      type: Array,
      required: true,
      default: [],
    },
    rounds: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      analysing: true,
      result: {
        player_win_count: 0,
        computer_win_count: 0,
        player_win_percentage: 0,
        computer_win_percentage: 0,
        draw_count: 0,
      },
    }
  },
  methods: {
    async analyse() {
      this.analysing = true
      let playerWinCount = 0
      let computerWinCount = 0
      let drawCount = 0
      this.history.forEach((moveItem) => {
        if (moveItem.outcome === 'win') {
          playerWinCount++
        } else if (moveItem.outcome === 'lose') {
          computerWinCount++
        } else if (moveItem.outcome === 'draw') {
          drawCount++
        }
      })

      await axios
        .post(API_URL + '/analyse', {
          player_win_count: playerWinCount,
          computer_win_count: computerWinCount,
          draw_count: drawCount,
          rounds: this.rounds,
        })
        .then((response) => {
          const { data } = response
          this.result.player_win_count = data?.result?.player_win_count
          this.result.computer_win_count = data?.result?.computer_win_count
          this.result.player_win_percentage = data?.result?.player_win_percentage
          this.result.computer_win_percentage = data?.result?.computer_win_percentage
          this.result.draw_count = data?.result?.draw_count
          this.analysing = false
        })
    },
  },
  async mounted() {
    await this.analyse()
  },
}
</script>

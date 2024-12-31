<template>
  <div class="manage-teams">
    <h2>Manage Teams</h2>

    <div class="unassigned-players">
      <h3>Unassigned Players</h3>
      <draggable
        class="players"
        v-model="unassignedPlayers"
        @start="drag = true"
        @end="drag = false"
        group="players"
        @change="unassignedOrderChange"
      >
        <div
          v-for="player in unassignedPlayers"
          :key="player.id"
          class="player-item"
        >
          <div>{{ player.name }}</div>
          <div>{{ player.email }}</div>
          <div>{{ player.date_of_birth }}</div>
        </div>
      </draggable>
    </div>

    <h3>Teams</h3>
    <div class="teams-container">
      <div v-for="team in teams" :key="team.id" class="team-box">
        <h3>{{ team.name }}</h3>
        <p>{{ team.state }}, {{ team.country }}</p>

        <draggable
          class="teams-players"
          v-model="team.players"
          @start="drag = true"
          @end="drag = false"
          group="players"
          @change="updateTeamOrder(team)"
        >
          <div
            v-for="(player, index) in team.players"
            :key="index"
            class="teams-player-item"
          >
            <div>{{ player.name }}</div>
            <button
              class="remove-btn"
              @click="removePlayerFromTeam(player, team)"
            >
              Remove
            </button>
          </div>
        </draggable>
      </div>
    </div>

    <button v-if="teams.length > 0" @click="saveTeams">Save Teams</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { VueDraggableNext as draggable } from "vue-draggable-next";

const teams = ref([]);
const unassignedPlayers = ref([]);
const drag = ref(false);

const fetchTeams = async () => {
  try {
    const response = await axios.get("api/teams");
    teams.value = response.data.teams;
    unassignedPlayers.value = response.data.players;
  } catch (error) {
    console.error("Error fetching teams and players:", error);
  }
};

const removePlayerFromTeam = (player, team) => {
  const playerIndex = team.players.findIndex((p) => p.id === player.id);
  if (playerIndex !== -1) {
    team.players.splice(playerIndex, 1);
    unassignedPlayers.value.push(player);
  }
};

const saveTeams = async () => {
  const teamsData = teams.value.map((team) => ({
    id: team.id,
    players: team.players.map((player, index) => ({
      id: player.id,
      sort_order: index,
    })),
  }));

  try {
    const response = await axios.post("api/save-teams", { teams: teamsData });
    alert(response.data.message);
  } catch (error) {
    alert(error);
    console.error("Error saving teams:", error);
  }
};

const unassignedOrderChange = () => {
  unassignedPlayers.value.forEach((player, index) => {
    player.sort_order = index;
  });
};

const updateTeamOrder = (team) => {
  team.players.forEach((player, index) => {
    player.sort_order = index;
  });
};

onMounted(() => {
  fetchTeams();
});
</script>

<style scoped>
.manage-teams {
  width: 1200px;
  margin: 0 auto;
}

.teams-container {
  display: flex;
  gap: 20px;
}

.team-box {
  border: 1px solid #ccc;
  padding: 10px;
  width: 50%;
}

.player-list,
.team-box {
  margin-bottom: 10px;
}

.unassigned-players {
  margin-bottom: 20px;
}

.players {
  border: 1px solid rgb(187, 185, 185);
}

.player-item,
.teams-player-item {
  display: grid;
  gap: 16px;
  grid-template-columns: repeat(3, 1fr);
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid rgb(187, 185, 185);
  color: #1b1b1b;
  align-items: center;
}

.teams-player-item {
  grid-template-columns: repeat(2, 1fr);
}

button {
  background: rgb(45, 35, 143);
  color: #fff;
  padding: 10px 20px;
  border-radius: 8px;
  border: 0px;
  cursor: pointer;
}

.remove-btn {
  width: 100px;
  margin-left: auto;
}

.teams-players {
  min-height: 70px;
}
</style>

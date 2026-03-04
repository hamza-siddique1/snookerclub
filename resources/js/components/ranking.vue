<template>
   <div class="rankings-manager">
      <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
         <div class="alert-message">
            {{ successMessage }}
         </div>
      </div>
      <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
         <div class="alert-message">
            {{ errorMessage }}
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm">
                        <div class="form-group">

                           <select v-model.number="newRanking.player_id" class="form-control form-select">
                              <option :value="null">-- Choose a player --</option>
                              <option v-for="player in availablePlayers" :key="player.id" :value="player.id">
                                 {{ player.name }}
                              </option>
                           </select>
                        </div>
                     </div>
                     <div class="col-sm">
                        <div class="form-group">

                           <input
                              v-model.number="newRanking.score"
                              type="number"
                              class="form-control"
                              placeholder="Enter points"
                              min="0"
                              >
                        </div>
                     </div>
                     <div class="col-sm">
                        <div class="form-group">
                           <button @click="addRanking" class="btn btn-lg btn-success btn-add mt-30">
                           ➕ Add Ranking
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="rankings-table-section">
         <h3>Current Rankings</h3>
         <div v-if="rankings.length === 0" class="no-data">
            <p>No rankings yet. Add one to get started!</p>
         </div>
         <table v-else class="table table-striped table-hover">
            <thead>
               <tr>
                  <th style="width: 60px;">#</th>
                  <th>Player Name</th>
                  <th style="width: 120px;">Score</th>
                  <th style="width: 200px;">Actions</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="ranking in rankings" :key="ranking.id" :class="{ 'editing': editingId === ranking.id }">
                  <td class="rank-badge">
                     <span class="badge bg-gold">{{ ranking.rank }}</span>
                  </td>
                  <td>{{ ranking.player_name }}</td>
                  <td>
                     <div v-if="editingId === ranking.id" class="edit-score">
                        <input
                           v-model.number="editingScore"
                           type="number"
                           class="form-control"
                           min="0"
                           >
                     </div>
                     <div v-else class="score-display">
                        <strong>{{ ranking.score }}</strong>
                     </div>
                  </td>
                  <td class="action-buttons">
                     <div v-if="editingId === ranking.id" class="edit-actions">
                        <button @click="saveEdit(ranking)" class="btn btn-sm btn-success" title="Save">
                        ✓ Save
                        </button>
                        <button @click="cancelEdit" class="btn btn-sm btn-secondary" title="Cancel">
                        ✕ Cancel
                        </button>
                     </div>
                     <div v-else class="normal-actions">
                        <button @click="startEdit(ranking)" class="btn btn-sm btn-warning" title="Edit">
                        ✎ Edit
                        </button>
                        <button @click="deleteRanking(ranking)" class="btn btn-sm btn-danger" title="Delete">
                        🗑 Delete
                        </button>
                     </div>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</template>
<script>
   export default {
       name: 'PlayerRankingsManager',
       data() {
           return {
               rankings: [],
               players: [],
               availablePlayers: [],
               newRanking: {
                   player_id: null,
                   score: 0
               },
               editingId: null,
               editingScore: 0,
               successMessage: '',
               errorMessage: '',
               loading: false
           }
       },
       mounted() {
           window.axios.defaults.headers.common['X-CSRF-TOKEN'] =
               document.querySelector('meta[name="csrf-token"]').getAttribute('content');

           this.loadPlayers();
           this.loadRankings();
       },
       watch: {
           players() {
               this.updateAvailablePlayers();
           },
           rankings() {
               this.updateAvailablePlayers();
           }
       },
       methods: {
           async loadPlayers() {
               try {
                   const response = await window.axios.get('/admin/api/rankings/players');
                   if (response.data.success) {
                       this.players = response.data.players;
                       this.updateAvailablePlayers();
                   }
               } catch (error) {
                   console.error('Error loading players:', error);
                   this.showError('Failed to load players');
               }
           },

           async loadRankings() {
               try {
                   this.loading = true;
                   const response = await window.axios.get('/admin/api/rankings/');
                   if (response.data.success) {
                       this.rankings = response.data.data || [];
                   }
               } catch (error) {
                   console.error('Error loading rankings:', error);
                   this.showError('Failed to load rankings');
               } finally {
                   this.loading = false;
               }
           },

           updateAvailablePlayers() {
               const rankedPlayerIds = this.rankings.map(r => r.player_id);
               this.availablePlayers = this.players.filter(p => !rankedPlayerIds.includes(p.id));
           },

           async addRanking() {
            console.log(this.newRanking);
               if (!this.newRanking.player_id) {
                   this.showError('Please select a player');
                   return;
               }

               if (this.newRanking.score < 0) {
                   this.showError('Score must be 0 or higher');
                   return;
               }

               try {
                   this.loading = true;
                   const response = await window.axios.post('/admin/api/rankings/', this.newRanking);

                   if (response.data.success) {
                       this.rankings = response.data.rankings;
                       this.newRanking = {
                           player_id: '',
                           score: 0
                       };
                       this.showSuccess('Ranking added successfully!');
                   }
               } catch (error) {
                   console.error('Error adding ranking:', error);
                   this.showError(error.response?.data?.message || 'Failed to add ranking');
               } finally {
                   this.loading = false;
               }
           },

           startEdit(ranking) {
               this.editingId = ranking.id;
               this.editingScore = ranking.score;
           },

           cancelEdit() {
               this.editingId = null;
               this.editingScore = 0;
           },

           async saveEdit(ranking) {
               try {
                   this.loading = true;
                   const response = await window.axios.put(`/admin/api/rankings/${ranking.id}`, {
                       score: this.editingScore
                   });

                   if (response.data.success) {
                       this.rankings = response.data.rankings;
                       this.editingId = null;
                       this.showSuccess('Ranking updated successfully!');
                   }
               } catch (error) {
                   console.error('Error updating ranking:', error);
                   this.showError(error.response?.data?.message || 'Failed to update ranking');
               } finally {
                   this.loading = false;
               }
           },

           async deleteRanking(ranking) {
               if (!confirm(`Delete ${ranking.player_name} from rankings?`)) {
                   return;
               }

               try {
                   this.loading = true;
                   const response = await window.axios.delete(`/admin/api/rankings/${ranking.id}`);

                   if (response.data.success) {
                       this.rankings = response.data.rankings;
                       this.showSuccess('Ranking deleted successfully!');
                   }
               } catch (error) {
                   console.error('Error deleting ranking:', error);
                   this.showError(error.response?.data?.message || 'Failed to delete ranking');
               } finally {
                   this.loading = false;
               }
           },

           showSuccess(message) {
               this.successMessage = message;
               setTimeout(() => {
                   this.successMessage = '';
               }, 3000);
           },

           showError(message) {
               this.errorMessage = message;
               setTimeout(() => {
                   this.errorMessage = '';
               }, 5000);
           }
       }
   }
</script>
<style scoped>

</style>

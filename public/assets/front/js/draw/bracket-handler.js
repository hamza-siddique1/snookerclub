/**
 * Tournament Bracket Handler
 * Manages match editing, form submission, and real-time updates
 */

// Get tournament ID from URL
const TOURNAMENT_ID = window.location.pathname.split('/')[2];

/**
 * Edit match - opens modal with match data
 */
function editMatch(matchId) {
    // Fetch match data
    fetch(`/bracket/match/${matchId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateModal(data.match);
                $('#matchModal').modal('show');
            } else {
                alert('Error loading match data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading match data');
        });
}

/**
 * Populate modal with match data
 */
function populateModal(match) {
    const form = document.getElementById('matchForm');

    // Store match ID
    document.getElementById('matchId').value = match.id;

    // Player 1
    document.getElementById('player1Name').value = match.player_1_name;
    document.getElementById('player1NameLabel').textContent = match.player_1_name;
    document.getElementById('player1Rank').textContent = match.player_1_rank ? `(${match.player_1_rank})` : '';
    document.getElementById('player1Score').value = match.score_player_1 || '';

    // Player 2
    document.getElementById('player2Name').value = match.player_2_name;
    document.getElementById('player2NameLabel').textContent = match.player_2_name;
    document.getElementById('player2Rank').textContent = match.player_2_rank ? `(${match.player_2_rank})` : '';
    document.getElementById('player2Score').value = match.score_player_2 || '';

    // Winner dropdown options
    const winner1Option = document.getElementById('winner-option-1');
    const winner2Option = document.getElementById('winner-option-2');

    winner1Option.value = match.player_1;
    winner1Option.textContent = match.player_1_name;

    winner2Option.value = match.player_2;
    winner2Option.textContent = match.player_2_name;

    // Set current winner if exists
    if (match.winner_id) {
        document.getElementById('winner').value = match.winner_id;
    } else {
        document.getElementById('winner').value = '';
    }

    // Clear any previous error messages
    form.querySelectorAll('.invalid-feedback').forEach(el => {
        el.style.display = 'none';
    });
}

/**
 * Handle form submission
 */
document.getElementById('matchForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const matchId = document.getElementById('matchId').value;
    const player1Score = document.getElementById('player1Score').value;
    const player2Score = document.getElementById('player2Score').value;
    const winnerId = document.getElementById('winner').value;

    // Validation
    if (!player1Score || !player2Score || !winnerId) {
        alert('Please fill in all fields');
        return;
    }

    // Get CSRF token
    const token = document.querySelector('input[name="_token"]').value;

    // Prepare data
    const formData = {
        winner_id: winnerId,
        player_1_score: parseInt(player1Score),
        player_2_score: parseInt(player2Score),
    };

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span>Updating...';

    // Submit
    fetch(`/bracket/match/${matchId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert('Match updated successfully!', 'success');

            // Close modal
            $('#matchModal').modal('hide');

            // Reload page to show updated bracket
            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            showAlert('Error: ' + data.error, 'danger');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred while updating the match', 'danger');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert"
             style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

    const alertElement = document.createElement('div');
    alertElement.innerHTML = alertHtml;
    document.body.appendChild(alertElement.firstElementChild);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

/**
 * Real-time bracket refresh (optional)
 * Uncomment to enable auto-refresh every 30 seconds
 */
/*
setInterval(() => {
    if (!document.hidden) {
        fetch(`/bracket/${TOURNAMENT_ID}/data`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateBracket(data);
                }
            })
            .catch(error => console.error('Error refreshing bracket:', error));
    }
}, 30000);
*/

/**
 * Update bracket dynamically (optional)
 */
function updateBracket(data) {
    // Update Quarter-Finals
    updateRoundMatches('5', data.quarterFinals);

    // Update Semi-Finals
    updateRoundMatches('6', data.semiFinals);

    // Update Final
    if (data.final) {
        updateRoundMatches('7', [data.final]);
    }
}

/**
 * Update matches in a specific round
 */
function updateRoundMatches(roundId, matches) {
    const roundElement = document.getElementById(roundId);
    if (!roundElement) return;

    matches.forEach(match => {
        const matchElement = roundElement.querySelector(`[data-match-id="${match.id}"]`);
        if (matchElement) {
            updateMatchElement(matchElement, match);
        }
    });
}

/**
 * Update individual match display
 */
function updateMatchElement(element, match) {
    const bracket = element.querySelector('.bracket');

    // Update scores
    const homeScore = element.querySelector('.bracket__result--home .result');
    const awayScore = element.querySelector('.bracket__result--away .result');

    if (homeScore) homeScore.textContent = match.player_1_score || '-';
    if (awayScore) awayScore.textContent = match.player_2_score || '-';

    // Update advancing players
    const homeName = element.querySelector('.bracket__participant--home .bracket__name');
    const awayName = element.querySelector('.bracket__participant--away .bracket__name');

    if (match.is_completed) {
        bracket.classList.add('bracket--completed');

        if (match.winner_id === match.player_1_id) {
            homeName.classList.add('bracket__name--advancing');
            awayName.classList.remove('bracket__name--advancing');
        } else {
            awayName.classList.add('bracket__name--advancing');
            homeName.classList.remove('bracket__name--advancing');
        }
    }
}

/**
 * Export bracket as JSON
 */
function exportBracket() {
    fetch(`/bracket/${TOURNAMENT_ID}/data`)
        .then(response => response.json())
        .then(data => {
            const element = document.createElement('a');
            element.setAttribute('href', 'data:text/json;charset=utf-8,' +
                encodeURIComponent(JSON.stringify(data, null, 2)));
            element.setAttribute('download', `tournament-${TOURNAMENT_ID}.json`);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });
}

/**
 * Print bracket
 */
function printBracket() {
    window.print();
}

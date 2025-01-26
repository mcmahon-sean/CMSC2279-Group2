fetch('api_fetch.php')
    .then(response => response.json())
    .then(data => {
        console.log(data); // View the response in the browser console
        displayData(data); // Pass data to a function for display
    })
    .catch(error => console.error('Error:', error));

function formatLastPlayed(timestamp) {
    if (!timestamp) return "Never played"; // Handle cases where the timestamp is missing or 0
    const date = new Date(timestamp * 1000); // Convert seconds to milliseconds
    return date.toLocaleDateString("en-US", { // Customize format
        weekday: "long", // Full name of the day (e.g., Monday)
        year: "numeric",
        month: "long", // Full month name (e.g., January)
        day: "numeric"
    });
}

function displayData(data) {
    const container = document.getElementById('game-data');
    const player = data.playerSummary;
    const games = data.gameStats.games;

    if (player) {
        container.innerHTML = `
            <h1>${player.personaname}</h1>
            <img src="${player.avatarfull}" alt="Avatar">
            <p>Profile URL: <a href="${player.profileurl}" target="_blank">Click here</a></p>
        `;
    }

    if (games && games.length > 0) {
        const gamesList = games.map(game => `
            <div>
                <p><strong>${game.name || 'Unknown'}</strong></p>
                <p>Playtime: ${Math.floor(game.playtime_forever / 60)} hours</p>
                <p>Last Played: ${formatLastPlayed(game.rtime_last_played)}</p><br>
            </div>
        `).join('');
        container.innerHTML += `<h2>Owned Games</h2><hr>${gamesList}`;
    } else {
        container.innerHTML += `<p>No games found.</p>`;
    }
}
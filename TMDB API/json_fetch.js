fetch('api_fetch.php')
    .then(response => response.json())
    .then(data => {
        console.log(data); 
        displayData(data); 
    })
    .catch(error => console.error('Error:', error));

function displayData(data) {
    const container = document.getElementById('film-data');
    const filmsWatched = data.filmData;
    const user = data.userData;
    const favTV = data.favTVData;

    container.innerHTML = `
        <h1>${user.username}</h1>
        <img src="https://image.tmdb.org/t/p/w150_and_h150_face${user.avatar.tmdb.avatar_path}" alt="Avatar">
    `;
    
    if (favTV.length > 0){
        const favTVList = favTV.map( tv => `
            <div>
                <p><strong>${tv.original_name || 'Unknown'} </strong></p>
                <p>Film Popularity: ${tv.popularity}</p>
            </div>
        `).join('');
        container.innerHTML += `<h2>Favorite TV Shows</h2><hr>${favTVList}`;
    }else{
        container.innerHTML += `<p>No TV Shows Favorited</p>`
    }

    if (filmsWatched.length > 0){
        const filmList = filmsWatched.map( film => `
            <div>
                <p><strong>${film.original_title || 'Unknown'} </strong></p>
                <p>Film Popularity: ${film.popularity}</p>
                <p>User Rating: ${film.rating}</p>
            </div>
        `).join('');
        container.innerHTML += `<h2>Recently Watched Films</h2><hr>${filmList}`;
    }else{
        container.innerHTML += `<p>No films watched</p>`
    }
}
document.addEventListener('DOMContentLoaded', () => {
    // Récupérer le jeton d'accès depuis le fragment de l'URL
    const hash = window.location.hash
        .substring(1)
        .split('&')
        .reduce((initial, item) => {
            const parts = item.split('=');
            initial[parts[0]] = decodeURIComponent(parts[1]);
            return initial;
        }, {});

    const accessToken = hash.access_token;

    if (accessToken) {
        // Stocker le jeton d'accès dans le sessionStorage
        sessionStorage.setItem('spotifyAccessToken', accessToken);

        // Rediriger vers la page où vous voulez jouer de la musique
        window.location.replace('/music-page');
    } else {
        // Gérer l'erreur s'il n'y a pas de jeton d'accès
        console.error('No access token found');
    }
});

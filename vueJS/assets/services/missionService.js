export async function getMissions() {
    const response = await fetch('/api/missions', {
        headers: {
            'Accept': 'application/json'
        }
    });

    if (!response.ok) {
        throw new Error('Erreur lors du chargement des missions');
    }
    return await response.json();
}

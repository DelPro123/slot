import React, { useEffect, useState } from 'react';
import axios from 'axios';

function GamesList() {
  const [games, setGames] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get('/api/games')
      .then(response => {
        setGames(response.data);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching games:', error);
        setError(error.message);
        setLoading(false);
      });
  }, []);

  if (loading) return <div className="p-4">Loading games...</div>;
  if (error) return <div className="p-4 text-red-500">Error: {error}</div>;

  return (
    <div className="row row-cols-5">
      {games.map((game) => (
        <div key={game.id} className="bg-white rounded-xl shadow  text-center col">
          <img
            src={game.image_url || '/placeholder-game.png'}
            alt={game.name}
            className="w-full h-32 object-cover rounded-md mb-2"
          />
          <p className="text-sm font-semibold">{game.name}</p>
        </div>
      ))}
    </div>
  );
}

export default GamesList;

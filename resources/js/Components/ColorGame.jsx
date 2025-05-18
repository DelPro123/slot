import axios from 'axios';
import React, { useEffect, useState } from 'react';

function ColorGame() {
  const [games, setGames] = useState([]);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/latest-predicted-games')
      .then(res => setGames(res.data))
      .catch(err => console.error('Error fetching games:', err));
  }, []);

  if (games.length === 0) return <p>No prediction yet.</p>;

  const color = games[0]?.color;
  const colorClass = {
    red: 'border-red-400 bg-red-100',
    green: 'border-green-400 bg-green-100',
    orange: 'border-orange-400 bg-orange-100'
  }[color];

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4 capitalize">{color} Prediction</h2>
      <div className="grid grid-cols-2 md:grid-cols-5 gap-4">
        {games.map(({ game }) => (
          <div key={game.id} className={`rounded-xl p-2 text-center border ${colorClass}`}>
            <img src={game.image_url} alt={game.name} className="w-full h-32 object-cover rounded" />
            <p className="text-sm mt-2">{game.name}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default ColorGame;

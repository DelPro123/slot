import axios from 'axios';
import React, { useEffect, useState } from 'react';

function ColorGame() {
  const [games, setGames] = useState([]);
  const [prediction, setPrediction] = useState(null);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/latest-predicted-games')
      .then(res => {
        setGames(res.data);
        if (res.data.length > 0) {
          setPrediction({
            color: res.data[0].color,
            timestamp: res.data[0].created_at, // Adjust if your timestamp field is different
          });
        }
      })
      .catch(err => console.error('Error fetching games:', err));
  }, []);

  if (!prediction) return <p className="p-4 text-center">No prediction yet.</p>;

  const renderGames = (color) => (
    <div className={`flex-1 p-4 rounded-xl ${getBgColor(color)} min-h-screen`}>
      <h2 className="text-center text-2xl font-bold mb-2">{capitalize(color)}</h2>
      {prediction.color === color && (
        <>
          <p className="text-center text-sm mb-4">
            Prediction at: {new Date(prediction.timestamp).toLocaleString()} ({capitalize(color)})
          </p>
          {games.map(({ game }) => (
            <div
              key={game.id}
              className="d-flex d-inline border row-gap-2"
            >

              <img
                src={game.image_url}
                alt={game.name}
                className="image-rounded"
              />
              <span className="text-sm font-semibold">{game.name}</span>
            </div>
          ))}
        </>
      )}
    </div>
  );

  const getBgColor = (color) => {
    switch (color) {
      case 'red':
        return 'bg-red-400';
      case 'green':
        return 'bg-green-400';
      case 'orange':
        return 'bg-orange-400';
      default:
        return '';
    }
  };

  const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);

  return (
    <div className="row">
        <div className='col-4'>
            {renderGames('red')}
        </div>
        <div className='col-4'>
            {renderGames('green')}
        </div>
        <div className='col-4'>
            {renderGames('orange')}
        </div>
    </div>
  );
}

export default ColorGame;

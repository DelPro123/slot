import axios from 'axios';
import React, { useEffect, useState } from 'react';
import classNames from 'classnames';

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
            timestamp: res.data[0].created_at,
          });
        }
      })
      .catch(err => console.error('Error fetching games:', err));
  }, []);

  if (!prediction) {
    return (
      <p className="p-4 text-center">No prediction yet.</p>
    );
  }

  const renderGames = (color) => (
    <div className={`${getBgColor(color)} p-3 rounded text-center text-white`}>
      {/* <h3 className="d-inline">{capitalize(color)}</h3> */}
     <h2 className="d-inline">{getWinrate(color)}</h2>
      <h3 className="ms-2 fw-semibold">Winning Rate</h3>

      {/* Progress Bar */}
      <div className="progress mb-3 mt-2" style={{ height: '2rem' }}>
        <div
          className={`progress-bar progress-bar-striped ${getProgressColor(color)}`}
          role="progressbar"
          style={{ width: `${getWinrateValue(color)}%` }}
          aria-valuenow={getWinrateValue(color)}
          aria-valuemin="0"
          aria-valuemax="100"
        />
      </div>

      {/* Prediction Timestamp & Games */}
      {prediction.color === color && (
        <>
          <p className="mt-2">
            Prediction at: {new Date(prediction.timestamp).toLocaleString()} ({capitalize(color)})
          </p>
          <div className="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            {games.map(({ game }) => (
              <div key={game.id} className="text-center" style={{ width: '120px' }}>
                <img
                  src={game.image_url}
                  alt={game.name}
                  className="img-fluid rounded"
                  style={{ height: '80px', objectFit: 'cover' }}
                />
                <span className="d-block mt-1 small">{game.provider}<br />{game.name}</span>
              </div>
            ))}
          </div>
        </>
      )}
    </div>
  );

  // Background color for card
  const getBgColor = (color) => {
    switch (color) {
      case 'red':
        return 'bg-red-400';
      case 'green':
        return 'bg-green-400';
      case 'orange':
        return 'bg-orange-400';
      default:
        return 'bg-secondary';
    }
  };

  // Progress bar color
  const getProgressColor = (color) => {
    switch (color) {
      case 'red':
        return 'bg-danger';
      case 'green':
        return 'bg-success';
      case 'orange':
        return 'bg-warning';
      default:
        return 'bg-secondary';
    }
  };

  // Winrate label
  const getWinrate = (color) => {
    switch (color) {
      case 'red':
        return '10% - 40%';
      case 'green':
        return '80% - 98%';
      case 'orange':
        return '50% - 70%';
      default:
        return '';
    }
  };

  // Winrate value for progress bar
  const getWinrateValue = (color) => {
    switch (color) {
      case 'red':
        return 40;
      case 'green':
        return 98;
      case 'orange':
        return 70;
      default:
        return 0;
    }
  };

  const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);

  return (
    <div className="row g-3">
      <div className='col-12 col-md-4'>
        {renderGames('red')}
      </div>
      <div className='col-12 col-md-4'>
        {renderGames('green')}
      </div>
      <div className='col-12 col-md-4'>
        {renderGames('orange')}
      </div>
    </div>
  );
}

export default ColorGame;

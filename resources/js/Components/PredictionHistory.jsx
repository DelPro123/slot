import React, { useEffect, useState } from 'react';
import axios from 'axios';

const PredictionHistory = () => {
  const [predictions, setPredictions] = useState([]);

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/prediction-history')
      .then(res => {
        if (res.data && typeof res.data === 'object') {
          const grouped = Object.entries(res.data);
          setPredictions(grouped);
        } else {
          setPredictions([]);
        }
      })
      .catch(err => {
        console.error("Error fetching history:", err);
        setPredictions([]);
      });
  }, []);

  if (!Array.isArray(predictions) || predictions.length === 0) {
    return <p className="p-3 text-muted">No prediction history available.</p>;
  }

  return (
    <div className="p-3">
      <h2 className="text-center fw-bold mb-3">History</h2>

      {/* Scrollable container */}
      <div
        className="border rounded p-3 overflow-auto"
        style={{ maxHeight: '600px' }}
      >
        {predictions.map(([timestamp, games], index) => {
          const formattedDate = new Date(timestamp).toLocaleString();
          const color = games[0]?.color || 'unknown';

          return (
            <div key={index} className="mb-4 border rounded p-3 shadow-sm bg-light">
              <h5 className="mb-3 fw-semibold">
                Prediction at: {formattedDate}{' '}
                <span className={`text-${getColorClass(color)} fw-bold`}>
                  ({color})
                </span>
              </h5>

              <div className="row row-cols-2 row-cols-md-5 g-3">
                {games.map((prediction) => (
                  <div key={prediction.id} className="col text-center">
                    <img
                      src={prediction.game.image_url}
                      alt={prediction.game.name}
                      className="img-fluid rounded mb-2"
                      style={{ height: '80px', objectFit: 'cover' }}
                    />
                    <p className="fw-medium text-truncate">{prediction.game.name}</p>
                  </div>
                ))}
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
};

const getColorClass = (color) => {
  switch (color) {
    case 'red':
      return 'danger';
    case 'green':
      return 'success';
    case 'orange':
      return 'warning';
    default:
      return 'secondary';
  }
};

export default PredictionHistory;

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
    return <p className="p-4 text-gray-500">No prediction history available.</p>;
  }

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Prediction History</h2>
      {predictions.map(([timestamp, games], index) => {
        const formattedDate = new Date(timestamp).toLocaleString();
        const color = games[0]?.color || 'unknown';
        return (
          <div key={index} className="mb-6 border rounded p-4 shadow-sm">
            <h3 className="text-lg font-semibold mb-2">
              Prediction at: {formattedDate}{' '}
              <span className={`capitalize font-bold ${getColorClass(color)}`}>
                ({color})
              </span>
            </h3>
            <div className="grid grid-cols-2 md:grid-cols-5 gap-4">
              {games.map((prediction) => (
                <div key={prediction.id} className="border p-2 rounded text-center">
                  <img
                    src={prediction.game.image_url}
                    alt={prediction.game.name}
                    className="w-full h-24 object-cover mb-2 rounded"
                  />
                  <p className="font-medium">{prediction.game.name}</p>
                </div>
              ))}
            </div>
          </div>
        );
      })}
    </div>
  );
};

// Color styling for title
const getColorClass = (color) => {
  switch (color) {
    case 'red':
      return 'text-red-600';
    case 'green':
      return 'text-green-600';
    case 'orange':
      return 'text-orange-500';
    default:
      return '';
  }
};

export default PredictionHistory;

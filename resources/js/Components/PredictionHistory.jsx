import React, { useEffect, useState } from 'react';
import axios from 'axios';

const PredictionHistory = () => {
  const [predictions, setPredictions] = useState([]);
  const [lastUpdated, setLastUpdated] = useState(null);

  useEffect(() => {
    const fetchHistory = () => {
      axios.get('/api/prediction-history')
        .then(res => {
          if (res.data && typeof res.data === 'object') {
            const grouped = Object.entries(res.data)
              .sort((a, b) => new Date(b[0]) - new Date(a[0]))
              .slice(1); // 🟢 Skip the newest prediction
            setPredictions(grouped);
            setLastUpdated(new Date());
          } else {
            setPredictions([]);
          }
        })
        .catch(err => {
          console.error("Error fetching history:", err);
          setPredictions([]);
        });
    };

    fetchHistory(); // Load initially
    const interval = setInterval(fetchHistory, 1000); // Refresh every 5 seconds

    return () => clearInterval(interval); // Cleanup
  }, []);

  if (!Array.isArray(predictions) || predictions.length === 0) {
    return <p className="p-3 text-white text-center">No prediction history available.</p>;
  }

  return (
    <div className="p-3">
      <h2 className="text-center fw-bold mb-3">Prediction History</h2>
      <p className="text-muted small text-end">
        Last updated: {lastUpdated?.toLocaleTimeString('en-GB', { hour12: true })}
      </p>

      <div className="border rounded p-3 overflow-auto" style={{ maxHeight: '600px' }}>
        {predictions.map(([timestamp, games], index) => {
          const formattedDate = new Date(timestamp).toLocaleString('en-GB', {
            dateStyle: 'short',
            timeStyle: 'short',
            hour12: true,
          });

          const groupedByColor = games.reduce((acc, pred) => {
            if (!acc[pred.color]) acc[pred.color] = [];
            acc[pred.color].push(pred);
            return acc;
          }, {});

          return (
            <div key={index} className="mb-4 border rounded p-3 shadow-sm bg-light">
              <h5 className="mb-3 fw-semibold">
                Prediction at: {formattedDate}
              </h5>

              {Object.entries(groupedByColor).map(([color, colorGames]) => (
                <div key={color} className="mb-3">
                  <h6 className={`fw-semibold text-${getColorClass(color)}`}>
                    {color.toUpperCase()}
                    <span className={`badge bg-${getColorClass(color)} ms-2`}>
                      {colorGames.length} games
                    </span>
                  </h6>
                  <div className="row row-cols-2 row-cols-md-5 g-3">
                    {colorGames.map(prediction => (
                      <div key={prediction.id} className="col text-center">
                        <img
                          src={prediction.game.image_url || 'fallback.jpg'}
                          alt={prediction.game.name || 'Game'}
                          className="img-fluid rounded mb-2"
                          style={{ height: '80px', objectFit: 'cover' }}
                        />
                        <p className="fw-medium text-truncate text-black">
                          {prediction.game.name || 'Unknown Game'}
                        </p>
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          );
        })}
      </div>
    </div>
  );
};

const getColorClass = (color) => {
  switch (color) {
    case 'red': return 'danger';
    case 'green': return 'success';
    case 'orange': return 'warning';
    default: return 'secondary';
  }
};

export default PredictionHistory;

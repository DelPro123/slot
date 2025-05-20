import React, { useEffect, useState } from 'react';
import axios from 'axios';

function CountdownTimer() {
  const [targetTime, setTargetTime] = useState(null);
  const [timeLeft, setTimeLeft] = useState('');

  useEffect(() => {
    // Fetch next prediction time from API once on mount
    axios.get('http://127.0.0.1:8000/api/next-prediction-time')
      .then(res => {
        setTargetTime(new Date(res.data.next_prediction_at));
      })
      .catch(() => {
        setTimeLeft('Error loading timer');
      });
  }, []);

  useEffect(() => {
    if (!targetTime) return;

    const pad = (num) => String(num).padStart(2, '0');

    const interval = setInterval(() => {
      const now = new Date();
      const diff = targetTime - now;

      if (diff <= 0) {
        setTimeLeft('00h 00m 00s');
        clearInterval(interval);
        return;
      }

      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);

      setTimeLeft(`${pad(hours)}h ${pad(minutes)}m ${pad(seconds)}s`);
    }, 1000);

    return () => clearInterval(interval);
  }, [targetTime]);

  return <span>{timeLeft || 'Loading...'}</span>;
}

export default CountdownTimer;

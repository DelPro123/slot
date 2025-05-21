import React, { useEffect, useState } from 'react';
import axios from 'axios';

function GamesList() {
  const [games, setGames] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [searchTerm, setSearchTerm] = useState('');

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

  const filteredGames = games.filter((game) =>
    game.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    game.provider.toLowerCase().includes(searchTerm.toLowerCase())
  );

  if (loading) return <div className="p-4 text-center text-muted">Loading games...</div>;
  if (error) return <div className="p-4 text-danger text-center">Error: {error}</div>;

  return (
    
    <div className="container py-4" style={{ backgroundColor: 'transparent' }}>
      <div className='d-flex d-inline'>
         <h2>Games</h2>
          {/* Search Bar */}
          <div className="mb-3 text-center">
            <input
              type="text"
              className="form-control w-100 mx-auto mt-2 mx-5"
              placeholder="Search games..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
      </div>

      {/* Games Grid */}
      <div className="d-flex mt-5">
        <div className="row row-cols g-5 d-flex justify-content-center align-item-center">
          {filteredGames.map((game) => (
            <div key={game.id} className="col affliate-link">
              <a className='underline' href='https://chinluckgames.com/wD74mscL?aff_click_id=subid&aff_id=1146'>
                <div className="card d-flex align-items-center text-center bg-transparent border-0 shadow-sm">
                  <img
                    src={game.image_url || '/placeholder-game.png'}
                    alt={game.name}
                    className="card-img-top  text-center"
                  />
                  <div className="card-body p-2">
                    <p className="card-text small mb-1 text-truncate">{game.provider}</p>
                    <p className="card-text fw-semibold text-truncate">{game.name}</p>
                  </div>
                </div>
              </a>
            </div>
          ))}
          {filteredGames.length === 0 && (
            <div className="text-center text-muted w-100 mt-4">No games found.</div>
          )}
        </div>
      </div>
    </div>
  );
}

export default GamesList;

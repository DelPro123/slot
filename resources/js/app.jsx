import React from 'react'
import ReactDOM from 'react-dom/client'
import GamesList from './Components/GamesList'
import ColorGame from './Components/ColorGame'

ReactDOM.createRoot(document.getElementById('app')).render(
  <React.StrictMode>
    <ColorGame/>
    <GamesList/>
  </React.StrictMode>,
)

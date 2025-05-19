import React from 'react'
import ReactDOM from 'react-dom/client'
import GamesList from './Components/GamesList'
import ColorGame from './Components/ColorGame'
import PredictionHistory from './Components/PredictionHistory'

ReactDOM.createRoot(document.getElementById('app')).render(
  <React.StrictMode>
    <ColorGame/>
     <GamesList/>
    <PredictionHistory/>


  </React.StrictMode>,
)

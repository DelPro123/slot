import React from 'react'
import ReactDOM from 'react-dom/client'
import GamesList from './Components/GamesList'
import ColorGame from './Components/ColorGame'
import PredictionHistory from './Components/PredictionHistory'
import CountdownPage from './Components/CountdownPage'
import 'bootstrap/dist/css/bootstrap.min.css';


ReactDOM.createRoot(document.getElementById('app')).render(
  <React.StrictMode>

    <div className='container-fluid'>
        <div className='row'>
            <CountdownPage/>
        </div>
        <div className='row'>
            <div className='col-9 d-flex d-inline'>
                <ColorGame/>
            </div>
            <div className='col-3'>
                <PredictionHistory/>
            </div>
        </div>
        <h2>Games</h2>
        <div className='row'>
            <GamesList/>
        </div>


    </div>

  </React.StrictMode>,
)

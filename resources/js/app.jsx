import React from 'react'
import ReactDOM from 'react-dom/client'
import GamesList from './Components/GamesList'
import ColorGame from './Components/ColorGame'
import PredictionHistory from './Components/PredictionHistory'
import CountdownPage from './Components/CountdownPage'
import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/app.scss';


ReactDOM.createRoot(document.getElementById('app')).render(
  <React.StrictMode>

    <div className='container-fluid'>
        <div className='row'>
            <CountdownPage/>
        </div>
        <div className='row'>
            <div className='col-lg-9 col-sm-12'>
                <ColorGame/>
            </div>
            <div className='col-lg-3 col-sm-12'>
                <PredictionHistory/>
            </div>
        </div>
        <div className='row'>
            <GamesList/>
        </div>


    </div>

  </React.StrictMode>,
)

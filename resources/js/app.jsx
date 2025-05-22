import React from 'react'
import ReactDOM from 'react-dom/client'
import GamesList from './Components/GamesList'
import ColorGame from './Components/ColorGame'
import PredictionHistory from './Components/PredictionHistory'
import CountdownPage from './Components/CountdownPage'
import { Helmet } from 'react-helmet'
import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/app.scss';


ReactDOM.createRoot(document.getElementById('app')).render(
  <React.StrictMode>

    <div className='container-fluid'>
        <Helmet>
            <meta charSet="utf-8" />
                 <title>Chinchin Casino Slot Prediction</title>
                <meta name="description" content="Chinchin Casino Slot Prediction, winning color-based winning rate chance with real-time updates and history tracking." />
                <link rel="icon" href="https://chinchin-casino.com/wp-content/uploads/2025/04/Chinchin-Favicon.webp" />
        </Helmet>
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

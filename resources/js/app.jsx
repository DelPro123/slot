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
                <title>My Title</title>
                <link rel="canonical" href=" " />
        </Helmet>
        <div className='row'>
            <CountdownPage/>
        </div>
        <div className='row'>
            <div className='col'>
                <ColorGame/>
            </div>
            <div className='col-3'>
                <PredictionHistory/>
            </div>
        </div>
        <div className='row'>
            <GamesList/>
        </div>


    </div>

  </React.StrictMode>,
)

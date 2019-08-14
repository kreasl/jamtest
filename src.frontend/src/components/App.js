import React from 'react';
import {BrowserRouter as Router, Route, Link} from 'react-router-dom';

import Profile from '../containers/Profile';
import Sent from '../containers/Sent';
import Received from '../containers/Received';
import Invite from '../containers/Invite';

import '../App.css';


function App() {
  return (
      <Router>
        <div>
          <nav>
            <ul>
              <li>
                <Link to="/">Profile</Link>
              </li>
              <li>
                <Link to="/sent/">Sent</Link>
              </li>
              <li>
                <Link to="/received/">Received</Link>
              </li>
              <li>
                <Link to="/invite/">Invite</Link>
              </li>
            </ul>
          </nav>

          <Route path="/" exact component={Profile}/>
          <Route path="/sent/" component={Sent}/>
          <Route path="/received/" component={Received}/>
          <Route path="/invite/" component={Invite}/>
        </div>
      </Router>
  );
}

export default App;

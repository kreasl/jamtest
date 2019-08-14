import React from "react";

import Invitation from './Invitation';

function Received({ receivedInvitations }) {
  const invitations = receivedInvitations.map(
    invitation => (
      <li>
        <Invitation invitation={invitation} type="received" />
      </li>
    ),
  );

  return (
    <div className="received">
      <h2>Received</h2>
      <ul>
        {invitations}
      </ul>
    </div>
  );
}

export default Received;
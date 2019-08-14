import React from "react";

import Invitation from './Invitation';

function Sent({ sentInvitations }) {
  const invitations = sentInvitations.map(
    invitation => (
      <li>
        <Invitation invitation={invitation} type="sent" />
      </li>
    ),
  );

  return (
    <div className="sent">
      <h2>Sent</h2>
      <ul>
        {invitations}
      </ul>
    </div>
  );
}

export default Sent;
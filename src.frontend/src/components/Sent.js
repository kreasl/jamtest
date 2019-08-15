import React from 'react';

import { useSentInvitations } from '../hooks/api';
import Invitation from "./Invitation";

function Sent({ sentInvitations }) {
  const [sent] = useSentInvitations();

  if (!sent) return <p>Loading...</p>

  const invitations = sent.map(
    invitation => (
      <li key={invitation.id}>
        <Invitation invitation={invitation} />
      </li>
    ),
  );

  if (!invitations.length) return <p>No invitations sent</p>;

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
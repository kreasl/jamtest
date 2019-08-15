import React from 'react';

import Invitation from './Invitation';
import { useReceivedInvitations } from '../hooks/api';

function Received({ receivedInvitations }) {
  const [received] = useReceivedInvitations();

  if (!received) return <p>Loading...</p>

  const invitations = received.map(
    invitation => (
      <li key={invitation.id}>
        <Invitation invitation={invitation} type="received" />
      </li>
    ),
  );

  if (!invitations.length) return <p>No invitations received</p>

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
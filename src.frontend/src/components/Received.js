import React from 'react';

import Invitation from './Invitation';
import { useFilteredReceivedInvitations } from '../hooks/api';

function Received() {
  const [received, filter, setFilter] = useFilteredReceivedInvitations();

  if (!received) return <p>Loading...</p>;

  const invitations = received.map(
    invitation => (
      <li key={invitation.id}>
        <Invitation invitation={invitation} />
      </li>
    ),
  );
  const invitationsBlock = (() => {
    if (!invitations.length) return <p>Nothing found</p>;

    return <ul>{invitations}</ul>
  })();

  const handleFilter = e => setFilter(e.target.value);

  return (
    <div className="received">
      <h2>Received</h2>
      <div>
        <input type="text" value={filter} onChange={handleFilter} />
      </div>
      {invitationsBlock}
    </div>
  );
}

export default Received;
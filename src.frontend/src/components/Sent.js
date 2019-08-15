import React from 'react';

import { useFilteredSentInvitations } from '../hooks/api';
import Invitation from "./Invitation";

function Sent() {
  const [sent, filter, setFilter] = useFilteredSentInvitations();

  if (!sent) return <p>Loading...</p>;

  const invitations = sent.map(
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
    <div className="sent">
      <h2>Sent</h2>
      <div>
        <input type="text" value={filter} onChange={handleFilter} />
      </div>
      {invitationsBlock}
    </div>
  );
}

export default Sent;
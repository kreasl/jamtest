import React from 'react';
import { Link } from 'react-router-dom';
import {useCurrentUser, useSentInvitations, useReceivedInvitations } from '../hooks/api';

function Profile() {
  const user = useCurrentUser();
  const [sentInvitations] = useSentInvitations();
  const [receivedInvitations] = useReceivedInvitations();

  if (!user || !sentInvitations || !receivedInvitations) return <p>Loading...</p>;

  return (
    <div className="profile">
      <h2>Logged in as {user.name}</h2>
      <div>Sent: <Link to="/sent/">{sentInvitations.length}</Link></div>
      <div>Received: <Link to="/received/">{receivedInvitations.length}</Link></div>
      <div><Link to="/invite/">Invite</Link></div>
    </div>
  );
}

export default Profile

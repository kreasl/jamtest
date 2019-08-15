import React, { useState } from 'react';

import { useUsers, usePostInviteEndpoint } from '../hooks/api';

const currentUserId = 1;

export default function Invite(props) {
  const [receiverId, setReceiverId] = useState();
  const [message, setMessage] = useState('');
  const [inviteResponse, postNewInvite] = usePostInviteEndpoint();

  const handleSubmit = (e) => {
    e.preventDefault();

    postNewInvite({
      id: 42,
    });

    // props.history.push('/');
  };

  const [users] = useUsers();

  if (!users) return <p>Loading...</p>;
  if (users.length && !receiverId) setReceiverId(users[0].id);

  const receivers = users
    .filter(user => user.id !== currentUserId)
    .map(user => <option key={user.id} value={user.id}>{user.name}</option>);

  return (
    <div className="invite">
      <h2>Invite</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Receiver
            <select value={receiverId} onChange={e => setReceiverId(e.target.value)}>
              {receivers}
            </select>
          </label>
        </div>
        <div>
          <label>Message
            <input type="text" value={message} onChange={e => setMessage(e.target.value)}/>
          </label>
        </div>
        <div>
          <input type="submit" value="Send"/>
        </div>
      </form>
    </div>
  );
}

import React, { useState } from 'react';

import { useOtherUsers, usePostInviteEndpoint } from '../hooks/api';

const currentUserId = 1;

export default function Invite(props) {
  const [receiverId, setReceiverId] = useState();
  const [message, setMessage] = useState('');
  const [inviteResponse, postNewInvite] = usePostInviteEndpoint();

  const handleSubmit = (e) => {
    e.preventDefault();

    postNewInvite({
      senderId: currentUserId,
      receiverId,
      message,
    });
  };

  const [users] = useOtherUsers();

  if (!users) return <p>Loading...</p>;

  if (inviteResponse.pending) return '<p>Sending...</p>';
  if (inviteResponse.complete) props.history.push('/sent');

  const receivers = users
    .map(user => <option key={user.id} value={user.id}>{user.name}</option>);

  if (users.length && !receiverId) setReceiverId(users[0].id);

  return (
    <div className="invite">
      <h2>Invite</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Receiver
            <select value={receiverId} onChange={e => {console.log(e.target.value); setReceiverId(e.target.value)}}>
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

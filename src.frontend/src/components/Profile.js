import { Link } from "react-router-dom";
import React from "react";

function Profile({ name, sentCount, receivedCount }) {
  return (
    <div className="profile">
      <h2>{name} profile</h2>
      <div>Sent: <Link to="/sent/">{sentCount}</Link></div>
      <div>Received: <Link to="/received/">{receivedCount}</Link></div>
      <div><Link to="/invite/">Invite</Link></div>
    </div>
  );
}

export default Profile

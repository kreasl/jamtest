import React from "react";
import {
  useCurrentUserId,
  usePostChangeInvitationStatus,
  STATUS_ACCEPTED,
  STATUS_DECLINED,
  STATUS_CANCELED,
  STATUS_CREATED,
} from "../hooks/api";

function Invitation(props) {
  const currentUserId = useCurrentUserId();
  const [updateResponse, updateInvitationStatus] = usePostChangeInvitationStatus();

  if (!currentUserId) return <p>Loading...</p>;

  const { invitation } = props;

  const handleCancel = e => {
    e.preventDefault();

    updateInvitationStatus(invitation.id, STATUS_CANCELED);
  };
  const handleAccept = e => {
    e.preventDefault();

    updateInvitationStatus(invitation.id, STATUS_ACCEPTED);
  };
  const handleDecline = e => {
    e.preventDefault();

    updateInvitationStatus(invitation.id, STATUS_DECLINED);
  };

  const controllers = (() => {
    if (updateResponse.pending) return <span>updating...</span>;

    if (invitation.status !== STATUS_CREATED) return null;

    if (currentUserId === invitation.senderId) return <a href="#" onClick={handleCancel}>Cancel</a>;

    return [
      <a href="#" key="accept" onClick={handleAccept}>Accept</a>,
      <a href="#" key="decline" onClick={handleDecline}>Decline</a>,
    ];
  })();

  return (
    <div className="Invitation">
      <span className="InvitationBody">{invitation.created}</span>
      <div className="InvitationControllers">
        {controllers}
      </div>
    </div>
  );
}

export default Invitation;

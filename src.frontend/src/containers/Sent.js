import { connect } from "react-redux";

import Sent from '../components/Sent';

function getUserName(users, id) {
  return users.filter(user => user.id === id)[0].name;
}

const mapStateToProps = ({ users, invitations }) => ({
  sentInvitations: invitations
    .filter(invitation => invitation.senderId === users.currentUserId)
    .map(invitation => ({ ...invitation, receiver: getUserName(users.users, invitation.receiverId) })),
});

export default connect(mapStateToProps)(Sent);
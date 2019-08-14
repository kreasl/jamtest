import { connect } from "react-redux";

import Received from '../components/Received';

function getUserName(users, id) {
  return users.filter(user => user.id === id)[0].name;
}

const mapStateToProps = ({ users, invitations }) => ({
  receivedInvitations: invitations
     .filter(invitation => invitation.receiverId === users.currentUserId)
     .map(invitation => ({ ...invitation, sender: getUserName(users.users, invitation.senderId) })),
});

export default connect(mapStateToProps)(Received);
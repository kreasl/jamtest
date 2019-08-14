import { connect } from "react-redux";

import Profile from '../components/Profile';

const mapStateToProps = ({ users, invitations }) => ({
  name: users.users.filter(user => user.id === users.currentUserId)[0].name,
  sentCount: invitations.filter(invitation => invitation.senderId === users.currentUserId).length,
  receivedCount: invitations.filter(invitation => invitation.receiverId === users.currentUserId).length,
});

export default connect(mapStateToProps)(Profile);

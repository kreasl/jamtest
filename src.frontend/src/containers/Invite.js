import { connect } from "react-redux";

import Invite from '../components/Invite';
import { ADD_INVITATION_ACTION } from "../reducers/invitations";

const mapStateToProps = ({ users, invitations }) => ({
  senderId: users.currentUserId,
  otherUsers: users.users.filter(user => user.id !== users.currentUserId)
});

const mapDispatchToProps = dispatch => ({
  addInvitation: invitation => dispatch({ type: ADD_INVITATION_ACTION, invitation }),
});

export default connect(mapStateToProps, mapDispatchToProps)(Invite);

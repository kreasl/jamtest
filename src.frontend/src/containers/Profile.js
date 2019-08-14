import { connect } from "react-redux";

import Profile from '../components/Profile';
import {fetchUsers} from "../actions";

const mapStateToProps = ({ users, invitations }) => {
  console.log(users);
  if (!users) return { name: null, sentCount: null, receivedCount: null };

  return {
    name: users.users.filter(user => user.id === users.currentUserId)[0].name,
    sentCount: invitations.filter(invitation => invitation.senderId === users.currentUserId).length,
    receivedCount: invitations.filter(invitation => invitation.receiverId === users.currentUserId).length,
  };
};

const mapDispatchToProps = dispatch => ({
  loadUsers: () => dispatch(fetchUsers()),
});

export default connect(mapStateToProps, mapDispatchToProps)(Profile);

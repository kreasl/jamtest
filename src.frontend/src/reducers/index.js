import { combineReducers } from "redux";

import users from './users';
import invitations from './invitations';

export default combineReducers({
  users,
  invitations
});

export const getOtherUsers = (state, userId) => state.users.filter(user => user.id !== userId);

export const ACTION_LOAD_USERS = 'LOAD_USERS';

export default (state = null, action) => {
  switch (action.type) {
    case ACTION_LOAD_USERS:
      return action.users;
    default:
      return state;
  }
}

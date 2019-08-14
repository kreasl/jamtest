function getNextId(invitations) {
  return Math.max(invitations.map(invitation => invitation.id)) + 1;
}

export const ADD_INVITATION_ACTION = 'ADD_INVITATION';

export const getSentInvitations = (state, userId) => state
  .filter(invitation => invitation.senderId === userId);
export const getReceivedInvitations = (state, userId) => state
  .filter(invitation => invitation.receiverId === userId);

export default (state = initialInvitations, action = null) => {
  if (!action) return initialInvitations;

  switch (action.type) {
    case ADD_INVITATION_ACTION:
      return [
        ...state,
        {
          ...action.invitation,
          id: getNextId(state),
          created: '2019-08-13 19:42',
        }
      ];
    default:
      return state;
  }
}

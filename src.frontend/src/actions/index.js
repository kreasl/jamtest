import { ACTION_LOAD_USERS } from "../reducers/users";

const apiUrl = 'http://localhost:8000';

export const loadUsers = users => ({ type: ACTION_LOAD_USERS, users });

export const fetchUsers = () => (dispatch) => {
  return fetch(`${apiUrl}/users`)
    .then(data => data.json())
    .then(users => dispatch(loadUsers(users)));
};
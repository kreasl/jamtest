import { ACTION_LOAD_USERS } from "../reducers/users";

const apiUrl = 'http://localhost:3000/data';

export const loadUsers = users => ({ type: ACTION_LOAD_USERS, users });

export const fetchUsers = () => (dispatch) => {
  return fetch(`${apiUrl}/users.json`)
    .then(data => data.json())
    .then(users => dispatch(loadUsers(users)));
};
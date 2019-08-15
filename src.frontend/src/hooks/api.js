import { useState, useEffect } from 'react';
import axios from 'axios';

const apiUrl = 'http://localhost:3000/data';

export const STATUS_CREATED = 0;
export const STATUS_ACCEPTED = 1;
export const STATUS_DECLINED = 10;
export const STATUS_CANCELED = 20;

export const useCurrentUserId = () => {
  const [currentUserId] = useState(1);

  return currentUserId;
};

export const useUsers = () => {
  const [users, setUsers] = useState();

  useEffect(() => {
    const fetchData = async () => {
      const result = await axios(`${apiUrl}/users.json`);

      setUsers(result.data.users);
    };

    fetchData();
  }, []);

  return [users];
};

export const useCurrentUser = () => {
  const [user, setUser] = useState();

  const [users] = useUsers();
  const currentUserId = useCurrentUserId();

  if (users && users.length && !user) {
    setUser(users.filter(user => user.id === currentUserId)[0]);
  }

  return user;
};

export const useInvitations = () => {
  const [invitations, setInvitations] = useState();

  useEffect(() => {
    const fetchData = async () => {
      const result = await axios(`${apiUrl}/invitations.json`);

      setInvitations(result.data);
    };

    fetchData();
  }, []);

  return [invitations];
};

export const useSentInvitations = () => {
  const [sentInvitations, setSentInvitations] = useState();

  const [invitations] = useInvitations();
  const currentUserId = useCurrentUserId();

  if (invitations && invitations.length && !sentInvitations) {
   setSentInvitations(invitations.filter(invite => invite.senderId === currentUserId))
  }

  return [sentInvitations];
};

export const useReceivedInvitations = () => {
  const [receivedInvitations, setReceivedInvitations] = useState();

  const [invitations] = useInvitations();
  const currentUserId = useCurrentUserId();

  if (invitations && invitations.length && !receivedInvitations) {
    setReceivedInvitations(invitations.filter(invite => invite.receiverId === currentUserId))
  }

  return [receivedInvitations];
};

export const useAsyncEndpoint = (fn) => {
  const [res, setRes] = useState({
    data: null,
    complete: false,
    pending: false,
    error: false,
  });
  const [req, setReq] = useState();

  useEffect(
    () => {
      if (!req) return;

      console.log(req);

      setRes({
        data: null,
        pending: true,
        error: false,
        complete: false,
      });
      axios(req)
        .then(res => setRes({
          data: res.data,
          pending: false,
          error: false,
          complete: true,
        }))
        .catch(() => setRes({
          data: null,
          pending: false,
          error: true,
          complete: true,
        }));
    },
    [req],
  );

  return [res, (...args) => setReq(fn(...args))];
};

export const usePostInviteEndpoint = () => useAsyncEndpoint(
  data => ({
    url: `${apiUrl}/invitations`,
    method: 'POST',
    data,
  }),
);

export const usePostChangeInvitationStatus = () => useAsyncEndpoint(
  (id, status) => ({
    url: `${apiUrl}/invitations/${id}/status`,
    method: 'POST',
    data: { status },
  }),
);
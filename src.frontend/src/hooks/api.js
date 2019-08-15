import { useState, useEffect } from 'react';
import axios from 'axios';

// Expected to be in the root on the same server
const apiUrl = '';

export const STATUS_CREATED = 0;
export const STATUS_ACCEPTED = 1;
export const STATUS_DECLINED = 10;
export const STATUS_CANCELED = 20;

export const useCurrentUserId = () => {
  const [currentUserId, setCurrentUserId] = useState();

  useEffect(() => {
    const fetchData = async () => {
      const result = await axios(`${apiUrl}/users/profile`);

      setCurrentUserId(result.data.user.id);
    };

    fetchData();
  }, []);

  return currentUserId;
};

export const useUsers = () => {
  const [users, setUsers] = useState();

  useEffect(() => {
    const fetchData = async () => {
      const result = await axios(`${apiUrl}/users`);

      setUsers(result.data);
    };

    fetchData();
  }, []);

  return [users];
};

export const useOtherUsers = () => {
  const currentUserId = useCurrentUserId();
  const [users] = useUsers();

  if (!currentUserId || ! users) return [];

  const otherUsers = users.filter(user => user.id !== currentUserId);

  return [otherUsers];
};

export const useCurrentUser = () => {
  const [user, setUser] = useState();

  const [users] = useUsers();
  const currentUserId = useCurrentUserId();

  if (currentUserId && users && users.length && !user) {
    setUser(users.filter(user => user.id === currentUserId)[0]);
  }

  return user;
};

export const useInvitations = () => {
  const currentUserId = useCurrentUserId();
  const [invitations, setInvitations] = useState();

  useEffect(() => {
    const fetchData = async () => {
      if (!currentUserId) return;

      const result = await axios(`${apiUrl}/users/${currentUserId}/invitations`);

      const invitations = result
        .data
        .map(invitation => ({
          ...invitation,
          statusString: statusString(invitation.status),
        }))
        .sort((a, b) => {
          if (a.status < b.status) return -1;
          if (a.status > b.status) return 1;
          return 0;
        });

      setInvitations(invitations);
    };

    fetchData();
  }, [currentUserId]);

  const statusString = status => {
    if (status === STATUS_ACCEPTED) return 'accepted';
    if (status === STATUS_DECLINED) return 'declined';
    if (status === STATUS_CANCELED) return 'canceled';

    return 'created';
  };

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

export const useFilteredSentInvitations = () => {
  const [sentInvitations] = useSentInvitations();
  const [filter, setFilter] = useState('');

  if (!sentInvitations) return [null, filter, setFilter];

  const check = invitation => (
    invitation.created.indexOf(filter) >= 0
    || invitation.receiver && invitation.receiver.indexOf(filter) >= 0
    || invitation.statusString.indexOf(filter) >= 0
  );

  const filtered = sentInvitations.filter(check);

  return [filtered, filter, setFilter];
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

export const useFilteredReceivedInvitations = () => {
  const [receivedInvitations] = useReceivedInvitations();
  const [filter, setFilter] = useState('');

  if (!receivedInvitations) return [null, filter, setFilter];

  const check = invitation => (
    invitation.created.indexOf(filter) >= 0
    || invitation.sender && invitation.sender.indexOf(filter) >= 0
    || invitation.statusString.indexOf(filter) >= 0
  );

  const filtered = receivedInvitations.filter(check);

  return [filtered, filter, setFilter];
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
    url: `${apiUrl}/invitations/send`,
    method: 'POST',
    data,
  }),
);

export const usePostChangeInvitationStatus = () => useAsyncEndpoint(
  (id, status) => {
    const action = (() => {
      if (status === STATUS_CANCELED) return 'cancel';
      if (status === STATUS_ACCEPTED) return 'accept';
      return 'decline';
    }) ();

    return {
      url: `${apiUrl}/invitations/${id}/${action}`,
      method: 'POST',
      data: {},
    };
  },
);

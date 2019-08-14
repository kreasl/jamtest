import React from "react";

function Invitation(props) {
  const { type, invitation: { sender, receiver, created } } = props;

  if (type === 'received') return <span>{created} from {sender}</span>;

  return <span>{created} to {receiver}</span>;
}

export default Invitation;
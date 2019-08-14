import React from "react";

class Invite extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      senderId: props.senderId,
      receiverId: props.otherUsers[0].id || null,
      message: null,
    };

    this.handleReceiver = this.handleReceiver.bind(this);
    this.handleMessage = this.handleMessage.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleReceiver(event) {
    this.setState({ receiverId: event.target.value });
  }

  handleMessage(event) {
    console.log(event.target.value);
    this.setState({ message: event.target.value });
  }

  handleSubmit(event) {
    event.preventDefault();

    this.props.addInvitation(this.state);

    this.props.history.push('/');
  };

  render() {
    const { otherUsers, senderId } = this.props;
    const receivers = otherUsers.map(user => <option key={user.id} value={user.id}>{user.name}</option>);

    return (
      <div className="invite">
        <h2>Invite</h2>
        <form onSubmit={this.handleSubmit}>
          <div>
            <label>Receiver
              <select>
                {receivers}
              </select>
            </label>
          </div>
          <div>
            <label>Message
              <input type="text" onChange={this.handleMessage} />
            </label>
          </div>
          <div>
            <input type="hidden" name="senderId" value={senderId}/>
            <input type="submit" value="Send"/>
          </div>
        </form>
      </div>
    );
  }
}

export default Invite;
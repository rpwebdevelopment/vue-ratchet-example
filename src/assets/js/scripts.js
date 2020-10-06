let app = new Vue({
   el: '#base',
   data: {
       conn: null,
       noSession: true,
       user: {
           type: 'join',
           msg: ''
       },
       message: {
           type: 'msg',
           msg: ''           
       },
       messages: [],
       userlist: []
   },
   methods: {
        joinChat() {
            if (this.user.msg) {
                this.conn.send(JSON.stringify(this.user));
                this.user.msg = '';
                this.noSession = false;
            }
        },
        sendMessage() {
            if (this.message.msg) {
                this.conn.send(JSON.stringify(this.message));
                this.message.msg = '';
            }
        },
        responseHandler(obj) {
            if (obj.type !== 'userlist' && obj.type !== 'setuser') {
                this.messages.push(obj);
                setInterval(this.updateScroll, 500);
            } else {
                this.userlist = obj.message;
            }
        },
        updateScroll() {
            let container = this.$el.querySelector('#text-window');
            container.scrollTop = container.scrollHeight;
        }
    },
    mounted() {
        this.conn = new WebSocket('ws://localhost:8080');
    }
});

app.conn.onmessage = function(e) {
    if (e.data) {
        app.responseHandler(JSON.parse(e.data))
    }
}
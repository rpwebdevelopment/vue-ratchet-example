<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="src/assets/css/styles.css" />
    </head>
    <body>

        <div id="base">

            <div class="container" id="username-window" v-if="noSession">
                <div class="row my-4">
                    <div class="input-group mb-3">
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Username" 
                            v-model="user.msg"
                            @keyup.enter="joinChat">
                        <div class="input-group-append">
                            <button 
                                class="btn btn-primary" 
                                type="button" 
                                @click="joinChat">Join Chat</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container col-sm-12" id="chat-window" v-else>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="row my-4 ml-2">
                            <div id="text-window" class="col-12">
                                <div id="text-content" class="pt-2">
                                    <p v-for="message in messages" :class="message.type">
                                        {{ message.username }}: {{ message.message }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row ml-2">
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Start chatting..."
                                    v-model="message.msg" 
                                    @keyup.enter="sendMessage">
                                <div class="input-group-append">
                                    <button 
                                        class="btn btn-primary" 
                                        type="button" 
                                        @click="sendMessage">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 my-4">
                        <legend>Active Users</legend>
                        <ul class="list-group" id="user-list">
                            <li 
                                class="list-group-item" 
                                v-for="user in userlist" 
                                v-text="user"></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="src/assets/js/scripts.js" type="text/javascript"></script>

    </body>

</html>
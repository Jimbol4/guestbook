<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <style>
            body        { padding-top:30px; }
            form        { padding-bottom:20px; }
            .comment    { padding-bottom:20px; }
        </style>
    </head>
<body class="container" id="guestbook"> 
        <div class="col-md-8 col-md-offset-2">
            <div class="jumbotron">
                <h2>Lumen and Vue.js Single Page Application</h2>
                <h4>Simple Guestbook</h4>
            </div>

            <form v-on:submit.prevent="create">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="author" v-model="newComment.author" placeholder="Name">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="text" v-model="newComment.text" placeholder="Put here your text">
                </div>

                <div class="form-group text-right">   
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>

             <div class="comment" v-for="comment in comments">
                <h3>Comment #{{ comment.id }} <small>by {{ comment.author }}</h3>
                <p>{{ comment.text }}</p>
                <p><span class="btn btn-primary text-muted" @click="onDelete(comment)">Delete</span></p>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.min.js"></script>
    <script>
        new Vue({
            el: '#guestbook',
            
            data: {
                comments: [],
                text: '',
                author: '',
                id: '',
                newComment: {
                    text: '',
                    author: '',
                    id: ''
                }
            },
            
            ready: function() {
                
                var resource = this.$resource('api/comment/{id}');
                
                resource.get({}, function(comments){
                    this.$set("comments", comments);
                });
            },
            
            methods: {
                
                create: function() {
                   var comment = this.newComment;
                   this.$http.post('/api/comment', comment, function(data){
                   this.comments.push(data);
                   this.newComment = { text: '', author: '', id: '' };
                   });
                },
                
                onDelete: function (comment) {
                    this.$http.delete('/api/comment/' + comment.id, function(){
                        this.comments.$remove(comment);
                    });
                }
            }
        })
        
    </script>
</body>
</html>
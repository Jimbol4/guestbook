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

            <form v-on="submit: onCreate">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="author" v-model="author" placeholder="Name">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="text" v-model="text" placeholder="Put here your text">
                </div>

                <div class="form-group text-right">   
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>

             <div class="comment" v-repeat="comment: comments">
                <h3>Comment #{{ comment.id }} <small>by {{ comment.author }}</h3>
                <p>{{ comment.text }}</p>
                <p><span class="btn btn-primary text-muted" v-on="click: onDelete(comment)">Delete</span></p>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/vue/0.12.1/vue.min.js"></script>
    <script>
        new Vue({
            el: '#guestbook',
            
            data: {
                comments: [],
                text: '',
                author: ''
            },
            
            ready: function() {
                this.getMessages();
            },
            
            methods: {
                getMessages: function() {
                    $.ajax({
                      context: this,
                      url: "/api/comment",
                      success: function (result) {
                          this.$set("comments", result)
                      }
                    })
                },
                
                onCreate: function(e) {
                    e.preventDefault()
                    $.ajax({
                       context: this,
                       type: "POST",
                       data: {
                           author: this.author,
                           text: this.text
                       },
                       url: "/api/comment",
                       success: function(result) {
                           this.comments.push(result);
                           this.author = '';
                           this.text = '';
                       }
                    })
                },
                
                onDelete: function (comment) {
                    $.ajax({
                        context: comment,
                        type: "DELETE",
                        url: "/api/comment/" + comment.id,
                    })
                    this.comments.$remove(comment);
                }
            }
        })
        
    </script>
</body>
</html>
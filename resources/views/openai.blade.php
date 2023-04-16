<!DOCTYPE html>
<html>
<head>
    <title>OpenAI Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
         .inputai {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding-bottom: 20px;
        }

        .outputai {
            height: 420px;
            overflow-y: auto;
        }

        .outputcode{
            background-color: darkslategray ;
            color: #fff;
        }


    </style>
</head>
<body>
   
    <div class="container py-5">
        <h2 class="text-center">Webchat by Rian Hariadi</h2>
        <div class="outputai card mb-5 mx-sm-3 col-md-11 mt-20">
            <div class="card-body" id="output"></div>
        </div>
        <div class="row d-flex justify-content-center mb-2">
            <form class="form-inline">
                <div class="form-group m-2">
                  <label for="inputPassword6">Token &nbsp;</label>
                  <input type="number" value="8000" id="tokeninput" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                <div class="form-group m-2">
                  <label for="modelinput">Model &nbsp;</label>
                  <select class="form-control" id="modelinput">
                    <option value="1">GPT-3.5-turbo</option>
                    <option value="2">GPT-4</option>
                    <option value="3">GPT-2</option>
                    <option value="4">GPT</option>
                    <option value="5">GPT-Neo</option>
                    <option value="6">Codex</option>
                    <option value="7">DALL-E</option>
                    <option value="8">CLIP</option>
                </select>
                </div>

              </form>

        </div>
        <div class="inputai text-center mb-2 col-md-11" >
            <form class="form-inline">
                <div class="form-group mx-sm-3 mb-2" >
                    <textarea class="form-control" id="input" placeholder="Type something..." style="width:700px"></textarea>     
                </div>
                <button type="button" class="btn btn-primary mb-2" id="send-btn">Send</button>
            </form>
        </div>
   
    </div>
    <script>

        var model = $('#modelinput').val();
        // perbarui nilai variabel saat pengguna memilih opsi baru
        $('#modelinput').change(function() {
        model = $(this).val();
        });

    
        var token = $('#tokeninput').val();
        // perbarui nilai variabel saat pengguna memilih opsi baru
        $('#tokeninput').change(function() {
        token = $(this).val();
        });




        $(document).ready(function() {
            // handle send button click event
            $('#send-btn').click(function() {
                sendMessage();
            });

            // handle enter keypress event
            $('#input').keypress(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    sendMessage();
                }
            });

            // function to send message to server
            function sendMessage() {
                console.log('token:',token)
                console.log('model:',model)

                var message = $('#input').val();
                $('#input').val('');
                $('#output').append('<div class="card mb-3"><div class="card-body"><p class="card-text text-right">' + message + '</p></div></div>');
                $.ajax({
                    url: 'chat',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'message': message,
                        'model':model,
                        'token':token,
                    },
                    success: function(data) {
                        var response = data['response'];
                        var res = JSON.parse(data.answer);
                        res = res.choices[0].message.content

                     
                        res = res.replace(/</g, '&lt;');
                        res = res.replace(/>/g, '&gt;');

                        var find = res.search("```");
                        if (find != -1){

                            // var res = res.replace(/```(.|\n)*?```/g, '<div style="background-color:darkslategray; color:#fff; padding:5px;"><code>$1</code></div>');
                            res = res.replace(/'/g, '"');

                            // Buat tag HTML untuk kode dan tambahkan ke teks
                            res = res.replace(/```(.+?)```/gs, '<pre style="background-color:darkslategray; color:#fff; padding:5px;"><code>$1</code></pre>');                          
                        }
                        else{

                            var find1 = res.search('&lt;')
                            var find2 =  res.search('&gt;')
                            if ( (find1 != -1) && (find2 != -1) ){
                                res = '<pre style="background-color:darkslategray; color:#fff; padding:5px;">'+res+'</pre>' ;
                            }

                        }
                        // end of code
                        

                        console.log('res:',res);
                        $('#output').append('<div class="card mb-3"><div class="card-body" style="background-color:lightgreen"><p class="card-text text-left"><pre class="outputinside" style="width:900; white-space: pre-wrap; "></pre></p></div></div>');
                        
                        var i = 0;
                        var txt = res ;
                        var speed = 50 ;
                        var resfinal = ''; 
                        function typeWriter(){
                            if (i < txt.length) {
                                resfinal += txt.charAt(i);
                                i++;
                                $('.outputinside:last').html(resfinal);
                                setTimeout(typeWriter, speed);
                            }
                        }
                        
                        typeWriter();
                       
                    }
                });
            }
        });
    </script>
</body>
</html>

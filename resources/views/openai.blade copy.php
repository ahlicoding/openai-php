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
    </style>
</head>
<body>
   
    <div class="container py-5">
        <h4 class="text-center">Webchat by Rian Hariadi</h4>
        <div class="outputai card mb-5 mx-sm-3 col-md-11 mt-20">
            <div class="card-body" id="output"></div>
        </div>
        <div class="row d-flex justify-content-center mb-2">
            <form class="form-inline">
                <div class="form-group m-2">
                  <label for="inputPassword6">Token &nbsp;</label>
                  <input type="number" id="tokeninput" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                <div class="form-group m-2">
                  <label for="modelinput">Model &nbsp;</label>
                  <select class="form-control" id="modelinput">
                    <option value="davinci">Davinci</option>
                    <option value="babbage">Babbage</option>
                    <option value="curie">Curie</option>
                    <option value="davinci-instruct-beta">Davinci-Instruct-beta</option>
                    <option value="ada:content-filtering">Ada:content-filtering</option>
                    <option value="curie:content-filtering">Curie:content-filtering</option>
                    <option value="gpt-3.5-turbo">GPT-3.5-turbo</option>
                
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
                var message = $('#input').val();
                $('#input').val('');
                $('#output').append('<div class="card mb-3"><div class="card-body"><p class="card-text text-right">' + message + '</p></div></div>');
                $.ajax({
                    url: 'chat',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'message': message,
                        
                    },
                    success: function(data) {
                        var response = data['response'];
                        var res = JSON.parse(data.answer);
                        res = res.choices[0].message.content
                        console.log('res:',res);
                        $('#output').append('<div class="card mb-3"><div class="card-body" style="background-color:lightgreen"><p class="card-text text-left">' + res + '</p></div></div>');
                    }
                });
            }
        });
    </script>
</body>
</html>

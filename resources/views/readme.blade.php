<html> 
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title></title>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
        <script>hljs.initHighlightingOnLoad();</script>

        <style type="text/css">
            body {
                margin: 0px;
                padding: 0px;
                text-align: center;
            }
            #display_content {
                margin-left: auto;
                margin-right: auto;
                text-align: left;
                width: 720px;
            }
        </style>

        <script> 
            $(function(){
                // Load `README.md` and show
                $("#included_content").load("/README.md", function(data) {
                  console.log("the data: ", data)
                    marked.setOptions({
                        gfm: true,
                        tables: true,
                        breaks: false,
                        pedantic: false,
                        sanitize: true,
                        smartLists: true,
                        smartypants: false,
                        langPrefix: '',
                        highlight: function(code, lang) {
                            return code;
                        }
                    });
                    var html_str = marked(data);
                    $("#display_content").html(html_str);

                    // Apply highlight.js again
                    hljs.initHighlighting.called = false;
                    hljs.initHighlighting();
                }); 
            });
        </script> 
    </head> 
    <body> 
        <div id="included_content" style="display:none"></div>
        <div id="display_content"></div>
    </body> 
</html>
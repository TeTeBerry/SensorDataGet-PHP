<script type="text/javascript">

    var url = window.location.search.substr(1);
    console.log(url);
   function QueryStringToJSON(str) {
    var pairs = str.split('&');
    var result = {};
    pairs.forEach(function (pair) {
        pair = pair.split('=');
        var name = pair[0]
        var value = pair[1]
        if (name.length)
            if (result[name] !== undefined) {
                if (!result[name].push) {
                    result[name] = [result[name]];
                }
                result[name].push(value || '');
            } else {
                result[name] = value || '';
            }
    });
    return (result);
}

var obj = QueryStringToJSON(url);

console.log(obj)

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = xhr.responseText;
                console.log(response)
            }
        }
    };

    xhr.open('POST','http://127.0.0.1:8088/react.php', true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
    xhr.send(obj);
    console.log(obj);


</script>

<?php
ob_start();
include('post-esp.data.php');
ob_clean();
 
echo $meter;
?>
